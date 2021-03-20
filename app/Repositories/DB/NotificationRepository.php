<?php

namespace PayAny\Repositories\DB;

use Illuminate\Http\Response;
use InvalidArgumentException;
use PayAny\Models\Transaction;
use PayAny\Models\Notification;
use PayAny\Repositories\DB\Interfaces\NotificationRepositoryInterface;

class NotificationRepository implements NotificationRepositoryInterface
{
    private Notification $model;

    public function __construct(Notification $model)
    {
        $this->model = $model;
    }

    public function fill(array $values): Notification
    {
        return $this->model->fill($values);
    }

    private function expectInvalidArgumentExceptionIfFillableEmpty()
    {
        if (empty($this->model->getFillable())) {
            $error = 'Fillable of ' . Transaction::class . 'class empty';
            throw new InvalidArgumentException($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function store(): bool
    {
        $this->expectInvalidArgumentExceptionIfFillableEmpty();
        return $this->model->save();
    }
}
