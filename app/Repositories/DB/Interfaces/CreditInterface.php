<?php

namespace PayAny\Repositories\DB\Interfaces;

interface CreditInterface
{
    public function getFill(): array;
    public function fill(array $values);
    public function store(): bool;
}
