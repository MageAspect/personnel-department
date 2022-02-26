<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    use JsonAnswerOnFail;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return request()->user()->can('store', User::class);
    }

    public function rules(): array
    {
        return array(
            'newPassword' => array(
                'required',
                'max:255',
                'min:6'
            ),
            'email' => array(
                'required',
                'unique:users,email'
            ),
            'avatar' => array(
                'mimes:jpg,png,jpeg'
            )
        );
    }

    public function messages(): array
    {
        return array(
            'avatar.mimes' => 'В качестве аватара можно загрузить только изображение (jpg, png, jpeg)'
        );
    }
}
