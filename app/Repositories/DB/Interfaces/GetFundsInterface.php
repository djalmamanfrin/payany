<?php

namespace PayAny\Repositories\DB\Interfaces;

interface GetFundsInterface
{
    public function getFunds(int $walletId): float;
}
