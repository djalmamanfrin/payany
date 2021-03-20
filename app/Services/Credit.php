<?php


namespace PayAny\Services;


use PayAny\Models\Wallet;
use PayAny\Repositories\DB\Interfaces\WalletRepositoryInterface;

class Credit
{
    private WalletRepositoryInterface $repository;

    public function __construct(WalletRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function dispatch(): bool
    {
//        $this->repository->fill($wallet->getFillable());
        return $this->repository->credit();
    }
}
