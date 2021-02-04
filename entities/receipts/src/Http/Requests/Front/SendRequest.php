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
            'additional_info.name.required' => 'Поле «Имя» обязательно для заполнения',
            'additional_info.name.max' => 'Поле «Имя» не должно превышать 255 символов',

            'additional_info.surname.required' => 'Поле «Фамилия» обязательно для заполнения',
            'additional_info.surname.max' => 'Поле «Фамилия» не должно превышать 255 символов',

            'additional_info.email.required' => 'Поле «E-mail» обязательно для заполнения',
            'additional_info.email.max' => 'Поле «E-mail» не должно превышать 255 символов',
            'additional_info.email.email' => 'Поле «E-mail» содержит значение некорректного формата',

            'additional_info.phone.required' => 'Поле «Телефон» обязательно для заполнения',
            'additional_info.phone.max' => 'Поле «Телефон» не должно превышать 255 символов',

            'receipt_image.required' => 'Поле «Фотография чека» обязательно для заполнения',
            'receipt_image.image' => 'Поле «Фотография чека» должно быть изображением',

            'g-recaptcha-response.required' => 'Поле «Капча» обязательно для заполнения',
            'g-recaptcha-response.captcha' => 'Неверный код капча',
        ];
    }

    public function rules(): array
    {
        return [
            'additional_info.name' => 'required|max:255',
            'additional_info.surname' => 'required|max:255',
            'additional_info.email' => 'required|max:255|email',
            'additional_info.phone' => 'required|max:255',
            'receipt_image' => 'required|image',
            'g-recaptcha-response' => [
                'required',
                new CaptchaRule,
            ],
        ];
    }
}
