<?php

namespace PayAny\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransactions extends Model
{
    use HasFactory;

    protected $table = 'wallets';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $casts = ['date' => 'Timestamp'];
    protected $fillable = ['wallet_id','transaction_id', 'type', 'value'];

    public function wallet(): Wallet
    {
        return $this->belongsTo(Wallet::class)->get()->first();
    }

    public function transaction(): Transaction
    {
        return $this->belongsTo(Transaction::class)->get()->first();
    }

    public function turnValueIntoNegative(): float
    {
        if ($this->value < 0) {
            return $this->value;
        }
        return $this->value *= -1;
    }
}
