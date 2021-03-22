<?php

namespace PayAny\Repositories\DB\Interfaces;

use PayAny\Models\Wallet;

interface WalletRepositoryInterface
{
    public function fill(array $values);
    public function turnValueIntoNegative();
    public function getFunds(int $walletId): float;
    public function store(): bool;
}
