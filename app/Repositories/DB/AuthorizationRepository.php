<?php

namespace PayAny\Repositories\DB;

use PayAny\Models\Authorization;
use PayAny\Repositories\DB\Interfaces\AuthorizationInterface;

class AuthorizationRepository implements AuthorizationInterface
{
    private Authorization $model;

    public function __construct(Authorization $model)
    {
        $this->model = $model;
    }

    public function getFill(): array
    {
        return $this->model->toArray();
    }

    public function fill(array $values)
    {
        $this->model = $this->model->newInstance($values);
    }

    public function store(): bool
    {
        return $this->model->save();
    }
}
