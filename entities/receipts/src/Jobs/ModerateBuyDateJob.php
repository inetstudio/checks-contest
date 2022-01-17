<?php

namespace InetStudio\ReceiptsContest\Receipts\Jobs;

use Carbon\CarbonInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
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

final class ModerateBuyDateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ?CarbonInterface $contestStartDate;

    protected ?CarbonInterface $contestEndDate;

    protected ReceiptModelContract $receipt;

    protected ReceiptsServiceContract $receiptsService;

    protected ModerateServiceContract $moderateService;

    protected StatusModelContract $rejectedStatus;

    public function __construct(ReceiptModelContract $receipt)
    {
        $startData = config('receipts_contest_receipts.moderation.start_date', null);
        $endDate = config('receipts_contest_receipts.moderation.end_date', null);

        $this->contestStartDate = ($startData) ? Carbon::parse($startData, 'Europe/Moscow')->setTime(0, 0, 0) : null;
        $this->contestEndDate = ($endDate) ? Carbon::parse($endDate, 'Europe/Moscow')->setTime(0, 0, 0) : null;

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

        $this->checkBuyDate();
    }

    protected function checkBuyDate(): void
    {
        if (! $this->contestStartDate && ! $this->contestEndDate) {
            return;
        }

        $fnsReceipt = $this->receipt->fnsReceipt;

        if (! $fnsReceipt) {
            return;
        }

        $receiptDate = Carbon::parse($fnsReceipt['data']['content']['dateTime']);

        if ($this->contestStartDate && ! $receiptDate->greaterThanOrEqualTo($this->contestStartDate)) {
            $this->rejectItem(
                [
                    'statusReason' => 'Дата покупки не соответствует срокам проведения акции',
                ]
            );

            return;
        }

        if ($this->contestEndDate && $receiptDate->greaterThanOrEqualTo($this->contestEndDate)) {
            $this->rejectItem(
                [
                    'statusReason' => 'Дата покупки не соответствует срокам проведения акции',
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
