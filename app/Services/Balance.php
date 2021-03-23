<?php


namespace PayAny\Services;

use PayAny\Repositories\DB\Interfaces\BalanceInterface;

class Balance
{
    private BalanceInterface $repository;

    public function __construct(BalanceInterface $repository)
    {
        $this->repository = $repository;
    }

    public function get(int $walletId): float
    {
        return $this->repository->getBalance($walletId);
    }

    public function has(int $walletId, float $value): bool
    {
        $balance = $this->repository->getBalance($walletId);
        return $balance > $value;
    }
}
