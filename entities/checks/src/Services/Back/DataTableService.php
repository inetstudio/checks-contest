<?php

namespace InetStudio\ChecksContest\Checks\Services\Back;

use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ChecksContest\Checks\Contracts\Models\CheckModelContract;
use InetStudio\ChecksContest\Checks\Contracts\Services\Back\DataTableServiceContract;

/**
 * Class DataTableService.
 */
class DataTableService extends DataTable implements DataTableServiceContract
{
    /**
     * @var CheckModelContract
     */
    protected $model;

    /**
     * DataTableService constructor.
     *
     * @param  CheckModelContract  $model
     */
    public function __construct(CheckModelContract $model)
    {
        $this->model = $model;
    }

    /**
     * Запрос на получение данных таблицы.
     *
     * @return JsonResponse
     *
     * @throws BindingResolutionException
     * @throws Exception
     */
    public function ajax(): JsonResponse
    {
        $transformer = app()->make(
            'InetStudio\ChecksContest\Checks\Contracts\Transformers\Back\Resource\IndexTransformerContract'
        );

        return DataTables::of($this->query())
            ->setTransformer($transformer)
            ->rawColumns(['check', 'status', 'actions'])
            ->make();
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = $this->model->buildQuery(
            [
                'columns' => [
                    'status_id',
                    'created_at',
                    'updated_at',
                ],
                'relations' => ['media', 'status', 'prizes', 'fnsReceipt'],
            ]
        );

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html(): Builder
    {
        /** @var Builder $table */
        $table = app('datatables.html');

        return $table
            ->columns($this->getColumns())
            ->ajax($this->getAjaxOptions())
            ->parameters($this->getParameters());
    }

    /**
     * Получаем колонки.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            ['data' => 'id', 'name' => 'id', 'title' => 'ID'],
            [
                'data' => 'receipt_data',
                'name' => 'receipt_data',
                'title' => 'Чек',
                'orderable' => false,
                'visible' => false,
            ],
            [
                'data' => 'additional_info',
                'name' => 'additional_info',
                'title' => 'Инфо',
                'orderable' => false,
                'visible' => false,
            ],
            ['data' => 'status', 'name' => 'status.name', 'title' => 'Статус', 'orderable' => false],
            [
                'data' => 'moderation',
                'name' => 'moderation',
                'title' => 'Модерация',
                'orderable' => false,
                'searchable' => false,
            ],
            ['data' => 'prizes', 'name' => 'prizes.name', 'title' => 'Призы', 'orderable' => false],
            ['data' => 'check', 'name' => 'check', 'title' => 'Чек', 'orderable' => false, 'searchable' => false],
            ['data' => 'name', 'name' => 'name', 'title' => 'Имя', 'orderable' => false, 'searchable' => false],
            [
                'data' => 'surname',
                'name' => 'surname',
                'title' => 'Фамилия',
                'orderable' => false,
                'searchable' => false,
            ],
            ['data' => 'email', 'name' => 'email', 'title' => 'E-mail', 'orderable' => false, 'searchable' => false],
            ['data' => 'phone', 'name' => 'phone', 'title' => 'Телефон', 'orderable' => false, 'searchable' => false],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Дата создания'],
            ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Дата обновления'],
            [
                'data' => 'actions',
                'name' => 'actions',
                'title' => 'Действия',
                'orderable' => false,
                'searchable' => false,
            ],
        ];
    }

    /**
     * Свойства ajax datatables.
     *
     * @return array
     */
    protected function getAjaxOptions(): array
    {
        return [
            'url' => route('back.checks-contest.checks.data.index'),
            'type' => 'POST',
        ];
    }

    /**
     * Свойства datatables.
     *
     * @return array
     */
    protected function getParameters(): array
    {
        $translation = trans('admin::datatables');

        return [
            'order' => [11, 'desc'],
            'paging' => true,
            'pagingType' => 'full_numbers',
            'searching' => true,
            'info' => false,
            'searchDelay' => 350,
            'language' => $translation,
        ];
    }
}
