<?php


namespace PayAny\Observers;


use PayAny\Jobs\ProcessTransaction;
use PayAny\Models\Transaction;

class TransactionObserver
{
    public function created(Transaction $transaction)
    {
        dispatch(new ProcessTransaction($transaction));
    }
}
