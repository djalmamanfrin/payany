<?php

namespace PayAny\Repositories\DB\Interfaces;

use PayAny\Models\Authorization;

interface AuthorizationRepositoryInterface
{
    public function fill(array $values): Authorization;
    public function store(): bool;
}
