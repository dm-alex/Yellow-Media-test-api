<?php

namespace App\Repositories\Contracts;

use App\Models\Company;
use App\Models\User;

interface CompanyRepositoryInterface
{
    /**
     * @param User  $user
     * @param array $data
     * @return Company|null
     */
    public function create(User $user, array $data): ?Company;
}
