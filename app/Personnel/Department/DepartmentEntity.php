<?php

/**
 * @author MageAspect https://github.com/mageaspect
 */

namespace App\Personnel\Department;


use App\Personnel\User\UserEntity;


class DepartmentEntity
{
    public ?int $id = null;
    public string $name = '';
    public string $description = '';
    public UserEntity $head;
    public bool $canBeUpdated = false;
    public bool $canBeDeleted = false;

    /**
     * @var UserEntity[]
     */
    public array $members = [];

    public function __construct()
    {
        $this->head = new UserEntity();
    }
}
