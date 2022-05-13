<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class CompanyDto extends DataTransferObject
{
    public string $title;
    public string $phone;
    public string $description;
}
