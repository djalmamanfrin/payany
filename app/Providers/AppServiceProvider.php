<?php

namespace PayAny\Providers;

use Illuminate\Support\ServiceProvider;
use PayAny\Models\Wallet;
use PayAny\Services\Credit;
use PayAny\Services\Debit;
use PayAny\Services\Interfaces\UserServiceInterface;
use PayAny\Services\Transaction;
use PayAny\Services\UserService;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Wallet::class);
        $this->app->singleton(Credit::class);
        $this->app->singleton(Debit::class);
        $this->app->singleton(Transaction::class);
        $this->app->singleton(UserServiceInterface::class, UserService::class);
    }
}
