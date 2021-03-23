<?php

namespace PayAny\Repositories\DB\Interfaces;

interface BalanceInterface
{
    public function getBalance(int $walletId): float;
}
