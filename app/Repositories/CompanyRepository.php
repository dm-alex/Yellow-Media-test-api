<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\User;
use App\Repositories\Contracts\CompanyRepositoryInterface;

final class CompanyRepository extends AbstractRepository implements CompanyRepositoryInterface
{
    /**
     * @param User  $user
     * @param array $data
     * @return Company|null
     */
    public function create(User $user, array $data): ?Company
    {
        return $user->companies()->create($data);
    }
}
