<?php

namespace PayAny\Services;

use Illuminate\Http\Response;
use InvalidArgumentException;
use PayAny\Repositories\API\Interfaces\NotifierApiInterface;
use PayAny\Repositories\DB\Interfaces\NotificationInterface;
use Psr\Http\Message\ResponseInterface;

class Notifier
{
    private NotificationInterface $repository;
    private NotifierApiInterface $notifier;

    public function __construct(NotificationInterface $repository, NotifierApiInterface $notifier)
    {
        $this->repository = $repository;
        $this->notifier = $notifier;
    }

    public function dispatch(): ResponseInterface
    {
        return $this->notifier->notifyPayee();
    }

    public function fill(array $values)
    {
        $this->repository->fill($values);
    }

    public function store(): bool
    {
        if (empty($this->repository->getFill())) {
            $error = 'Fill method is empty';
            throw new InvalidArgumentException($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return $this->repository->store();
    }
}
