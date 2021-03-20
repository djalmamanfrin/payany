<?php

namespace PayAny\Services;

use Illuminate\Http\Response;
use PayAny\Models\Status;
use Illuminate\Support\Facades\{
    Queue,
    Validator
};
use InvalidArgumentException;
use PayAny\Jobs\ProcessTransactionEvent;
use PayAny\Repositories\API\{
    Interfaces\AuthorizerApiInterface,
    Interfaces\NotifierApiInterface,
    AuthorizerApiRepository,
    NotifierApiRepository
};
use PayAny\Repositories\DB\{Interfaces\TransactionRepositoryInterface,
    Interfaces\WalletRepositoryInterface,
    WalletRepository};

class Transaction
{
    const TRANSFER = 'transfer';

    private TransactionRepositoryInterface $repository;

    public function __construct(TransactionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function fill(array $values)
    {
        $values['type'] = self::TRANSFER;
//        $this->validate($values);
        $this->repository->fill($values);
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validate(array $params)
    {
        $fields = config('validator.transfer.fields');
        $messages = config('validator.transfer.messages');
        $validator = Validator::make($params, $fields, $messages);
        $validator->validate();
    }

    public function dispatch(): bool
    {
        if (! $this->repository->store()) {
            $error = 'Error to store Transaction Event';
            throw new InvalidArgumentException($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return Queue::push(new ProcessTransactionEvent());
    }

    public function authorizer(): AuthorizerApiInterface
    {
        return app(AuthorizerApiRepository::class, ['transactionEventId' => $this->model->getId()]);
    }

    public function notifier(): NotifierApiInterface
    {
        return app(NotifierApiRepository::class, ['transactionEventId' => $this->model->getId()]);
    }

    public function update(string $status): bool
    {
        if (! in_array($status, Status::status())) {
            $error = 'Status not found in ' . Status::class;
            throw new InvalidArgumentException($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $this->repository->fill(['status' => $status]);
        return $this->repository->update();
    }
}
