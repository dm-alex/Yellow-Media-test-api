<?php

namespace App\Services\Contracts;

use App\Models\Company;
use App\Models\User;

interface CompanyServiceInterface
{
    /**
     * @param User  $user
     * @param array $data
     * @return Company|null
     */
    public function create(User $user, array $data): ?Company;
}
