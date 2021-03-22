<?php

namespace PayAny\Jobs;

use Illuminate\Http\Response;
use PayAny\Models\Status;
use PayAny\Services\Authorizer;
use PayAny\Services\Transfer;
use Throwable;

class AuthorizeJob extends Job
{
    private int $transactionId;

    public function __construct(int $transactionId)
    {
        $this->transactionId = $transactionId;
    }

    public function handle(Authorizer $authorizer, Transfer $transaction) {
        try {
            $response = $authorizer->dispatch();
            $status_id = ($response->getStatusCode() === Response::HTTP_OK)
                ? Status::AUTHORIZED
                : Status::UNAUTHORIZED;
            $authorizer->fill([
                'transaction_id' => $this->transactionId,
                'payload' => $response->getBody()->getContents(),
                'status_code' => $response->getStatusCode()
            ]);
            $authorizer->store();
            $transaction->update($this->transactionId, $status_id);
        } catch (Throwable $e) {
            report($e);
            $transaction->update($this->transactionId, Status::UNAUTHORIZED);
        }
    }
}
