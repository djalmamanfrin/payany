<?php

namespace PayAny\Repositories\DB\Interfaces;

use PayAny\Models\User;

interface UserRepositoryInterface
{
    public function get(int $id): User;
    public function store(array $params): bool;
    public function isEntrepreneur(int $id): bool;
}
