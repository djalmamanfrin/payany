<?php

namespace PayAny\Repositories\DB\Interfaces;

use PayAny\Models\Notification;

interface NotificationRepositoryInterface
{
    public function fill(array $values): Notification;
    public function store(): bool;
}
