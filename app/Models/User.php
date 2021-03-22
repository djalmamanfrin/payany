<?php

namespace PayAny\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['wallet_id', 'name', 'document', 'email', 'password'];
    protected $casts = ['date' => 'Timestamp'];

    public function wallet(): Wallet
    {
        return $this->hasOne(Wallet::class)->get()->first();
    }

    public function notifications(): Collection
    {
        return $this->hasMany(Notification::class)->get();
    }

    public function transactions(): Collection
    {
        return $this->hasMany(Transaction::class)->get();
    }
}
