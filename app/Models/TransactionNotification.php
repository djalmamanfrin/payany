<?php


namespace PayAny\Models;


class TransactionNotification
{
    protected $table = 'transactions_notification';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $casts = ['date' => 'Timestamp'];
    protected $fillable = ['transaction_event_id', 'payload', 'status_code'];
}
