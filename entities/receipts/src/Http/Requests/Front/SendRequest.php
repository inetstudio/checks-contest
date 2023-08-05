<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;
use InetStudio\CaptchaPackage\Captcha\Validation\Rules\CaptchaRule;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Front\SendRequestContract;

class SendRequest extends FormRequest implements SendRequestContract
{
    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'additional_info.personal.name.required' => 'Поле обязательно для заполнения',
            'additional_info.personal.name.max' => 'Поле не должно превышать 255 символов',

            'additional_info.personal.phone.required' => 'Поле обязательно для заполнения',
            'additional_info.personal.phone.max' => 'Поле не должно превышать 255 символов',

            'additional_info.personal.email.required' => 'Поле обязательно для заполнения',
            'additional_info.personal.email.max' => 'Поле не должно превышать 255 символов',
            'additional_info.personal.email.email' => 'Поле содержит некорректное значение',

            'receipt_image.required' => 'Поле «Фотография чека» обязательно для заполнения',
            'receipt_image.image' => 'Поле «Фотография чека» должно быть изображением',

            'additional_info.agreement.rules' => 'Поле обязательно для заполнения',

            'additional_info.agreement.personal_info' => 'Поле обязательно для заполнения',

            'g-recaptcha-response.required' => 'Поле обязательно для заполнения',
            'g-recaptcha-response.captcha' => 'Неверный код капча',
        ];
    }

    public function rules(): array
    {
        return [
            'additional_info.personal.name' => 'required|max:255',
            'additional_info.personal.phone' => 'required|max:255',
            'additional_info.personal.email' => 'required|max:255|email',
            'additional_info.agreement.rules' => 'required',
            'additional_info.agreement.personal_info' => 'required',
            'receipt_image' => 'required|image',
            'g-recaptcha-response' => [
                'required',
                new CaptchaRule,
            ],
        ];
    }
}
