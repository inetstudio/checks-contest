<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Requests\Back\Moderation;

use Illuminate\Foundation\Http\FormRequest;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Back\Moderation\ModerateRequestContract;

class ModerateRequest extends FormRequest implements ModerateRequestContract
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
