<?php

namespace InetStudio\ChecksContest\Statuses\Services\Back;

use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ChecksContest\Statuses\Contracts\Models\StatusModelContract;
use InetStudio\ChecksContest\Statuses\Contracts\Services\Back\DataTableServiceContract;

/**
 * Class DataTableService.
 */
class DataTableService extends DataTable implements DataTableServiceContract
{
    /**
     * @var StatusModelContract
     */
    protected $model;

    /**
     * DataTableService constructor.
     *
     * @param  StatusModelContract  $model
     */
    public function __construct(StatusModelContract $model)
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
            'InetStudio\ChecksContest\Statuses\Contracts\Transformers\Back\Resource\IndexTransformerContract'
        );

        return DataTables::of($this->query())
            ->setTransformer($transformer)
            ->rawColumns(['actions'])
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
                'columns' => ['created_at', 'updated_at'],
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
            ['data' => 'name', 'name' => 'name', 'title' => 'Название'],
            ['data' => 'alias', 'name' => 'alias', 'title' => 'Алиас'],
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
            'url' => route('back.checks-contest.statuses.data.index'),
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
            'paging' => true,
            'pagingType' => 'full_numbers',
            'searching' => true,
            'info' => false,
            'searchDelay' => 350,
            'language' => $translation,
        ];
    }
}
