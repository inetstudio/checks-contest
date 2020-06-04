<?php

namespace InetStudio\ReceiptsContest\Receipts\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ReceiptsContest\Receipts\Contracts\Console\Commands\SetWinnerCommandContract;

/**
 * Class SetWinnerCommand.
 */
class SetWinnerCommand extends Command implements SetWinnerCommandContract
{
    /**
     * Имя команды.
     *
     * @var string
     */
    protected $name = 'inetstudio:receipts-contest:receipts:winners';

    /**
     * Описание команды.
     *
     * @var string
     */
    protected $description = 'Set checks contest winner';

    /**
     * Опции для определения победителей.
     *
     * @var array
     */
    protected $drawOptions = [];

    /**
     * Запуск команды.
     *
     * @throws BindingResolutionException
     */
    public function handle(): void
    {
        $checksService = app()->make('InetStudio\ReceiptsContest\Receipts\Contracts\Services\Front\ItemsServiceContract');

        $prizesData = $this->getPrizeData($checksService);

        if (empty($prizesData)) {
            return;
        }

        $this->initOptions();

        foreach ($prizesData as $prizeData) {
            $checks = $this->getReceipts($checksService, $prizeData);

            if ($checks->count() == 0) {
                continue;
            }

            $winnersReceipts = $this->getWinnersReceipts($checks, $prizeData);
            $this->attachPrize($winnersReceipts, $prizeData);
        }
    }

    /**
     * Инициализируем необходимые опции.
     */
    protected function initOptions(): void
    {
    }

    /**
     * Получаем данные по призу.
     *
     * @param $checksService
     *
     * @return array
     */
    protected function getPrizeData($checksService): array
    {
        $prizesData = [];

        $nowDate = Carbon::now('Europe/Moscow')->format('d.m.y');
        $stages = $checksService->stages;

        foreach ($stages as $date => $prizes) {
            if ($date == $nowDate) {
                $prizesData = $prizes;

                break;
            }
        }

        return $prizesData;
    }

    /**
     * Получаем чеки, участвующие в розыгрыше.
     *
     * @param $checksService
     * @param  array  $prizeData
     *
     * @return Collection
     *
     * @throws BindingResolutionException
     */
    protected function getReceipts($checksService, array $prizeData): Collection
    {
        $statusesService = app()->make('InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\ItemsServiceContract');
        $prizesService = app()->make('InetStudio\ReceiptsContest\Prizes\Contracts\Services\Front\ItemsServiceContract');

        $prize = $prizesService->getModel()->where('alias', $prizeData['prize'])->first();
        $status = $statusesService->getModel()->where([
            ['alias', '=', 'approved'],
        ])->first();

        if (! $prize || ! $status) {
            return collect([]);
        }

        $prizeId = $prize['id'];

        $winnersEmails = [];
        $winnersPhones = [];
        $winnersReceipts = $checksService->getModel()->with('prizes')
            ->whereHas('prizes', function ($query) use ($prizeId) {
                $query->where('prize_id', '=', $prizeId);
            })->get();

        foreach ($winnersReceipts as $winnerReceipt) {
            $winnersEmails[] = $winnerReceipt->getJSONData('additional_info', 'email');
            $winnersPhones[] = $winnerReceipt->getJSONData('additional_info', 'phone');
        }

        $checks = $checksService->getModel()->with('prizes')->where([
            ['status_id', '=', $status->id],
            ['created_at', '>=', Carbon::createFromFormat('d.m.y', $prizeData['start'])->setTime(0, 0, 0)],
            ['created_at', '<=', Carbon::createFromFormat('d.m.y', $prizeData['end'])->setTime(23, 59, 59)],
        ])->where(function ($query) use ($prizeId) {
            $query->doesntHave('prizes')
                ->orWhereDoesntHave('prizes', function ($prizesQuery) use ($prizeId) {
                    $prizesQuery->where('prize_id', '=', $prizeId);
                });
        })->get();

        $checks = $checks->filter(function ($check) use ($winnersEmails, $winnersPhones) {
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

        return $checks;
    }

    /**
     * Получаем чеки победителей.
     *
     * @param  Collection  $checks
     * @param  array  $prizeData
     *
     * @return Collection
     */
    protected function getWinnersReceipts(Collection $checks, array $prizeData): Collection
    {
        if ($checks <= $prizeData['count']) {
            return $checks;
        }

        $indexes = [];

        for ($i = 1; $i <= $prizeData['count']; $i++) {
            $indexes[] = $i * floor($checks->count() / $prizeData['count']);
        }

        return $checks->filter(function ($value, $key) use ($indexes) {
            return in_array($key, $indexes);
        });
    }

    /**
     * Присваиваем приз победителю.
     *
     * @param  Collection  $checks
     * @param  array  $stageData
     *
     * @throws BindingResolutionException
     */
    protected function attachPrize(Collection $checks, array $stageData): void
    {
        $prizesService = app()->make('InetStudio\ReceiptsContest\Prizes\Contracts\Services\Front\ItemsServiceContract');
        $prize = $prizesService->getModel()->where('alias', $stageData['prize'])->first();

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

        $checks->each(function ($check) use ($prizeData) {
            $check->prizes()->attach($prizeData);
        });
    }
}
