<?php

namespace PayAny\Repositories\DB;

use Illuminate\Http\Response;
use InvalidArgumentException;
use PayAny\Models\Transaction;
use PayAny\Models\Wallet;
use PayAny\Repositories\DB\Interfaces\WalletRepositoryInterface;

class WalletRepository implements WalletRepositoryInterface
{
    private Wallet $model;

    public function __construct(Wallet $model)
    {
        $this->model = $model;
    }

    public function fill(array $values): Wallet
    {
        return $this->model->fill($values);
    }

    private function expectInvalidArgumentExceptionIfFillableEmpty()
    {
        if (empty($this->model->getFillable())) {
            $error = 'Fillable of ' . Transaction::class . 'class empty';
            throw new InvalidArgumentException($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function credit(): bool
    {
        $this->expectInvalidArgumentExceptionIfFillableEmpty();
        return $this->model->save();
    }

    public function debit(): bool
    {
        $this->expectInvalidArgumentExceptionIfFillableEmpty();
        $this->model->turnValueIntoNegative();
        return $this->model->save();
    }
}
