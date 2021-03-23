<?php

namespace Tests\Services;

use Illuminate\Http\Response;
use InvalidArgumentException;
use Mockery;
use PayAny\Repositories\DB\WalletRepository;
use PayAny\Services\Balance;
use Tests\TestCase;

class BalanceTest extends TestCase
{
    public function provider()
    {
        $wallet_id = 1;
        $repository = Mockery::mock(WalletRepository::class);
        $repository->shouldReceive([
            'getBalance' => 10
        ]);
        return [
            [$repository, $wallet_id]
        ];
    }

    /**
     * @dataProvider provider
     */
    public function testGetMethodIsFloat(WalletRepository $repository, int $walletId)
    {
        $balance = new Balance($repository);
        $this->assertIsFloat($balance->get($walletId));
    }

    /**
     * @dataProvider provider
     */
    public function testBalanceGreaterThanValue(WalletRepository $repository, int $walletId)
    {
        $value = 5;
        $balance = new Balance($repository);
        $this->assertTrue($balance->has($walletId, $value));
    }

    /**
     * @dataProvider provider
     */
    public function testBalanceLessThanValue(WalletRepository $repository, int $walletId)
    {
        $value = 11;
        $balance = new Balance($repository);
        $this->assertFalse($balance->has($walletId, $value));
    }
}
