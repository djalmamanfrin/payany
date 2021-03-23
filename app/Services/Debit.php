<?php


namespace PayAny\Services;

use PayAny\Repositories\DB\Interfaces\DebitInterface;

class Debit
{
    private DebitInterface $repository;

    public function __construct(DebitInterface $repository)
    {
        $this->repository = $repository;
    }

    public function fill(array $values) {
        $this->repository->fill($values);
    }

    public function store(): bool
    {
        $this->repository->turnValueIntoNegative();
        return $this->repository->store();
    }
}
