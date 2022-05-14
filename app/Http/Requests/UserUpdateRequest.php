<?php

namespace App\Http\Requests;

use App\Personnel\User\UserStore;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;


class UserUpdateRequest extends FormRequest
{
    use JsonAnswerOnFail;

    private UserStore $userStore;
    private string $userId;

    public function authorize(): bool
    {
        /** @var UserStore $us */
        $this->userStore = App::make(UserStore::class);
        $this->userId = $this->route()->parameter('id') ?: 0;

        return $this->userStore->canUpdate($this->userId);
    }

    public function rules(): array
    {
        return array(
            'email' => array(
                'required',
                'email',
                function ($attribute, $email, $fail) {
                    if (!$this->userStore->isUniqueEmail($this->userId, $email)) {
                        $fail('Указанный email уже занят');
                    }
                }
            ),
            'currentPassword' => array(
                function ($attribute, $password, $fail) {
                    if ($password && !$this->userStore->isCorrectPassword($this->userId, $password)) {
                        $fail('Неверный текущий пароль');
                    }
                }
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
