<?php

namespace PayAny\Services;

use Exception;
use Illuminate\Http\Response;
use PayAny\Jobs\AuthorizeJob;
use PayAny\Jobs\CreditPayeeJob;
use PayAny\Jobs\DebitPayerJob;
use PayAny\Jobs\NotifierPayeeJob;
use PayAny\Models\Status;
use PayAny\Models\Transaction as TransactionModel;
use Illuminate\Support\Facades\{Bus, DB, Queue, Validator};
use InvalidArgumentException;
use Throwable;

class Transfer
{
    const TRANSFER = 'transfer';

    private TransactionModel $model;

    public function __construct(TransactionModel $model)
    {
        $this->model = $model;
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function fill(array $values)
    {
        $values['type'] = self::TRANSFER;
//        $this->validate($values);
        $this->model->fill($values);
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

    public function store()
    {
        if (empty($this->model->toArray())) {
            $error = 'Fillable of ' . \PayAny\Models\Transaction::class . 'class empty';
            throw new InvalidArgumentException($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if (! $this->model->save()) {
            $error = 'Error to store Transaction Event';
            throw new InvalidArgumentException($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function dispatch()
    {
        try {
            DB::beginTransaction();
            $this->store();
//            $isPushed =  Queue::push(new ProcessTransaction());
            $transactionId = $this->model->getId();
            Bus::chain([
                new AuthorizeJob($transactionId),
                new DebitPayerJob($transactionId),
                new CreditPayeeJob($transactionId),
                new NotifierPayeeJob($transactionId),
            ])->catch(function (Throwable $e) {
                throw new Exception('Queue not processed', Response::HTTP_UNPROCESSABLE_ENTITY);
            })->dispatch();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(int $transactionId, string $status): bool
    {
        if (! in_array($status, Status::status())) {
            $error = 'Status not found in ' . Status::class;
            throw new InvalidArgumentException($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return $this->model->newQuery()
            ->firstOrFail($transactionId)
            ->update(['status' => $status]);
    }
}
