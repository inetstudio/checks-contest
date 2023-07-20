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
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\ItemsServiceContract as ReceiptsServiceContract;
use InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\ItemsServiceContract as StatusesServiceContract;

final class ModerateReceiptUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ReceiptModelContract $receipt;

    protected array $retails = [];

    protected ReceiptsServiceContract $receiptsService;

    protected ModerateServiceContract $moderateService;

    protected StatusModelContract $rejectedStatus;

    public function __construct(ReceiptModelContract $receipt)
    {
        $this->receipt = $receipt->fresh(['status', 'fnsReceipt']);
        $this->retails = config('receipts_contest_receipts.moderation.retails', []);
    }

    public function handle(
        StatusesServiceContract $statusesService,
        ReceiptsServiceContract $receiptsService,
        ModerateServiceContract $moderateService
    ) {
        if (empty($this->retails)) {
            return;
        }

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

        $this->checkReceiptUser();
    }

    protected function checkReceiptUser(): void
    {
        $fnsReceipt = $this->receipt->fnsReceipt;

        if (! $fnsReceipt) {
            return;
        }

        $receiptFromRetails = false;

        foreach ($this->retails as $retail => $search) {
            if (isset($fnsReceipt['data']['user']) && (mb_strpos(mb_strtolower($fnsReceipt['data']['user']), $search) !== false)) {
                $receiptFromRetails = true;
            }
        }

        if (! $receiptFromRetails) {
            $this->rejectItem(
                [
                    'statusReason' => 'Место покупки не участвует в розыгрыше',
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
