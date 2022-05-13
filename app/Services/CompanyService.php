<?php

namespace App\Services;

use App\Models\Company;
use App\Models\User;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use App\Services\Contracts\CompanyServiceInterface;
use App\Transformers\CompanyTransformer;

class CompanyService implements CompanyServiceInterface
{
    /**
     * @var CompanyRepositoryInterface
     */
    private CompanyRepositoryInterface $companyRepository;

    /**
     * CompanyService constructor.
     * @param CompanyRepositoryInterface $companyRepository
     */
    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * @param User  $user
     * @param array $data
     * @return Company|null
     */
    public function create(User $user, array $data): ?Company
    {
        return $this->companyRepository->create($user, CompanyTransformer::prepareDataForDB($data));
    }
}
