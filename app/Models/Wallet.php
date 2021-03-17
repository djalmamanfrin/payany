<?php

namespace PayAny\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'wallets';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $casts = ['date' => 'Timestamp'];
    protected $fillable = ['transaction_event_id', 'type', 'value'];

    public function transactionEvent(): TransactionEvent
    {
        return $this->hasOne(TransactionEvent::class)->get()->first();
    }
}
