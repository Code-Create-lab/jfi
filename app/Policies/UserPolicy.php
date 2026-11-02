<?php

namespace App\Policies;

use App\Models\User;

/**
 * Every user is an admin. The only rule: an admin cannot delete their own
 * account (so the panel always keeps at least one admin), and there is no
 * bulk delete.
 */
class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, User $model): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, User $model): bool
    {
        return true;
    }

    public function delete(User $user, User $model): bool
    {
        return $user->isNot($model);
    }

    public function deleteAny(User $user): bool
    {
        return false;
    }
}
