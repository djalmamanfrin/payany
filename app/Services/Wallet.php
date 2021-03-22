<?php


namespace PayAny\Services;

use PayAny\Repositories\DB\Interfaces\GetFundsInterface;

class Wallet
{
    protected GetFundsInterface $repository;

    public function __construct(GetFundsInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getFunds(int $walletId): bool
    {
        return $this->repository->getFunds($walletId);
    }

    public function hasFunds(int $walletId, float $value): bool
    {
        $funds = $this->getFunds($walletId);
        return $value > $funds;
    }
}
