<?php


namespace PayAny\Services;

use Illuminate\Http\Response;
use InvalidArgumentException;
use PayAny\Models\Transaction;
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
        if (empty($this->repository->getFill())) {
            $error = 'Fill method is empty';
            throw new InvalidArgumentException($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $this->repository->turnValueIntoNegative();
        return $this->repository->store();
    }
}
