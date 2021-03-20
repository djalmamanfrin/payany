<?php

namespace PayAny\Repositories\DB\Interfaces;

use PayAny\Models\Wallet;

interface WalletRepositoryInterface
{
    public function fill(array $values): Wallet;
    public function credit(): bool;
    public function debit(): bool;
}
