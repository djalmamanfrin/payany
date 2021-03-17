<?php


namespace PayAny\Models;


class TransactionAuthorization
{
    protected $table = 'transactions_authorization';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $casts = ['date' => 'Timestamp'];
    protected $fillable = ['transaction_event_id', 'payload', 'status_code'];
}
