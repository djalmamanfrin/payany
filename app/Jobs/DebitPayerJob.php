<?php

namespace PayAny\Jobs;

use PayAny\Models\Status;
use PayAny\Services\Debit;
use PayAny\Services\Transfer;
use Throwable;

class DebitPayerJob extends Job
{
    private int $transactionId;

    public function __construct(int $transactionId)
    {
        $this->transactionId = $transactionId;
    }

    public function handle(Debit $debit, Transfer $transaction) {
        try {
            $status = $debit->dispatch()
                ? Status::PAYER_DEBITED
                : Status::PAYER_NOT_DEBITED;
            $transaction->update($this->transactionId, $status);
        } catch (Throwable $e) {
            report($e);
            $transaction->update($this->transactionId, Status::PAYER_NOT_DEBITED);
        }
    }
}
