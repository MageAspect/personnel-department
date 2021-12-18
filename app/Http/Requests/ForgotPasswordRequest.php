<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
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
            'email' => ['email', 'required', 'max:255']
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email обязателен для заполнения',
            'email.max' => 'Email слишком длинный',
            'email.email' => 'Неверный формат email',
        ];
    }
}
