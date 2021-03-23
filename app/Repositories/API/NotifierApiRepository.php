<?php

namespace PayAny\Repositories\API;

use Illuminate\Http\Response;
use InvalidArgumentException;
use PayAny\Models\Notification;
use PayAny\Repositories\API\Interfaces\NotifierApiInterface;
use Psr\Http\Message\ResponseInterface;

class NotifierApiRepository extends ApiRepository implements NotifierApiInterface
{
    public function __construct()
    {
        $host = config('api.notifier.host');
        parent::__construct($host);
    }

    public function notifyPayee(): ResponseInterface
    {
        return parent::get();
    }
}
