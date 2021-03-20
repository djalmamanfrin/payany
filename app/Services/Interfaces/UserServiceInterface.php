<?php

namespace PayAny\Services\Interfaces;

use PayAny\Models\User;
use PayAny\Services\Transaction;

interface UserServiceInterface
{
    public function get(int $id): User;
    public function store(array $params): bool;
    public function transfer(array $params): bool;
}
