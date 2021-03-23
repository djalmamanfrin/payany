<?php

namespace PayAny\Providers;

use Illuminate\Support\ServiceProvider;
use PayAny\Repositories\API\AuthorizerApiRepository;
use PayAny\Repositories\API\Interfaces\AuthorizerApiInterface;
use PayAny\Repositories\API\Interfaces\NotifierApiInterface;
use PayAny\Repositories\API\NotifierApiRepository;
use PayAny\Repositories\DB\AuthorizationRepository;
use PayAny\Repositories\DB\Interfaces\AuthorizationInterface;
use PayAny\Repositories\DB\Interfaces\CreditInterface;
use PayAny\Repositories\DB\Interfaces\DebitInterface;
use PayAny\Repositories\DB\Interfaces\BalanceInterface;
use PayAny\Repositories\DB\Interfaces\NotificationInterface;
use PayAny\Repositories\DB\Interfaces\TransactionRepositoryInterface;
use PayAny\Repositories\DB\Interfaces\UserRepositoryInterface;
use PayAny\Repositories\DB\NotificationRepository;
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
        $this->app->singleton(BalanceInterface::class, WalletRepository::class);
        $this->app->singleton(TransactionRepositoryInterface::class, TransactionRepository::class);
        $this->app->singleton(AuthorizationInterface::class, AuthorizationRepository::class);
        $this->app->singleton(AuthorizerApiInterface::class, AuthorizerApiRepository::class);
        $this->app->singleton(NotificationInterface::class, NotificationRepository::class);
        $this->app->singleton(NotifierApiInterface::class, NotifierApiRepository::class);
    }
}
