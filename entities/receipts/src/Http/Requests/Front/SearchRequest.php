<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;
use InetStudio\CaptchaPackage\Captcha\Validation\Rules\CaptchaRule;
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
            'g-recaptcha-response.required' => 'Поле «Капча» обязательно для заполнения',
            'g-recaptcha-response.captcha' => 'Неверный код капча',
        ];
    }

    public function rules(): array
    {
        return ($this->route('type') === 'status')
            ? [
                'g-recaptcha-response' => [
                    'required',
                    new CaptchaRule,
                ],
            ]
            : [];
    }
}
