<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\UserServiceInterface;
use App\Transformers\UserTransformer;

class UserService implements UserServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $data
     * @return User|null
     */
    public function create(array $data): ?User
    {
        return $this->userRepository->create(UserTransformer::prepareDataForDB($data));
    }

    /**
     * @param User  $user
     * @param array $data
     * @return bool
     */
    public function update(User $user, array $data): bool
    {
        return $this->userRepository->update($user, UserTransformer::prepareDataForDB($data));
    }
}
