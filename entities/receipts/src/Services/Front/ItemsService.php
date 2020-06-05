<?php

namespace InetStudio\ReceiptsContest\Receipts\Services\Front;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use InetStudio\ReceiptsContest\Receipts\DTO\Front\SendItemData;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\Services\ItemsService as BaseItemsService;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Front\ItemsServiceContract;

class ItemsService extends BaseItemsService implements ItemsServiceContract
{
    public array $stages = [];

    public function send(SendItemData $data): ?ReceiptModelContract
    {
        $item = $this->model::updateOrCreate(
            [
                'id' => $data->id,
            ],
            $data->except('id', 'image')->toArray()
        );

        if ($item && $data->image) {
            $name = Str::random(32).'.'.$data->image->getClientOriginalExtension();

            $item->addMedia($data->image)
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

    public function search(string $field, string $query, string $type): Collection
    {
        $builder = $this->model::where(
            [
                ['additional_info->'.$field, '=', $query],
            ]
        );

        if ($type == 'winner') {
            $builder->whereHas('prizes');
        }

        return $builder->get();
    }

    protected function formatDate(string $date): string
    {
        $formattedDate = Carbon::createFromFormat('d.m.y', $date, 'Europe/Moscow')->format('d.m.Y');

        return Carbon::formatDateToRus($formattedDate);
    }

    protected function hidePhone(string $phone): string
    {
        $phone = str_replace(['+', '-', '(', ')', ' '], '', $phone);
        $lastSymbols = substr($phone, -4);

        return '+7 (***) *** '.substr($lastSymbols, 0, 2).' '.substr($lastSymbols, -2);
    }
}
