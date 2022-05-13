<?php

namespace App\Transformers;

use Illuminate\Support\Facades\Hash;

class UserTransformer extends BaseTransformer
{
    /**
     * @return array
     */
    protected static function getTransformableFields(): array
    {
        return [
            'password',
            'phone',
        ];
    }

    /**
     * @param $value
     */
    public static function passwordDBFormat(&$value)
    {
        $value = Hash::make($value);
    }
}
