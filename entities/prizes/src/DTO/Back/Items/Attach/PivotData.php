<?php

declare(strict_types=1);

namespace InetStudio\ReceiptsContest\Prizes\DTO\Back\Items\Attach;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\FlexibleDataTransferObject;
use InetStudio\ReceiptsContest\Prizes\Contracts\DTO\Back\Items\Attach\PivotDataContract;

class PivotData extends FlexibleDataTransferObject implements PivotDataContract
{
    public int $confirmed;

    public ?Carbon $date_start;

    public ?Carbon $date_end;

    public static function prepareData(array $data): self
    {
        return new self([
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
