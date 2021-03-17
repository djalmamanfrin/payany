<?php

namespace PayAny\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class TransactionEvent extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $casts = ['date' => 'Timestamp'];
    protected $fillable = ['payer', 'payee', 'user_id', 'status_id', 'type', 'value'];

    public function status(): TransactionStatus
    {
        return $this->belongsTo(TransactionStatus::class)->get()->first();
    }

    public function transactionsAuthorization(): Collection
    {
        return $this->hasMany(TransactionAuthorization::class)->get();
    }

    public function transactionsNotification(): Collection
    {
        return $this->hasMany(TransactionNotification::class)->get();
    }
}
