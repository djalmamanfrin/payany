<?php

namespace PayAny\Repositories\API;

use Illuminate\Http\Response;
use InvalidArgumentException;
use PayAny\Models\Notification;
use PayAny\Repositories\API\Interfaces\NotifierApiInterface;
use Psr\Http\Message\ResponseInterface;

class NotifierApiRepository extends ApiRepository implements NotifierApiInterface
{
    private Notification $model;

    public function __construct(Notification $model)
    {
        $host = config('api.notifier.host');
        parent::__construct($host);
        $this->model = $model;
    }

    public function fill(array $values): Notification
    {
        return $this->model->fill($values);
    }

    private function expectInvalidArgumentExceptionIfFillableEmpty()
    {
        if (empty($this->model->getFillable())) {
            $error = 'Fillable of ' . Notification::class . 'class empty';
            throw new InvalidArgumentException($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function notifyPayee(): ResponseInterface
    {
        return parent::get();
    }

    public function store(ResponseInterface $response): int
    {
        $this->expectInvalidArgumentExceptionIfFillableEmpty();
        return $this->model->save();
    }
}
