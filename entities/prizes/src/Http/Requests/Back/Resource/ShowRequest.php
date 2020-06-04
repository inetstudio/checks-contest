<?php

namespace InetStudio\ReceiptsContest\Prizes\Http\Requests\Back\Resource;

use Illuminate\Foundation\Http\FormRequest;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Requests\Back\Resource\ShowRequestContract;

class ShowRequest extends FormRequest implements ShowRequestContract
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
