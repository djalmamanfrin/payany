<?php

namespace PayAny\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use WalletTransactions;

class Wallet extends Model
{
    use HasFactory;

    protected $table = 'wallets';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $casts = ['date' => 'Timestamp'];
    protected $fillable = ['uuid'];

    public function transactions(): Collection
    {
        return $this->hasMany(WalletTransactions::class)->get()->first();
    }
}
