<?php

namespace InetStudio\ChecksContest\Checks\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;
use InetStudio\ChecksContest\Checks\Contracts\Http\Requests\Front\SaveItemRequestContract;

/**
 * Class SaveItemRequest.
 */
class SaveItemRequest extends FormRequest implements SaveItemRequestContract
{
    /**
     * Определить, авторизован ли пользователь для этого запроса.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Сообщения об ошибках.
     *
     * @return array
     */
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

            'additional_info.city.required' => 'Поле «Город» обязательно для заполнения',
            'additional_info.city.max' => 'Поле «Город» не должно превышать 255 символов',

            'check_image.required' => 'Поле «Фотография чека» обязательно для заполнения',
            'check_image.image' => 'Поле «Фотография чека» должно быть изображением',
        ];
    }

    /**
     * Правила проверки запроса.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'additional_info.name' => 'required|max:255',
            'additional_info.surname' => 'required|max:255',
            'additional_info.email' => 'required|max:255|email',
            'additional_info.phone' => 'required',
            'additional_info.city' => 'required|max:255',
            'check_image' => 'required|image',
        ];
    }
}
