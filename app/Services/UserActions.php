<?php

namespace PayAny\Services;

use PayAny\Models\User;
use PayAny\Repositories\DB\Interfaces\UserRepositoryInterface;

class UserActions
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function get(int $id): User
    {
        return $this->repository->get($id);
    }

    public function store(array $params): bool
    {
        return $this->repository->store($params);
    }

    public function hasFunds(Credit $credit, int $id, float $value): bool
    {
        $walletId = $this->get($id)->wallet()->id;
        return $credit->hasFunds($walletId, $value);
    }

    public function isEntrepreneur(int $id): bool
    {
        return $this->repository->isEntrepreneur($id);
    }
}
