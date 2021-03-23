<?php


namespace PayAny\Repositories\DB\Interfaces;


interface NotificationInterface
{
    public function getFill(): array;
    public function fill(array $values);
    public function store(): bool;
}
