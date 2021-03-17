<?php

namespace PayAny\Models;

class Seller extends User
{
    protected $fillable = ['wallet_id', 'full_name', 'cnpj', 'email', 'password'];
}
