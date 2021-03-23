<?php

namespace PayAny\Services;

use Illuminate\Http\Response;
use InvalidArgumentException;
use PayAny\Repositories\DB\Interfaces\CreditInterface;

class Credit
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
        if (empty($this->repository->getFill())) {
            $error = 'Fill method is empty';
            throw new InvalidArgumentException($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return $this->repository->store();
    }
}
