<?php

namespace PayAny\Jobs;

use Illuminate\Http\Response;
use PayAny\Models\Notification;
use PayAny\Models\Status;
use PayAny\Services\Credit;
use PayAny\Services\Debit;
use PayAny\Services\Transaction;
use Throwable;

class ProcessTransaction extends Job
{
    public function handle(Debit $debit, Credit $credit, Transaction $transaction, Notification $notification)
    {
        $this->authorize($transaction);
        $this->debitPayer($transaction, $debit);
        $this->creditPayee($transaction, $credit);
        $this->notifier($transaction, $notification);
    }

    private function authorize(Transaction $transaction)
    {
        try {
            $authorizer = $transaction->authorizer();
            $response = $authorizer->authorize();
            $status = ($response->getStatusCode() === Response::HTTP_OK)
                ? Status::AUTHORIZED
                : Status::UNAUTHORIZED;
            $authorizer->store($response);
            $transaction->update($status);
        } catch (Throwable $e) {
            report($e);
            $transaction->update(Status::UNAUTHORIZED);
        }
    }

    private function notifier(Transaction $transaction, Notification $notification)
    {
        try {
            $notifier = $transaction->notifier();
            $response = $notifier->notifyPayee();
            $status = ($response->getStatusCode() === Response::HTTP_OK)
                ? Status::NOTIFICATION_SENT
                : Status::NOTIFICATION_NOT_SENT;
            $notifier->store($response);
            $transaction->update($status);
        } catch (Throwable $e) {
            report($e);
            $transaction->update(Status::NOTIFICATION_NOT_SENT);
        }
    }

    private function debitPayer(Transaction $transaction, Debit $debit)
    {
        try {
            $status = $debit->dispatch()
                ? Status::PAYER_DEBITED
                : Status::PAYER_NOT_DEBITED;
            $transaction->update($status);
        } catch (Throwable $e) {
            report($e);
            $transaction->update(Status::PAYER_NOT_DEBITED);
        }
    }

    private function creditPayee(Transaction $transaction, Credit $credit)
    {
        try {
            $status = $credit->dispatch()
                ? Status::PAYEE_CREDITED
                : Status::PAYEE_NOT_CREDITED;
            $transaction->update($status);
        } catch (Throwable $e) {
            report($e);
            $transaction->update(Status::PAYEE_NOT_CREDITED);
        }
    }
}
