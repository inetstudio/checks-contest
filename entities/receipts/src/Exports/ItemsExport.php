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
//        $fnsReceipt = $item->fnsReceipt;
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

//        $address = ($fnsReceipt) ? $fnsReceipt->getJSONData('data', 'content.retailPlaceAddress', '') : '';
//        $address = (! $address && $fnsReceipt) ? $fnsReceipt->getJSONData('data', 'address', '') : $address;
//        $address = (! $address) ? $item->getJSONData('additional_info', 'retailPlaceAddress', '') : $address;

//        $placeName = $item->getJSONData('additional_info', 'retailPlaceName', '');

        $userData = $item['additional_info'];

        $statusReason = $item->getJSONData('receipt_data', 'statusReason', '');

        return [
            $item->id,
            $status,
            $statusReason,
            $prizes,
            trim($prizesDates, ', '),
            trim($confirmed, ', '),
            trim(($userData['personal']['surname'] ?? '').' '.($userData['personal']['name'] ?? '').' '.($userData['personal']['middleName'] ?? '')) ?? ($userData['personal']['name'] ?? ''),
            $userData['personal']['phone'] ?? '',
            $userData['personal']['email'] ?? '',
            Date::dateTimeToExcel($item->created_at),
            Date::dateTimeToExcel($item->updated_at),
            ($fileUrl) ? url($fileUrl) : '',
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Статус',
            'Причина отклонения',
            'Призы',
            'Дата приза',
            'Победитель подтвержден',
            'Имя',
            'Телефон',
            'E-mail',
            'Дата регистрации',
            'Дата модерации',
            'Ссылка на чек',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'J' => NumberFormat::FORMAT_DATE_DATETIME,
            'K' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }
}
