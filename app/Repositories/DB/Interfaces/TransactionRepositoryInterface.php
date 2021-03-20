<?php


namespace PayAny\Repositories\DB\Interfaces;


use PayAny\Models\Transaction;

interface TransactionRepositoryInterface
{
    public function fill(array $values): Transaction;
    public function update(): bool;
    public function store(): bool;
}
