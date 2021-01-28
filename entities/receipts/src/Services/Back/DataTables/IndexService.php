<?php

declare(strict_types=1);

namespace InetStudio\ReceiptsContest\Receipts\Services\Back\DataTables;

use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\DataTables\IndexServiceContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Resources\Back\Resource\Index\ItemResourceContract;

class IndexService extends DataTable implements IndexServiceContract
{
    protected ReceiptModelContract $model;

    protected ItemResourceContract $resource;

    public function __construct(ReceiptModelContract $model)
    {
        $this->model = $model;
        $this->resource = resolve(
            ItemResourceContract::class,
            [
                'resource' => null,
            ]
        );
    }

    public function ajax(): JsonResponse
    {
        return DataTables::of($this->query())
            ->setTransformer(function ($item) {
                return $this->resource::make($item)->resolve();
            })
            ->make();
    }

    public function query()
    {
        return $this->model->query()->with(['media', 'status', 'status.classifiers', 'prizes', 'fnsReceipt']);
    }

    public function html(): Builder
    {
        /** @var Builder $table */
        $table = app('datatables.html');

        return $table
            ->columns($this->getColumns())
            ->ajax($this->getAjaxOptions())
            ->parameters($this->getParameters());
    }

    protected function getColumns(): array
    {
        return [
            ['data' => 'id', 'name' => 'id', 'title' => 'ID', 'className' => 'receipt-id'],
            [
                'data' => 'receipt_data',
                'name' => 'receipt_data',
                'title' => 'Чек',
                'orderable' => false,
                'visible' => false,
                'className' => 'receipt-receipt_data',
            ],
            [
                'data' => 'fnsReceipt',
                'name' => 'fnsReceipt.data',
                'title' => 'Чек ФНС',
                'orderable' => false,
                'visible' => false,
                'className' => 'receipt-fnsReceipt',
            ],
            [
                'data' => 'additional_info',
                'name' => 'additional_info',
                'title' => 'Инфо',
                'orderable' => false,
                'visible' => false,
                'className' => 'receipt-additional_info',
            ],
            ['data' => 'status', 'name' => 'status.name', 'title' => 'Статус', 'orderable' => false, 'className' => 'receipt-status'],
            [
                'data' => 'moderation',
                'name' => 'moderation',
                'title' => 'Модерация',
                'orderable' => false,
                'searchable' => false,
                'className' => 'receipt-moderation',
            ],
            ['data' => 'prizes', 'name' => 'prizes.name', 'title' => 'Призы', 'orderable' => false, 'className' => 'receipt-prizes'],
            ['data' => 'receipt_image', 'name' => 'receipt_image', 'title' => 'Чек', 'orderable' => false, 'searchable' => false, 'className' => 'receipt-receipt_image'],
            ['data' => 'name', 'name' => 'name', 'title' => 'Имя', 'orderable' => false, 'searchable' => false, 'className' => 'receipt-name'],
            [
                'data' => 'surname',
                'name' => 'surname',
                'title' => 'Фамилия',
                'orderable' => false,
                'searchable' => false,
                'className' => 'receipt-surname',
            ],
            ['data' => 'email', 'name' => 'email', 'title' => 'E-mail', 'orderable' => false, 'searchable' => false, 'className' => 'receipt-email'],
            ['data' => 'phone', 'name' => 'phone', 'title' => 'Телефон', 'orderable' => false, 'searchable' => false, 'className' => 'receipt-phone'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Дата создания', 'className' => 'receipt-created_at'],
            ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Дата обновления', 'className' => 'receipt-updated_at'],
            [
                'data' => 'actions',
                'name' => 'actions',
                'title' => 'Действия',
                'orderable' => false,
                'searchable' => false,
                'className' => 'receipt-actions',
            ],
        ];
    }

    protected function getAjaxOptions(): array
    {
        return [
            'url' => route('back.receipts-contest.receipts.data.index'),
            'type' => 'POST',
        ];
    }

    protected function getParameters(): array
    {
        $translation = trans('admin::datatables');

        return [
            'order' => [12, 'desc'],
            'paging' => true,
            'pagingType' => 'full_numbers',
            'searching' => true,
            'info' => false,
            'searchDelay' => 350,
            'language' => $translation,
        ];
    }
}
