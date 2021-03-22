<?php

namespace PayAny\Repositories\DB\Interfaces;

interface CreditInterface
{
    public function fill(array $values);
    public function store(): bool;
}
