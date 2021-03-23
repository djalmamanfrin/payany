<?php

namespace PayAny\Repositories\DB\Interfaces;

interface DebitInterface
{
    public function getFill(): array;
    public function fill(array $values);
    public function turnValueIntoNegative();
    public function store(): bool;
}
