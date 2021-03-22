<?php


namespace PayAny\Services;


use PayAny\Models\Wallet;
use PayAny\Repositories\DB\Interfaces\WalletRepositoryInterface;

class Credit
{
    protected WalletRepositoryInterface $repository;

    public function __construct(WalletRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function hasFunds(int $walletId, float $value): bool
    {
        $funds = $this->repository->getFunds($walletId);
        return $value > $funds;
    }

    public function fill(array $values) {
        $this->repository->fill($values);
    }

    public function dispatch(): bool
    {
        return $this->repository->store();
    }
}
