<?php

namespace App\Transformers;

use Illuminate\Support\Str;
use Propaganistas\LaravelPhone\PhoneNumber;

abstract class BaseTransformer
{
    /**
     * @param array $data
     * @return array
     */
    public static function prepareDataForDB(array $data): array
    {
        foreach (static::getTransformableFields() as $field) {
            $methodName = Str::camel($field) . 'DBFormat';

            if (!empty($data[$field]) && method_exists(static::class, $methodName)) {
                static::$methodName($data[$field]);
            }
        }

        return $data;
    }

    /**
     * @param $value
     */
    public static function phoneDBFormat(&$value)
    {
        $value = (string)PhoneNumber::make($value);
    }

    /**
     * @return array
     */
    abstract protected static function getTransformableFields(): array;
}
