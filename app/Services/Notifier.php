<?php

namespace PayAny\Services;

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
        return $this->repository->store();
    }
}
