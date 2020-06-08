<?php

namespace InetStudio\ReceiptsContest\Receipts\Services\Back;

use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\Services\ItemsService as BaseItemsService;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\ResourceServiceContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\DTO\Back\Resource\Update\ItemDataContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Services\Back\ItemsServiceContract as PrizesServiceContract;
use InetStudio\ReceiptsContest\Products\Contracts\Services\Back\ItemsServiceContract as ProductsServiceContract;

class ResourceService extends BaseItemsService implements ResourceServiceContract
{
    protected ProductsServiceContract $productsService;

    protected PrizesServiceContract $prizesService;

    public function __construct(
        ReceiptModelContract $model,
        ProductsServiceContract $productsService,
        PrizesServiceContract $prizesService
    ) {
        parent::__construct($model);

        $this->productsService = $productsService;
        $this->prizesService = $prizesService;
    }

    public function show(int $id): ReceiptModelContract
    {
        $item = $this->model::with('media', 'status', 'prizes', 'fnsReceipt', 'products')->find($id);

        return $item;
    }

    public function update(ItemDataContract $data): ReceiptModelContract
    {
        $item = $this->model::find($data->id);

        $item->additional_info = $data->additional_info;
        $item->receipt_data = $data->receipt_data;

        $item->save();

        $this->productsService->attach($item, $data->products);
        $this->prizesService->attach($item, $data->prizes);

        $item = $item->fresh();

        event(
            resolve(
                'InetStudio\ReceiptsContest\Receipts\Contracts\Events\Back\ModifyItemEventContract',
                compact('item')
            )
        );

        return $item;
    }

    public function destroy($id): int
    {
        return $this->model::destroy($id);
    }
}
