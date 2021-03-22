<?php

namespace PayAny\Repositories\DB\Interfaces;

interface WalletRepositoryInterface
{
    public function fill(array $values);
    public function turnValueIntoNegative();
    public function getFunds(int $walletId): float;
    public function store(): bool;
}
