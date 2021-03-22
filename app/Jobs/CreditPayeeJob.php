<?php

namespace PayAny\Jobs;

use PayAny\Models\Status;
use PayAny\Services\Credit;
use PayAny\Services\Debit;
use PayAny\Services\Transfer;
use Throwable;

class CreditPayeeJob extends Job
{
    private int $transactionId;

    public function __construct(int $transactionId)
    {
        $this->transactionId = $transactionId;
    }

    public function handle(Credit $credit, Transfer $transaction) {
        try {
            $status = $credit->dispatch()
                ? Status::PAYEE_CREDITED
                : Status::PAYEE_NOT_CREDITED;
            $transaction->update($this->transactionId, $status);
        } catch (Throwable $e) {
            report($e);
            $transaction->update($this->transactionId, Status::PAYEE_NOT_CREDITED);
        }
    }
}
