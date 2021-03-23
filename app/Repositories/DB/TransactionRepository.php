<?php

namespace PayAny\Repositories\DB;

use PayAny\Models\Transaction;
use PayAny\Repositories\DB\Interfaces\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{
    private Transaction $model;

    public function __construct(Transaction $model)
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

    public function update(int $id, string $status_id): bool
    {
        return $this->model->newQuery()
            ->where(['id' => $id])
            ->update(['status_id' => $status_id]);
    }

    public function store(): Transaction
    {
        $values = $this->getFill();
        return Transaction::create($values);
    }
}
