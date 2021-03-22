<?php

namespace PayAny\Repositories\DB\Interfaces;

use PayAny\Models\Wallet;

interface GetFillAndStoreInterface
{
    public function fill(array $values);
    public function store(): bool;
}
