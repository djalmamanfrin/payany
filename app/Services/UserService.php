<?php

namespace PayAny\Services;

use Illuminate\Http\Response;
use InvalidArgumentException;
use PayAny\Models\Transaction;
use PayAny\Models\User;
use PayAny\Repositories\DB\UserRepository;
use PayAny\Services\Interfaces\UserServiceInterface;

class UserService implements UserServiceInterface
{
    private UserRepository $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function get(int $id): User
    {
        return $this->user->get($id);
    }

    public function store(array $params): bool
    {
        return $this->user->store($params);
    }

    public function transfer(array $params): bool
    {
        $payer = $this->user->findPayerOrFail((int) $params['payer']);
        $payee = $this->user->findPayeeOrFail((int) $params['payee']);

        (new Transaction())->fill($params);
        $transaction = new Transaction();
        if (! $transaction->store()) {
            $error = 'Error to store Transaction Event';
            throw new InvalidArgumentException($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return $transaction->dispatch();
    }
}
