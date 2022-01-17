<?php

namespace InetStudio\ReceiptsContest\Receipts\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use InetStudio\ReceiptsContest\Statuses\Contracts\Models\StatusModelContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\ModerateServiceContract;
use InetStudio\ReceiptsContest\Receipts\DTO\Back\Moderation\Moderate\ItemData as ModerateItemData;
use InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\ItemsServiceContract as StatusesServiceContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\ItemsServiceContract as ReceiptsServiceContract;

final class ModerateFnsDuplicatesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ReceiptModelContract $receipt;

    protected ReceiptsServiceContract $receiptsService;

    protected ModerateServiceContract $moderateService;

    protected StatusModelContract $rejectedStatus;

    public function __construct(ReceiptModelContract $receipt)
    {
        $this->receipt = $receipt->fresh(['status', 'fnsReceipt']);
    }

    public function handle(
        StatusesServiceContract $statusesService,
        ReceiptsServiceContract $receiptsService,
        ModerateServiceContract $moderateService
    ) {
        $this->receiptsService = $receiptsService;
        $this->moderateService = $moderateService;

        if ($this->receipt->status->alias === 'rejected') {
            return;
        }

        $this->rejectedStatus = $statusesService
            ->getModel()
            ->where('alias', 'rejected')
            ->first();

        if (! $this->rejectedStatus) {
            return;
        }

        $this->checkFnsDuplicates();
    }

    protected function checkFnsDuplicates(): void
    {
        $fnsReceipt = $this->receipt->fnsReceipt;

        if (! $fnsReceipt) {
            return;
        }

        $hash = $fnsReceipt->hash;

        $currentItemsCount = $this->receiptsService->getModel()
            ->where('status_id', '<>', $this->rejectedStatus->id)
            ->whereHas('fnsReceipt', function ($query) use ($hash, $fnsReceipt) {
                $query->where('hash', '=', $hash)->where('id', '<>', $fnsReceipt->id);
            })
            ->count();

        if ($currentItemsCount > 0) {
            $this->rejectItem(
                [
                    'statusReason' => 'Дубликат',
                    'duplicate' => true
                ]
            );
        }
    }

    protected function rejectItem(array $receiptData = []): void
    {
        $data = new ModerateItemData(
            [
                'id' => $this->receipt->id,
                'status_id' => $this->rejectedStatus->id,
                'receipt_data' => $receiptData,
            ]
        );

        $this->moderateService->moderate($data);
    }
}
