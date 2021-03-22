<?php

namespace PayAny\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{

    protected $table = 'transactions';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $casts = ['date' => 'Timestamp'];
    protected $fillable = ['payer_id', 'payee_id', 'status_id', 'type', 'value'];

    public function getId(): int
    {
        return $this->id;
    }

    public function payer(): User
    {
        return $this->belongsTo(User::class, 'payer', 'id')->get()->first();
    }

    public function payee(): User
    {
        return $this->belongsTo(User::class, 'payee', 'id')->get()->first();
    }

    public function status(): Status
    {
        return $this->belongsTo(Status::class)->get()->first();
    }

    public function transactionsAuthorization(): BelongsTo
    {
        return $this->belongsTo(Authorization::class);
    }
}
