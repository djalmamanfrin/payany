<?php

namespace PayAny\Services;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\{Queue, Validator};
use PayAny\Jobs\ProcessTransaction;
use PayAny\Models\Status;
use PayAny\Models\Transaction;
use InvalidArgumentException;
use PayAny\Repositories\DB\Interfaces\TransactionRepositoryInterface;

class Transfer
{
    const TRANSFER = 'transfer';

    private TransactionRepositoryInterface $repository;

    public function __construct(TransactionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function fill(array $values)
    {
        $values['type'] = self::TRANSFER;
        $this->repository->fill($values);
    }

    public function store(): Transaction
    {
        if (empty($this->repository->getFill())) {
            $error = 'Fillable of ' . Transaction::class . 'class empty';
            throw new InvalidArgumentException($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $transaction = $this->repository->store();
        if (! $transaction instanceof Transaction) {
            $error = 'Error to store Transfer Event';
            throw new InvalidArgumentException($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return $transaction;
    }

    public function dispatch()
    {
        $model = $this->store();
        $isPushed = Queue::push(new ProcessTransaction($model));
        if (! $isPushed) {
            throw new Exception('Queue not processed', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function update(int $id, string $status_id): bool
    {
        if (! in_array($status_id, Status::status())) {
            $error = 'Status not found in ' . Status::class;
            throw new InvalidArgumentException($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return $this->repository->update($id, $status_id);
    }
}
