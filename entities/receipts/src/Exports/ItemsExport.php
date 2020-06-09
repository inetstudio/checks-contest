<?php

namespace InetStudio\ReceiptsContest\Receipts\Exports;

use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use InetStudio\ReceiptsContest\Receipts\Contracts\Exports\ItemsExportContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\ItemsServiceContract;

class ItemsExport implements ItemsExportContract
{
    use Exportable;

    protected ItemsServiceContract $itemsService;

    protected array $data = [];

    public function __construct(ItemsServiceContract $itemsService)
    {
        $this->itemsService = $itemsService;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function query()
    {
        return $this->itemsService->getModel()->query()->with(['media', 'status', 'prizes', 'fnsReceipt']);
    }

    public function map($item): array
    {
        $fileUrl = $item->getFirstMediaUrl('images');

        $status = $item->status->name;
        $prizes = ($item->prizes->count() > 0) ? implode(', ', $item->prizes->pluck('name')->toArray()) : '';

        $prizesDates = '';

        foreach ($item->prizes as $prize) {
            $date = '';
            $date .= ($prize->pivot['date_start']) ? Carbon::createFromFormat('Y-m-d H:i:s', $prize->pivot['date_start'])->format('d.m.Y') : '';
            $date .= ($prize->pivot['date_end']) ? ' - '.Carbon::createFromFormat('Y-m-d H:i:s', $prize->pivot['date_end'])->format('d.m.Y') : '';

            $prizesDates .= ', '.$date;
        }

        $confirmed = '';
        foreach ($item->prizes as $prize) {
            $confirmed .= ', '.(($prize->pivot['confirmed'] === 1) ? 'Да' : 'Нет');
        }

        $itemData = $item->additional_info;

        return [
            $item->id,
            $status,
            $item->getJSONData('receipt_data', 'statusReason', ''),
            $prizes,
            trim($prizesDates, ', '),
            trim($confirmed, ', '),
            trim(($itemData['name'] ?? '').' '.($itemData['surname'] ?? '')),
            $itemData['phone'] ?? '',
            $itemData['email'] ?? '',
            Date::dateTimeToExcel($item->created_at),
            ($fileUrl) ? url($fileUrl) : '',
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Статус',
            'Причина отмены',
            'Призы',
            'Дата приза',
            'Победитель подтвержден',
            'Имя',
            'Телефон',
            'E-mail',
            'Дата регистрации',
            'Ссылка на чек',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'J' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }
}
