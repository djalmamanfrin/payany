<?php

namespace PayAny\Providers;

use Illuminate\Support\ServiceProvider;
use PayAny\Repositories\DB\Interfaces\CreditInterface;
use PayAny\Repositories\DB\Interfaces\DebitInterface;
use PayAny\Repositories\DB\Interfaces\GetFundsInterface;
use PayAny\Repositories\DB\Interfaces\TransactionRepositoryInterface;
use PayAny\Repositories\DB\Interfaces\UserRepositoryInterface;
use PayAny\Repositories\DB\TransactionRepository;
use PayAny\Repositories\DB\UserRepository;
use PayAny\Repositories\DB\WalletRepository;

class AppRepositoryProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(CreditInterface::class, WalletRepository::class);
        $this->app->singleton(DebitInterface::class, WalletRepository::class);
        $this->app->singleton(GetFundsInterface::class, WalletRepository::class);
        $this->app->singleton(TransactionRepositoryInterface::class, TransactionRepository::class);
    }
}
