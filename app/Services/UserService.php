<?php

namespace PayAny\Services;

use Illuminate\Http\Request;
use PayAny\Models\Transaction;
use PayAny\Models\User;
use PayAny\Repositories\DB\Interfaces\UserRepositoryInterface;

class UserService
{
    private UserRepositoryInterface $repository;
    private Transfer $transfer;

    public function __construct(Transfer $transfer, UserRepositoryInterface $repository)
    {
        $this->transfer = $transfer;
        $this->repository = $repository;
    }

    public function get(int $id): User
    {
        return $this->repository->get($id);
    }

    public function store(array $params): bool
    {
        return $this->repository->store($params);
    }

    public function balance(Balance $balance, int $id): float
    {
        $walletId = $this->get($id)->wallet()->id;
        return $balance->get($walletId);
    }

    public function hasBalance(Balance $balance, int $id, float $value): bool
    {
        $walletId = $this->get($id)->wallet()->id;
        return $balance->has($walletId, $value);
    }

    public function transfer(int $userId, Request $request)
    {
        $this->transfer->fill([
            'payer_id' => $userId,
            'payee_id' => $request->get('payee_id'),
            'value' => $request->get('value')
        ]);
        $this->transfer->dispatch();
    }
}
