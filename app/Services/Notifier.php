<?php

namespace PayAny\Services;

use PayAny\Repositories\API\Interfaces\NotifierApiInterface;
use PayAny\Repositories\DB\Interfaces\NotificationRepositoryInterface;
use Psr\Http\Message\ResponseInterface;

class Notifier
{
    private NotificationRepositoryInterface $repository;
    private NotifierApiInterface $notifier;

    public function __construct(NotificationRepositoryInterface $repository, NotifierApiInterface $notifier)
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

    public function store()
    {
        $this->repository->store();
    }
}
