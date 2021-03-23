<?php

namespace Tests\Services;

use Illuminate\Http\Response;
use InvalidArgumentException;
use Mockery;
use PayAny\Repositories\API\AuthorizerApiRepository;
use PayAny\Repositories\DB\Interfaces\AuthorizationInterface;
use PayAny\Repositories\DB\WalletRepository;
use PayAny\Services\Authorizer;
use PayAny\Services\Credit;
use Tests\TestCase;

class AuthorizerTest extends TestCase
{
    public function provider()
    {
        $values = [
            'transaction_id' => 1,
            'payload' => json_encode(['message' => 'autorizado']),
            'status_code' => 200
        ];
        $repository = Mockery::mock(AuthorizationInterface::class);
        $repository->shouldReceive([
            'getFill' => $values,
            'fill' => $values,
            'store' => true
        ]);

        $authorizer = Mockery::mock(AuthorizerApiRepository::class);
        $authorizer->shouldReceive([
            'authorize' => new \GuzzleHttp\Psr7\Response()
        ]);
        return [
            [$repository, $authorizer, $values]
        ];
    }

    /**
     * @dataProvider provider
     */
    public function testStoreMethod(AuthorizationInterface $repository, AuthorizerApiRepository $authorizer, array $values)
    {
        $authorizer = new Authorizer($repository, $authorizer);
        $authorizer->fill($values);
        $this->assertTrue($authorizer->store());
    }
}
