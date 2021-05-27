<?php

declare(strict_types=1);

namespace InetStudio\ReceiptsContest\Receipts\DTO\Back\Resource\Update;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;
use InetStudio\ReceiptsContest\Prizes\DTO\Back\Items\Attach\ItemData as PrizeData;
use InetStudio\ReceiptsContest\Products\DTO\Back\Items\Attach\ItemData as ProductData;
use InetStudio\ReceiptsContest\Prizes\DTO\Back\Items\Attach\PivotData as PrizePivotData;
use InetStudio\ReceiptsContest\Receipts\Contracts\DTO\Back\Resource\Update\ItemDataContract;
use InetStudio\ReceiptsContest\Prizes\DTO\Back\Items\Attach\ItemsCollection as PrizesCollection;
use InetStudio\ReceiptsContest\Products\DTO\Back\Items\Attach\ItemsCollection as ProductsCollection;

class ItemData extends DataTransferObject implements ItemDataContract
{
    public int $id;

    public array $additional_info;

    public array $receipt_data;

    /** @var \InetStudio\ReceiptsContest\Products\DTO\Back\Items\Attach\ItemData[] */
    #[CastWith(ArrayCaster::class, itemType: ProductData::class)]
    public array $products;

    /** @var \InetStudio\ReceiptsContest\Prizes\DTO\Back\Items\Attach\ItemData[] */
    #[CastWith(ArrayCaster::class, itemType: PrizeData::class)]
    public array $prizes;

    public static function fromRequest(Request $request): self
    {
        $data = [
            'id' => $request->input('id'),
            'additional_info' => $request->input('additional_info', []),
            'receipt_data' => $request->input('receipt_data', []),
            'products' => [],
            'prizes' => [],
        ];

        foreach ($request->input('products', []) as $product) {
            $data['products'][] = new ProductData($product);
        }

        foreach ($request->input('prizes', []) as $prize) {
            $data['prizes'][] = new PrizeData(
                [
                    'id' => $prize['id'],
                    'pivot' => PrizePivotData::prepareData($prize['pivot'])
                ]
            );
        }

        return new self($data);
    }
}
