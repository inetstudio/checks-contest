<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class GetWinnersRequest extends FormRequest
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
