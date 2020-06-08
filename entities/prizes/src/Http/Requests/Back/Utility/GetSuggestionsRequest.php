<?php

namespace InetStudio\ReceiptsContest\Prizes\Http\Requests\Back\Utility;

use Illuminate\Foundation\Http\FormRequest;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Requests\Back\Utility\GetSuggestionsRequestContract;

class GetSuggestionsRequest extends FormRequest implements GetSuggestionsRequestContract
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
