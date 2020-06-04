<?php

namespace InetStudio\ReceiptsContest\Receipts\Exports;

use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use InetStudio\ReceiptsContest\Receipts\Contracts\Exports\ItemsFullExportContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\ItemsServiceContract;

class ItemsFullExport implements ItemsFullExportContract, FromQuery, WithMapping, WithHeadings, WithColumnFormatting
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
        return $this->itemsService->getModel()->query()->with(['media', 'status', 'prizes', 'products', 'fnsReceipt']);
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
            $confirmed .= ', '.(($prize->pivot['confirmed'] == 1) ? 'Да' : 'Нет');
        }

        $products = $item->products;

        $data = [];

        if (count($products) > 0) {
            foreach ($products ?? [] as $index => $product) {
                $rowData = array_fill(0, 18, '');
                if ($index == 0) {
                    $discount = $item->getJSONData('receipt_data', 'discountSum', 0);
                    $discount = str_replace(',', '.', $discount);
                    $discount = (! is_numeric($discount)) ? 0 : $discount;
                    $discount = (float) number_format($discount, 2, '.', '');

                    $rowData[0] = $item->id;
                    $rowData[1] = $status;
                    $rowData[2] = ($item->getJSONData('receipt_data', 'duplicate', '') == 'true') ? 'Дубликат' : $item->getJSONData('receipt_data', 'denyReason', '');
                    $rowData[3] = $prizes;
                    $rowData[4] = trim($prizesDates, ', ');
                    $rowData[5] = trim($confirmed, ', ');
                    $rowData[6] = $item->getJSONData('additional_info', 'name', '');
                    $rowData[7] = $item->getJSONData('additional_info', 'phone', '');
                    $rowData[8] = $item->getJSONData('receipt_data', 'cityName', '');
                    $rowData[9] = Date::dateTimeToExcel($item['created_at']);
                    $rowData[10] = url($fileUrl);
                    $rowData[11] = $item->getJSONData('receipt_data', 'retailName', '');
                    $rowData[16] = $discount;
                    $rowData[17] = $products->sum('sum') - $discount;
                }

                $rowData[12] = $product->getJSONData('product_data', 'category', '');
                $rowData[13] = $product['name'];
                $rowData[14] = $product['quantity'];
                $rowData[15] = $product['price_formatted'];

                $data[] = $rowData;
            }
        } else {
            $rowData = array_fill(0, 18, '');
            $rowData[0] = $item->id;
            $rowData[1] = $status;
            $rowData[2] = ($item->getJSONData('receipt_data', 'duplicate', '') == 'true') ? 'Дубликат' : $item->getJSONData('receipt_data', 'denyReason', '');
            $rowData[3] = $prizes;
            $rowData[4] = trim($prizesDates, ', ');
            $rowData[5] = trim($confirmed, ', ');
            $rowData[6] = $item->getJSONData('additional_info', 'name', '');
            $rowData[7] = $item->getJSONData('additional_info', 'phone', '');
            $rowData[8] = $item->getJSONData('receipt_data', 'cityName', '');
            $rowData[9] = Date::dateTimeToExcel($item['created_at']);
            $rowData[10] = url($fileUrl);
            $rowData[11] = $item->getJSONData('receipt_data', 'retailName', '');
            $rowData[16] = $item->getJSONData('receipt_data', 'discountSum', 0);
            $rowData[17] = $products->sum('sum') - $item->getJSONData('receipt_data', 'discountSum', 0);

            $data[] = $rowData;
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Статус чека',
            'Причина отмены',
            'Призы',
            'Дата приза',
            'Победитель подтвержден',
            'Имя',
            'Телефон',
            'Город',
            'Дата регистрации',
            'Ссылка на чек',
            'Сеть',
            'Категория товара',
            'Название продукта',
            'Количество продуктов',
            'Цена продукта (за единицу товара), руб.',
            'Скидка, руб.',
            'Общая сумма чека, руб.',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'J' => NumberFormat::FORMAT_DATE_DATETIME,
            'P' => NumberFormat::FORMAT_NUMBER_00,
            'Q' => NumberFormat::FORMAT_NUMBER_00,
            'R' => NumberFormat::FORMAT_NUMBER_00,
        ];
    }
}
