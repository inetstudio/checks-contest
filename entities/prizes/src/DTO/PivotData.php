<?php

namespace InetStudio\ReceiptsContest\Prizes\DTO;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\FlexibleDataTransferObject;
use InetStudio\ReceiptsContest\Prizes\Contracts\DTO\ItemDataContract;

class PivotData extends FlexibleDataTransferObject implements ItemDataContract
{
    public int $receipt_id;

    public int $prize_id;

    public int $confirmed;

    public ?Carbon $date_start;

    public ?Carbon $date_end;

    public static function prepareData(array $data): self
    {
        return new self([
            'receipt_id' => (int) Arr::get($data, 'receipt_id', 0),
            'prize_id' => (int) Arr::get($data, 'prize_id', 0),
            'confirmed' => (int) Arr::get($data, 'confirmed', 0),
            'date_start' => Arr::get($data, 'date_start', null)
                ? Carbon::parse(Arr::get($data, 'date_start'))->setTimezone(config('app.timezone'))
                : null,
            'date_end' => Arr::get($data, 'date_end', null)
                ? Carbon::parse(Arr::get($data, 'date_end'))->setTimezone(config('app.timezone'))
                : null,
        ]);
    }
}
