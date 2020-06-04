<?php

declare(strict_types=1);

namespace InetStudio\ReceiptsContest\Receipts\DTO;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Ramsey\Uuid\UuidInterface;
use Spatie\DataTransferObject\FlexibleDataTransferObject;
use InetStudio\ReceiptsContest\Prizes\DTO\ItemData as PrizeItemData;
use InetStudio\ReceiptsContest\Receipts\Contracts\DTO\ItemDataContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;

class ItemData extends FlexibleDataTransferObject implements ItemDataContract
{
    public int $id = 0;

    public int $user_id = 0;
    public int $fns_receipt_id = 0;

    public UuidInterface $uuid;

    public string $social_type = '';

    public int $social_id = 0;

    public int $status_id = 1;

    public array $search_data = [];

    public array $additional_info = [];

    /**
     * @var \InetStudio\ReceiptsContest\Prizes\DTO\ItemData[]|null
     */
    public $prizes = null;

    /**
     * @var \InetStudio\ReceiptsContest\Statuses\DTO\ItemData
     */
    public $status = null;

    public static function prepareData(array $data): self
    {
        return new self([
            'id' => (int) Arr::get($data, 'id', 0),
            'uuid' => (Arr::has($data, 'uuid')) ? Uuid::fromString(Arr::get($data, 'uuid')) : Str::uuid(),
            'social_type' => trim(strip_tags(Arr::get($data, 'social_type', ''))),
            'social_id' => (int) Arr::get($data, 'social_id', 0),
            'status_id' => (int) Arr::get($data, 'status_id', 1),
            'search_data' => Arr::wrap(Arr::get($data, 'search_data', [])),
            'additional_info' => Arr::wrap(Arr::get($data, 'additional_info', [])),
            'prizes' => Arr::has($data, 'prizes')
                ? collect(Arr::get($data, 'prizes'))->map(function ($item) {
                    return PrizeItemData::prepareData($item);
                })->toArray()
                : null,
            'status' => Arr::get($data, 'status'),
        ]);
    }

    public static function fromItem(ReceiptModelContract $item): self
    {
        $data = $item->toArray();
        $data['uuid'] = Uuid::fromString($data['uuid']);

        return new self($data);
    }
}
