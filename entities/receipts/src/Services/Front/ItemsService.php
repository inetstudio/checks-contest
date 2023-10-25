<?php

namespace InetStudio\ReceiptsContest\Receipts\Services\Front;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\DTO\Front\SendItemDataContract;
use InetStudio\ReceiptsContest\Receipts\Services\ItemsService as BaseItemsService;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Front\ItemsServiceContract;

class ItemsService extends BaseItemsService implements ItemsServiceContract
{
    public array $stages = [];

    public function send(SendItemDataContract $data): ?ReceiptModelContract
    {
        $item = new $this->model;

        $item->verify_hash = $data->verify_hash;
        $item->additional_info = $data->additional_info;
        $item->user_id = $data->user_id;
        $item->status_id = $data->status_id;

        $item->save();

        if ($item && $data->image) {
            $name = Str::random(32).'.'.$data->image->getClientOriginalExtension();

            $item->addMedia($data->image)
                ->usingFileName($name)
                ->toMediaCollection('images', 'receipts_contest_receipts');
        }

        event(
            resolve(
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

        $winnersReceipts = $this->getModel()->whereHas('prizes', function ($prizesQuery) {
            $prizesQuery->where('receipts_contest_receipts_prizes.confirmed', 1);
        })->get();

        foreach ($winnersReceipts as $receipt) {
            foreach ($receipt->prizes as $prize) {
                if (isset($stages['prizes'][$prize['alias']]) && $prize->pivot->confirmed === 1) {
                    $dateStart = ($prize->pivot['date_start']) ? Carbon::createFromFormat('Y-m-d H:i:s', $prize->pivot['date_start'])->format('d.m.y') : '';
                    $dateEnd = ($prize->pivot['date_end']) ? Carbon::createFromFormat('Y-m-d H:i:s', $prize->pivot['date_end'])->format('d.m.y') : '';

                    $key = '';
                    $key .= $dateStart;
                    $key .= ($dateStart != $dateEnd) ? $dateEnd : '';
                    $key = md5($key);

                    $stages['prizes'][$prize['alias']]['stages'][$key]['winners'][] = [
                        'id' => $receipt->id,
                        'name' => $receipt->getJSONData('additional_info', 'name', '').' '.$receipt->getJSONData('additional_info', 'surname', ''),
                        'email' => Str::hideEmail($receipt->getJSONData('additional_info', 'email', '')),
                        'phone' => $this->hidePhone($receipt->getJSONData('additional_info', 'phone', '')),
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
        if ($field === 'phone') {
            $query = str_replace(['+', '-', '(', ')', ' '], '', $query);
        }

        $builder = $this->model::where(
            [
                ['additional_info->personal->'.$field, '=', $query],
            ]
        );

        if ($type === 'winner') {
            $statusesService = resolve(
                'InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\ItemsServiceContract'
            );

            $status = $statusesService->getItemsByType('final')->first();

            $builder->whereHas('prizes', function ($prizesQuery) {
                $prizesQuery->where('confirmed', 1);
            })->where('status_id', $status->id);
        }

        return $builder->get();
    }

    public function getWinners(int $page = 0, int $limit = 9999): LengthAwarePaginator
    {
        $statusesService = resolve(
            'InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\ItemsServiceContract'
        );

        $status = $statusesService->getItemsByType('final')->first();

        return $this->model::with('prizes')
            ->whereHas('prizes', function ($prizesQuery) {
                $prizesQuery->where('confirmed', 1);
            })
            ->where('status_id', $status->id)
            ->orderBy('created_at')
            ->paginate($limit, ['*'], 'page', $page);
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
