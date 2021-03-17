<?php

namespace PayAny\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionStatus extends Model
{
    protected $table = 'transactions_status';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $casts = ['date' => 'Timestamp'];
    protected $fillable = ['name', 'description'];
}
