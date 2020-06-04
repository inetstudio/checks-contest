<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Requests\Back\Export;

use Illuminate\Foundation\Http\FormRequest;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Back\Export\ExportItemsRequestContract;

class ExportItemsRequest extends FormRequest implements ExportItemsRequestContract
{
    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [];
    }

    public function rules(): array
    {
        return [];
    }
}
