<?php

namespace PayAny\Repositories\DB;

use Illuminate\Http\Response;
use InvalidArgumentException;
use PayAny\Models\Transaction;
use PayAny\Repositories\DB\Interfaces\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{
    private Transaction $model;

    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }

    public function fill(array $values): Transaction
    {
        return $this->model->fill($values);
    }

    private function expectInvalidArgumentExceptionIfFillableEmpty()
    {
        if (empty($this->model->toArray())) {
            $error = 'Fillable of ' . Transaction::class . 'class empty';
            throw new InvalidArgumentException($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function store(): bool
    {
        $this->expectInvalidArgumentExceptionIfFillableEmpty();
        return $this->model->save();
    }
    public function update(): bool
    {
        $this->expectInvalidArgumentExceptionIfFillableEmpty();
        return $this->model->update();
    }
}
