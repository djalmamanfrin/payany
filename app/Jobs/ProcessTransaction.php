<?php

namespace PayAny\Jobs;

use Illuminate\Http\Response;
use PayAny\Models\Status;
use PayAny\Models\Transaction;
use PayAny\Services\Authorizer;
use PayAny\Services\Credit;
use PayAny\Services\Debit;
use PayAny\Services\Notifier;
use PayAny\Services\Transfer;
use Throwable;

class ProcessTransaction extends Job
{
    private Transaction $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function handle(
        Debit $debit, Credit $credit, Transfer $transaction, Authorizer $authorizer, Notifier $notifier)
    {
        $this->authorize($transaction, $authorizer);
        $this->debitPayer($transaction, $debit);
        $this->creditPayee($transaction, $credit);
        $this->notifier($transaction, $notifier);
    }

    private function authorize(Transfer $transaction, Authorizer $authorizer)
    {
        try {
            $response = $authorizer->dispatch();
            $status_id = ($response->getStatusCode() === Response::HTTP_OK)
                ? Status::AUTHORIZED
                : Status::UNAUTHORIZED;
            $authorizer->fill([
                'transaction_id' => $this->transaction->id,
                'payload' => $response->getBody()->getContents(),
                'status_code' => $response->getStatusCode()
            ]);
            $authorizer->store();
            $transaction->update($this->transaction->id, $status_id);
        } catch (Throwable $e) {
            report($e);
            $transaction->update($this->transaction->id, Status::UNAUTHORIZED);
        }
    }

    private function notifier(Transfer $transaction, Notifier $notifier)
    {
        try {
            $response = $notifier->dispatch();
            $status_id = ($response->getStatusCode() === Response::HTTP_OK)
                ? Status::NOTIFICATION_SENT
                : Status::NOTIFICATION_NOT_SENT;
            $notifier->fill([
                'transaction_id' => $this->transaction->id,
                'payload' => $response->getBody()->getContents(),
                'status_code' => $response->getStatusCode()
            ]);
            $notifier->store();
            $transaction->update($this->transaction->id, $status_id);
        } catch (Throwable $e) {
            report($e);
            $transaction->update($this->transaction->id, Status::NOTIFICATION_NOT_SENT);
        }
    }

    private function debitPayer(Transfer $transaction, Debit $debit)
    {
        try {
            $walletId = $this->transaction->payer()->wallet()->id;
            $debit->fill([
                'transaction_id' => $this->transaction->id,
                'wallet_id' => $walletId,
                'type' => $this->transaction->type,
                'value' => $this->transaction->value
            ]);
            $status_id = $debit->dispatch()
                ? Status::PAYER_DEBITED
                : Status::PAYER_NOT_DEBITED;
            $transaction->update($this->transaction->id, $status_id);
        } catch (Throwable $e) {
            report($e);
            $transaction->update($this->transaction->id, Status::PAYER_NOT_DEBITED);
        }
    }

    private function creditPayee(Transfer $transaction, Credit $credit)
    {
        try {
            $walletId = $this->transaction->payee()->wallet()->id;
            $credit->fill([
                'transaction_id' => $this->transaction->id,
                'wallet_id' => $walletId,
                'type' => $this->transaction->type,
                'value' => $this->transaction->value
            ]);
            $status_id = $credit->dispatch()
                ? Status::PAYEE_CREDITED
                : Status::PAYEE_NOT_CREDITED;
            $transaction->update($this->transaction->id, $status_id);
        } catch (Throwable $e) {
            report($e);
            $transaction->update($this->transaction->id, Status::PAYEE_NOT_CREDITED);
        }
    }
}
