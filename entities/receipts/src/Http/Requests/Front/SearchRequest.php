<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Front\SearchRequestContract;

class SearchRequest extends FormRequest implements SearchRequestContract
{
    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
        ];
    }

    public function rules(): array
    {
        return [
        ];
    }
}
