<?php

namespace Tests\Services;

use Illuminate\Http\Response;
use InvalidArgumentException;
use Mockery;
use PayAny\Repositories\DB\WalletRepository;
use PayAny\Services\Credit;
use Tests\TestCase;

class CreditTest extends TestCase
{
    public function testFillMethod()
    {
        $values = [
            'transaction_id' => 1,
            'wallet_id' => 1,
            'type' => 'transfer',
            'value' => 10
        ];
        $repository = Mockery::mock(WalletRepository::class);
        $repository->shouldReceive([
            'getFill' => $values,
            'fill' => $values,
            'turnValueIntoNegative' => null,
            'store' => true
        ]);

        $credit = new Credit($repository);
        $this->assertTrue($credit->store());
    }

    public function testExpectInvalidArgumentExceptionIfFillMethodIsEmpty()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(Response::HTTP_UNPROCESSABLE_ENTITY);

        $repository = Mockery::mock(WalletRepository::class);
        $repository->shouldReceive([
            'getFill' => [],
            'fill' => [],
            'turnValueIntoNegative' => null,
            'store' => true
        ]);

        $credit = new Credit($repository);
        $this->assertTrue($credit->store());
    }
}
