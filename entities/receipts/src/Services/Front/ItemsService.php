<?php

namespace InetStudio\ReceiptsContest\Receipts\Services\Front;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\Services\ItemsService as BaseItemsService;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Front\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseItemsService implements ItemsServiceContract
{
    /**
     * @var array
     */
    public $stages = [];

    /**
     * Отправлен чек для участия в конкурсе.
     *
     * @param  array  $data
     *
     * @return ReceiptModelContract
     *
     * @throws BindingResolutionException
     */
    public function send(array $data): ReceiptModelContract
    {
        $statusesService = app()->make(
            'InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\ItemsServiceContract'
        );

        $status = $statusesService->getDefaultStatus();

        $itemData = Arr::get($data, 'additional_info');
        $item = $this->saveModel(
            [
                'verify_hash' => md5(time().json_encode($data)),
                'additional_info' => $itemData,
                'status_id' => $status['id'] ?? 0,
            ],
            0
        );

        if (isset($data['receipt_image'])) {
            $name = Str::random(32).'.'.$data['receipt_image']->getClientOriginalExtension();

            $item->addMediaFromRequest('receipt_image')
                ->usingFileName($name)
                ->toMediaCollection('images', 'receipts_contest_receipts');
        }

        event(
            app()->make(
                'InetStudio\ReceiptsContest\Receipts\Contracts\Events\Front\SendItemEventContract',
                compact('item')
            )
        );

        return $item;
    }

    /**
     * Получаем этапы конкурса с победителями.
     *
     * @return array
     */
    public function getContestStages(): array
    {
        $stages = [
            'prizes' => [],
            'totalWinners' => 0,
        ];

        foreach ($this->stages as $stage => $dates) {
            foreach ($dates as $date) {
                $key = $date['start'];
                $key .= ($date['end'] != $date['start']) ? $date['end'] : '';
                $key = md5($key);

                $stages['prizes'][$date['prize']]['stages'][$key] = [
                    'date' => [
                        'start' => $this->formatDate($date['start']),
                        'end' => $this->formatDate($date['end']),
                    ],
                    'winners' => [],
                ];

                $stages['prizes'][$date['prize']]['totalWinners'] = 0;
            }
        }

        $winnersReceipts = $this->getModel()->win([
            'relations' => ['prizes'],
        ])->get();

        foreach ($winnersReceipts as $check) {
            foreach ($check->prizes as $prize) {
                if (isset($stages['prizes'][$prize['alias']]) && $prize->pivot->confirmed == 1) {
                    $key = '';
                    $key .= ($prize->pivot['date_start']) ? Carbon::createFromFormat('Y-m-d H:i:s', $prize->pivot['date_start'])->format('d.m.y') : '';
                    $key .= ($prize->pivot['date_end']) ? Carbon::createFromFormat('Y-m-d H:i:s', $prize->pivot['date_end'])->format('d.m.y') : '';
                    $key = md5($key);

                    $stages['prizes'][$prize['alias']]['stages'][$key]['winners'][] = [
                        'id' => $check->id,
                        'name' => $check->getJSONData('additional_info', 'name', '').' '.$check->getJSONData('additional_info', 'surname', ''),
                        'email' => Str::hideEmail($check->getJSONData('additional_info', 'email', '')),
                        'phone' => $this->hidePhone($check->getJSONData('additional_info', 'phone', '')),
                    ];

                    $stages['prizes'][$prize['alias']]['totalWinners'] += 1;
                    $stages['totalWinners'] += 1;
                }
            }
        }

        return $stages;
    }

    /**
     * Поиск чеков.
     *
     * @param  string  $field
     * @param  string  $search
     * @param  string  $type
     *
     * @return Collection
     */
    public function search(string $field, string $search, string $type): Collection
    {
        $builder = $this->model::where(
            [
                ['additional_info->'.$field, '=', $search],
            ]
        );

        if ($type == 'winner') {
            $builder->whereHas('prizes');
        }

        $items = $builder->get();

        return $items;
    }

    /**
     * Форматируем дату.
     *
     * @param  string  $date
     *
     * @return string
     */
    protected function formatDate(string $date): string
    {
        $formattedDate = Carbon::createFromFormat('d.m.y', $date, 'Europe/Moscow')->format('d.m.Y');

        return Carbon::formatDateToRus($formattedDate);
    }

    /**
     * Получаем
     *
     * @param $phone
     *
     * @return string
     */
    protected function hidePhone($phone): string
    {
        $phone = str_replace(['+', '-', '(', ')', ' '], '', $phone);
        $lastSymbols = substr($phone, -4);

        return '+7 (***) *** '.substr($lastSymbols, 0, 2).' '.substr($lastSymbols, -2);
    }
}