<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class UserPolicy
{
    use HandlesAuthorization;


    public function before(User $current, $ability): ?bool
    {
        return $current->isAdministrator() ?: null;
    }

    public function viewWorkFields(User $current, User $user): bool
    {
        if ($current->id === $user->id) {
            return true;
        }

        foreach ($user->departments as $d) {
            if ($d->head_id === $current->id) {
                return true;
            }
        }

        return false;
    }

    public function update(User $current, User $user): bool
    {
        return $current->id === $user->id;
    }

    public function delete(): bool
    {
        return false;
    }

    public function store(): bool
    {
        return false;
    }
}
