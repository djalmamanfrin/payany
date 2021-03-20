<?php

namespace PayAny\Providers;

use Illuminate\Support\ServiceProvider;
use PayAny\Repositories\DB\Interfaces\TransactionRepositoryInterface;
use PayAny\Repositories\DB\Interfaces\UserRepositoryInterface;
use PayAny\Repositories\DB\Interfaces\WalletRepositoryInterface;
use PayAny\Repositories\DB\TransactionRepository;
use PayAny\Repositories\DB\UserRepository;
use PayAny\Repositories\DB\WalletRepository;

class AppRepositoryProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(WalletRepositoryInterface::class, WalletRepository::class);
        $this->app->singleton(TransactionRepositoryInterface::class, TransactionRepository::class);
    }
}
