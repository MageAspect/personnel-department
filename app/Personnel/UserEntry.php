<?php

/**
 * @author mosowell https://github.com/mosowell
 */

namespace App\Personnel;


use App\Models\User;


class UserEntry
{
    public ?int $id = null;
    public string $email = '';
    public string $name = '';
    public string $lastName = '';
    public string $patronymic = '';
    public string $phone = '';
    public string $avatar = '';
    public string $profileUrl = '';

    public string $position = '';
    public ?int $salary = null;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public static function fromModel(User $modelUser): UserEntry
    {
        $user = new UserEntry((int) $modelUser->id);
        $user->name = (string) $modelUser->name;
        $user->lastName = (string) $modelUser->last_name;
        $user->patronymic = (string) $modelUser->patronymic;
        $user->email = (string) $modelUser->email;
        $user->salary = $modelUser->salary;
        $user->position = (string) $modelUser->position;
        $user->phone = (string) $modelUser->phone;
        $user->avatar = (string) $modelUser->avatar;
        $user->profileUrl = route('users.show', ['user' => $modelUser->id]);

        return $user;
    }

    public function getFormattedName(): string {
        return "$this->lastName $this->name";
    }
}
