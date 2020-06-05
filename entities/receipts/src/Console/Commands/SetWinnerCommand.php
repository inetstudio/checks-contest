<?php

namespace InetStudio\ReceiptsContest\Receipts\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use InetStudio\ReceiptsContest\Receipts\Contracts\Console\Commands\SetWinnerCommandContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Services\Front\ItemsServiceContract as PrizesServiceContract;
use InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\ItemsServiceContract as StatusesServiceContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Front\ItemsServiceContract as ReceiptsServiceContract;

class SetWinnerCommand extends Command implements SetWinnerCommandContract
{
    protected $name = 'inetstudio:receipts-contest:receipts:winners';

    protected $description = 'Set receipts contest winner';

    protected array $drawOptions = [];

    protected ReceiptsServiceContract $receiptsService;

    protected StatusesServiceContract $statusesService;

    protected PrizesServiceContract $prizesService;

    public function __construct(ReceiptsServiceContract $receiptsService, StatusesServiceContract $statusesService, PrizesServiceContract $prizesService)
    {
        parent::__construct();

        $this->receiptsService = $receiptsService;
        $this->statusesService = $statusesService;
        $this->prizesService = $prizesService;
    }

    public function handle(): void
    {
        $prizesData = $this->getPrizeData();

        if (empty($prizesData)) {
            return;
        }

        $this->initOptions();

        foreach ($prizesData as $prizeData) {
            $receipts = $this->getReceipts($prizeData);

            if ($receipts->count() == 0) {
                continue;
            }

            $winnersReceipts = $this->getWinnersReceipts($receipts, $prizeData);
            $this->attachPrize($winnersReceipts, $prizeData);
        }
    }

    protected function initOptions(): void
    {
    }

    protected function getPrizeData(): array
    {
        $prizesData = [];

        $nowDate = Carbon::now('Europe/Moscow')->format('d.m.y');
        $stages = $this->receiptsService->stages;

        foreach ($stages as $date => $prizes) {
            if ($date == $nowDate) {
                $prizesData = $prizes;

                break;
            }
        }

        return $prizesData;
    }

    protected function getReceipts(array $prizeData): Collection
    {
        $prize = $this->prizesService->getModel()->where('alias', $prizeData['prize'])->first();
        $statuses = $this->statusesService->getItemsByType('draw');

        if (! $prize || $statuses->count() === 0) {
            return collect([]);
        }

        $prizeId = $prize['id'];

        $winnersEmails = [];
        $winnersPhones = [];
        $winnersReceipts = $this->receiptsService->getModel()->with('prizes')
            ->whereHas('prizes', function ($query) use ($prizeId) {
                $query->where('prize_id', '=', $prizeId);
            })->get();

        foreach ($winnersReceipts as $winnerReceipt) {
            $winnersEmails[] = $winnerReceipt->getJSONData('additional_info', 'email');
            $winnersPhones[] = $winnerReceipt->getJSONData('additional_info', 'phone');
        }

        $receipts = $this->receiptsService->getModel()->with('prizes')
            ->whereIn('status_id', $statuses->pluck('id')->toArray())
            ->where([
                ['created_at', '>=', Carbon::createFromFormat('d.m.y', $prizeData['start'])->setTime(0, 0, 0)],
                ['created_at', '<=', Carbon::createFromFormat('d.m.y', $prizeData['end'])->setTime(23, 59, 59)],
            ])->where(function ($query) use ($prizeId) {
                $query->doesntHave('prizes')
                    ->orWhereDoesntHave('prizes', function ($prizesQuery) use ($prizeId) {
                        $prizesQuery->where('prize_id', '=', $prizeId);
                    });
            })->get();

        $receipts = $receipts->filter(function ($check) use ($winnersEmails, $winnersPhones) {
            $email = $check->getJSONData('additional_info', 'email');
            $phone = $check->getJSONData('additional_info', 'phone');

            if ($email && in_array($email, $winnersEmails)) {
                return false;
            }

            if ($phone && in_array($phone, $winnersPhones)) {
                return false;
            }

            return true;
        })->values();

        return $receipts;
    }

    protected function getWinnersReceipts(Collection $receipts, array $prizeData): Collection
    {
        $indexes = [];

        if ($receipts->count() <= $prizeData['count']) {
            $indexes = range(0, $receipts->count() - 1);
        } else {
            for ($i = 1; $i <= $prizeData['count']; $i++) {
                $indexes[] = (int) ($i * floor($receipts->count() / $prizeData['count'])) - 1;
            }
        }

        $winnersPhones = [];
        $winnersEmails = [];
        $winnersChecks = collect();

        foreach ($receipts as $index => $receipt) {
            if (in_array($index, $indexes)) {
                $data = $receipt->additional_info;

                if (! (in_array($data['phone'], $winnersPhones)) && ! (in_array($data['email'], $winnersEmails))) {
                    $winnersPhones[] = $data['phone'];
                    $winnersEmails[] = $data['email'];

                    $winnersChecks->push($receipt);
                } elseif ($index == ($receipts->count() - 1)) {
                    $previousIndex = $this->getPreviousIndex($index, $indexes);

                    if (isset($receipts[$previousIndex])) {
                        $winnersChecks->push($receipts[$previousIndex]);
                    }
                } else {
                    $indexes[] = $this->getNextIndex($index, $indexes);
                }
            }
        }

        return $winnersChecks;
    }

    protected function attachPrize(Collection $receipts, array $stageData): void
    {
        $prize = $this->prizesService->getModel()->where('alias', $stageData['prize'])->first();

        if (! $prize) {
            return;
        }

        $prizeData = [
            $prize->id => [
                'date_start' => Carbon::createFromFormat('d.m.y', $stageData['start'])->format('Y-m-d H:i:s'),
                'date_end' => ($stageData['end'] != $stageData['start'])
                    ? Carbon::createFromFormat('d.m.y', $stageData['end'])->format('Y-m-d H:i:s')
                    : null,
                'confirmed' => $stageData['confirmed'] ?? 0,
            ],
        ];

        $receipts->each(function ($check) use ($prizeData) {
            $check->prizes()->attach($prizeData);
        });
    }

    protected function getNextIndex(int $index, array $indexes): int
    {
        while (in_array($index, $indexes)) {
            $index++;
        }

        return $index;
    }

    protected function getPreviousIndex(int $index, array $indexes): int
    {
        while (in_array($index, $indexes)) {
            $index--;
        }

        return $index;
    }
}
