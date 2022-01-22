<?php

/**
 * @author mosowell https://github.com/mosowell
 */

namespace App\Personnel\Department;


use App\Personnel\Users\UserEntity;


class DepartmentEntity
{
    public ?int $id = null;
    public string $name = '';
    public string $description = '';
    public UserEntity $head;
    public bool $canEdit = false;
    public bool $canDelete = false;

    /**
     * @var UserEntity[]
     */
    public array $members = [];

    public function __construct()
    {
        $this->head = new UserEntity();
    }
}
