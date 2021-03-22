<?php

namespace PayAny\Repositories\DB\Interfaces;

use PayAny\Models\Transaction;

interface TransactionRepositoryInterface
{
    public function getFill(): array;
    public function fill(array $values);
    public function update(int $id, string $status_id): bool;
    public function store(): Transaction;
}
