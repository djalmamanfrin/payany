<?php

namespace PayAny\Repositories\DB\Interfaces;

use PayAny\Models\Wallet;

interface GetFundsInterface
{
    public function getFunds(int $walletId): float;
}
