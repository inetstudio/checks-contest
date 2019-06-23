<?php

namespace InetStudio\ChecksContest\Checks\Exports;

use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ChecksContest\Checks\Contracts\Exports\ItemsExportContract;

/**
 * Class ItemsExport.
 */
class ItemsExport implements ItemsExportContract, FromQuery, WithMapping, WithHeadings, WithColumnFormatting
{
    use Exportable;

    /**
     * @return Builder
     * 
     * @throws BindingResolutionException
     */
    public function query()
    {
        $itemsService = app()->make(
            'InetStudio\ChecksContest\Checks\Contracts\Services\Back\ItemsServiceContract'
        );

        return $itemsService->getModel()->buildQuery(
            [
                'columns' => ['status_id', 'created_at'],
                'relations' => ['media', 'status', 'prizes'],
            ]
        );
    }

    /**
     * @param $item
     *
     * @return array
     */
    public function map($item): array
    {
        $fileUrl = $item->getFirstMediaUrl('images');

        $status = $item->status->name;
        $prize = ($item->prize) ? $item->prize->name : '';

        $prizeDate = '';
        $prizeDate .= ($item['prize_date_start']) ? $item['prize_date_start']->format('d.m.Y') : '';
        $prizeDate .= ($item['prize_date_end']) ? ' - '.$item['prize_date_end']->format('d.m.Y') : '';

        return [
            $item->id,
            $status,
            $prize.(($prizeDate) ? ' ('.$prizeDate.')' : ''),
            Date::dateTimeToExcel($item->created_at),
            url($fileUrl),
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Статус',
            'Приз',
            'Дата регистрации',
            'Ссылка на чек',
        ];
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'D' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }
}
