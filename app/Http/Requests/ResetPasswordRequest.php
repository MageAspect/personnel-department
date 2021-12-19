<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;


class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => [
                'required',
                'max:255',
                'min:8',
                'regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d])(?=.*[!$#%]).*$/',
                'confirmed'
            ],
            'email' => ['email', 'required', 'exists:users,email'],
            'token' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'Пароль обязателен для заполнения',
            'password.confirmed' => 'Пароли не совпадают',
            'password.max' => 'Пароль слишком длинный',
            'password.min' => 'Пароль должен содержать минимум 8 символов',
            'password.regex' => 'Пароль должен содержать хотя бы одни символ в верхнем и нижнем регистре, '
                .'один специальный символ (#, $, %), цифру'
        ];
    }
}
