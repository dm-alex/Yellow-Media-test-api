<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/*
 * Abstract class AbstractRepository
 *
 * @package App\Repositories
 */

abstract class AbstractRepository
{
    /**
     * @var string 
     */
    private string $modelClass;

    /**
     * @param string $modelClass
     */
    public function __construct(string $modelClass)
    {
        $this->modelClass = $modelClass;
    }

    /**
     * @param array $attributes
     * @return Model
     */
    protected function model(array $attributes = []): Model
    {
        return new $this->modelClass($attributes);
    }
}
