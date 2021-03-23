<?php

namespace PayAny\Repositories\DB;

use PayAny\Models\Notification;
use PayAny\Repositories\DB\Interfaces\NotificationInterface;

class NotificationRepository implements NotificationInterface
{
    private Notification $model;

    public function __construct(Notification $model)
    {
        $this->model = $model;
    }

    public function getFill(): array
    {
        return $this->model->toArray();
    }

    public function fill(array $values)
    {
        $this->model->fill($values);
    }

    public function store(): bool
    {
        return $this->model->save();
    }
}
