<?php

namespace InetStudio\ReceiptsContest\Receipts\Jobs;

use Illuminate\Support\Str;
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

final class ModerateQrCodesDuplicatesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ReceiptModelContract $receipt;

    protected ReceiptsServiceContract $receiptsService;

    protected ModerateServiceContract $moderateService;

    protected StatusModelContract $rejectedStatus;

    public function __construct(ReceiptModelContract $receipt)
    {
        $this->receipt = $receipt;
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

        $this->checkQrDuplicates();
    }

    protected function checkQrDuplicates(): void
    {
        $receiptCodes = $this->receipt->getJSONData('receipt_data', 'codes', []);

        if (empty($receiptCodes)) {
            return;
        }

        foreach ($receiptCodes as $receiptCode) {
            if (($receiptCode['type'] ?? '') === 'QR_CODE') {
                $codeValue = trim($receiptCode['value'] ?? '');

                if (! $codeValue || Str::startsWith($codeValue, 'http')) {
                    continue;
                }

                $currentItemsCount = $this->receiptsService->getModel()
                    ->where('id', '<>', $this->receipt->id)
                    ->where('status_id', '<>', $this->rejectedStatus->id)
                    ->where('receipt_data', 'like', '%'.$codeValue.'%')
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
