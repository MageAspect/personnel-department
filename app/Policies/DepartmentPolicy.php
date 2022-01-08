<?php

namespace App\Policies;

use App\Models\Department;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class DepartmentPolicy
{
    use HandlesAuthorization;


    public function before(User $current): ?bool
    {
        return $current->isAdministrator() ?: null;
    }

    public function update(User $current, Department $department): bool
    {
        return $current->id === $department->head_id;
    }

    public function updateHead(): bool
    {
        return false;
    }

    public function delete(): bool
    {
        return false;
    }
}
