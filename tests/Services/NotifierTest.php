<?php

namespace Tests\Services;

use Mockery;
use PayAny\Repositories\API\Interfaces\NotifierApiInterface;
use PayAny\Repositories\DB\Interfaces\NotificationInterface;
use PayAny\Services\Notifier;
use Tests\TestCase;

class NotifierTest extends TestCase
{
    public function provider()
    {
        $values = [
            'transaction_id' => 1,
            'payload' => json_encode(['message' => 'enviado']),
            'status_code' => 200
        ];
        $repository = Mockery::mock(NotificationInterface::class);
        $repository->shouldReceive([
            'getFill' => $values,
            'fill' => $values,
            'store' => true
        ]);

        $notifier = Mockery::mock(NotifierApiInterface::class);
        $notifier->shouldReceive([
            'notifyPayee' => new \GuzzleHttp\Psr7\Response()
        ]);
        return [
            [$repository, $notifier, $values]
        ];
    }

    /**
     * @dataProvider provider
     */
    public function testStoreMethod(NotificationInterface $repository, NotifierApiInterface $notifier, array $values)
    {
        $notifier = new Notifier($repository, $notifier);
        $notifier->fill($values);
        $this->assertTrue($notifier->store());
    }
}
