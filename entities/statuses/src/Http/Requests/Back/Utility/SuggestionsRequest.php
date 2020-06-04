<?php

namespace InetStudio\ReceiptsContest\Statuses\Http\Requests\Back\Utility;

use Illuminate\Foundation\Http\FormRequest;
use InetStudio\ReceiptsContest\Statuses\Contracts\Http\Requests\Back\Utility\SuggestionsRequestContract;

class SuggestionsRequest extends FormRequest implements SuggestionsRequestContract
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
