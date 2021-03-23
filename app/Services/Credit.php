<?php

namespace PayAny\Services;

use PayAny\Repositories\DB\Interfaces\CreditInterface;

class Credit implements CreditInterface
{
    protected CreditInterface $repository;

    public function __construct(CreditInterface $repository)
    {
        $this->repository = $repository;
    }

    public function fill(array $values) {
        $this->repository->fill($values);
    }

    public function store(): bool
    {
        return $this->repository->store();
    }
}
