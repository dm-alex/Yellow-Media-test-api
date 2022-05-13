<?php

namespace App\Transformers;

class CompanyTransformer extends BaseTransformer
{
    /**
     * @return array
     */
    protected static function getTransformableFields(): array
    {
        return [
            'phone',
        ];
    }
}
