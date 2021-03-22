<?php

namespace PayAny\Repositories\DB;

use Illuminate\Http\Response;
use InvalidArgumentException;
use PayAny\Models\Transaction;
use PayAny\Models\WalletTransactions;
use PayAny\Repositories\DB\Interfaces\GetFillAndStoreInterface;
use PayAny\Repositories\DB\Interfaces\GetFundsInterface;
use PayAny\Repositories\DB\Interfaces\TurnValueIntoNegativeInterface;

class WalletRepository implements GetFillAndStoreInterface, TurnValueIntoNegativeInterface, GetFundsInterface
{
    private WalletTransactions $model;

    public function __construct(WalletTransactions $model)
    {
        $this->model = $model;
    }

    public function fill(array $values)
    {
        $this->model = $this->model->newInstance($values);
    }

    private function expectInvalidArgumentExceptionIfFillableEmpty()
    {
        if (empty($this->model->toArray())) {
            $error = 'Fillable of ' . Transaction::class . 'class empty';
            throw new InvalidArgumentException($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function getFunds(int $walletId): float
    {
        return $this->model->newQuery()
            ->where('wallet_id', '=', $walletId)
            ->sum('value');
    }

    public function turnValueIntoNegative()
    {
        $this->expectInvalidArgumentExceptionIfFillableEmpty();
        $this->model->turnValueIntoNegative();
    }

    public function store(): bool
    {
        $this->expectInvalidArgumentExceptionIfFillableEmpty();
        return $this->model->save();
    }
}
