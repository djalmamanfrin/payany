<?php

namespace PayAny\Models;

use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

class Status extends Model
{
    const NEW = 1;
    const AUTHORIZED = 2;
    const UNAUTHORIZED = 3;
    const PAYEE_CREDITED = 4;
    const PAYEE_NOT_CREDITED = 5;
    const PAYER_DEBITED = 6;
    const PAYER_NOT_DEBITED = 7;
    const NOTIFICATION_SENT = 8;
    const NOTIFICATION_NOT_SENT = 9;

    protected $table = 'status';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $casts = ['date' => 'Timestamp'];
    protected $fillable = ['name', 'description'];

    public static function status(): array
    {
        $reflector = new ReflectionClass(Status::class);
        return $reflector->getConstants();
    }
}
