<?php

/**
 * @author mosowell https://github.com/mosowell
 */

namespace App\Personnel\Users;


class UserEntity
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
    public bool $salaryCanBeViewed = false;
    public bool $canBeUpdated = false;
    public bool $canBeDeleted = false;

    public function getFormattedName(): string {
        return "$this->lastName $this->name";
    }
}
