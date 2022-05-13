<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

final class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    /**
     * @param array $data
     * @return User|null
     */
    public function create(array $data): ?User
    {
        $user = $this->model($data);
        $user->password = $data['password'];
        $user->save();

        return $user;
    }

    /**
     * @param User  $user
     * @param array $data
     * @return bool
     */
    public function update(User $user, array $data): bool
    {
        $user->fill($data);

        if(!empty($data['password'])){
            $user->password = $data['password'];
        }
        
        return $user->save();
    }
}
