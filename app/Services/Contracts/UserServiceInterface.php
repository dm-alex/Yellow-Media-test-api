<?php

namespace App\Services\Contracts;

use App\Models\User;

interface UserServiceInterface
{
    /**
     * @param array $data
     * @return User|null
     */
    public function create(array $data): ?User;

    /**
     * @param User  $user
     * @param array $data
     * @return bool
     */
    public function update(User $user, array $data): bool;
}
