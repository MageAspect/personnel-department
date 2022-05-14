<?php

/**
 * @author MageAspect https://github.com/mageaspect
 */

namespace App\Personnel\User;


class UserEntity
{
    public ?string $id = null;
    public ?string $email = null;
    public ?string $name = null;
    public ?string $lastName = null;
    public ?string $patronymic = null;
    public ?string $phone = null;
    public ?string $avatar = null;
    public ?string $avatarPublicPath = null;
    public ?string $profileUrl = null;

    public ?string $position = null;
    public ?int $salary = null;
    public bool $salaryCanBeViewed = false;
    public bool $canBeUpdated = false;
    public bool $canBeDeleted = false;

    public function getFormattedName(): string {
        return "$this->lastName $this->name";
    }
}
