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

final class MoveToModerationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ReceiptModelContract $receipt;

    protected ModerateServiceContract $moderateService;

    protected StatusModelContract $moderationStatus;

    protected StatusModelContract $preliminarilyApprovedStatus;

    public function __construct(ReceiptModelContract $receipt)
    {
        $this->receipt = $receipt->fresh(['status', 'fnsReceipt']);
    }

    public function handle(
        StatusesServiceContract $statusesService,
        ModerateServiceContract $moderateService
    ) {
        $this->moderateService = $moderateService;

        if ($this->receipt->status->alias !== 'processing') {
            return;
        }

        $this->moderationStatus = $statusesService
            ->getModel()
            ->where('alias', 'moderation')
            ->first();

        if (! $this->moderationStatus) {
            return;
        }

        $this->preliminarilyApprovedStatus = $statusesService
            ->getModel()
            ->where('alias', 'preliminarily_approved')
            ->first();

        if (! $this->preliminarilyApprovedStatus) {
            return;
        }

        if (! $this->receipt->fnsReceipt) {
            $this->moderateItem();
        } else {
            $this->preliminarilyApproveItem();
        }
    }

    protected function moderateItem(): void
    {
        $data = new ModerateItemData(
            [
                'id' => $this->receipt->id,
                'status_id' => $this->moderationStatus->id,
                'receipt_data' => [],
            ]
        );

        $this->moderateService->moderate($data);
    }

    protected function preliminarilyApproveItem(): void
    {
        $data = new ModerateItemData(
            [
                'id' => $this->receipt->id,
                'status_id' => $this->preliminarilyApprovedStatus->id,
                'receipt_data' => [],
            ]
        );

        $this->moderateService->moderate($data);
    }

}
