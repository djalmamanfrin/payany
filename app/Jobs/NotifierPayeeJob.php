<?php

namespace PayAny\Jobs;

use Illuminate\Http\Response;
use PayAny\Models\Status;
use PayAny\Services\Credit;
use PayAny\Services\Debit;
use PayAny\Services\Notifier;
use PayAny\Services\Transfer;
use Throwable;

class NotifierPayeeJob extends Job
{
    private int $transactionId;

    public function __construct(int $transactionId)
    {
        $this->transactionId = $transactionId;
    }

    public function handle(Notifier $notifier, Transfer $transaction) {
        try {
            $response = $notifier->dispatch();
            $status = ($response->getStatusCode() === Response::HTTP_OK)
                ? Status::NOTIFICATION_SENT
                : Status::NOTIFICATION_NOT_SENT;
            $notifier->fill([
                'transaction_id' => $this->transactionId,
                'payload' => $response->getBody()->getContents(),
                'status_code' => $response->getStatusCode()
            ]);
            $notifier->store();
            $transaction->update($this->transactionId, $status);
        } catch (Throwable $e) {
            report($e);
            $transaction->update($this->transactionId, Status::NOTIFICATION_NOT_SENT);
        }
    }
}
