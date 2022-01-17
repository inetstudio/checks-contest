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
use InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\ItemsServiceContract as StatusesServiceContract;

final class ModerateUploadDateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ?CarbonInterface $contestStartDate;

    protected ?CarbonInterface $contestEndDate;

    protected ReceiptModelContract $receipt;

    protected ModerateServiceContract $moderateService;

    protected StatusModelContract $rejectedStatus;

    public function __construct(ReceiptModelContract $receipt)
    {
        $startData = config('receipts_contest_receipts.moderation.start_date', null);
        $endDate = config('receipts_contest_receipts.moderation.end_date', null);

        $this->contestStartDate = ($startData) ? Carbon::parse($startData, 'Europe/Moscow')->setTime(0, 0, 0) : null;
        $this->contestEndDate = ($endDate) ? Carbon::parse($endDate, 'Europe/Moscow')->setTime(0, 0, 0) : null;

        $this->receipt = $receipt->fresh(['status']);
    }

    public function handle(
        StatusesServiceContract $statusesService,
        ModerateServiceContract $moderateService
    ) {
        if (! $this->contestStartDate && ! $this->contestEndDate) {
            return;
        }

        $this->moderateService = $moderateService;

        $this->rejectedStatus = $statusesService
            ->getModel()
            ->where('alias', 'rejected')
            ->first();

        if (! $this->rejectedStatus) {
            return;
        }

        $this->checkUploadDate();
    }

    protected function checkUploadDate(): void
    {
        if ($this->contestStartDate && ! $this->receipt->created_at->greaterThanOrEqualTo($this->contestStartDate)) {
            $this->rejectItem(
                [
                    'statusReason' => 'Загрузка до начала конкурса',
                ]
            );

            return;
        }

        if ($this->contestEndDate && $this->receipt->created_at->greaterThanOrEqualTo($this->contestEndDate)) {
            $this->rejectItem(
                [
                    'statusReason' => 'Загрузка после окончания конкурса',
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
