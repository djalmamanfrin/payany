<?php

namespace PayAny\Models;

class NotSeller extends User
{
    protected $fillable = ['wallet_id', 'full_name', 'cpf', 'email', 'password'];
}
