<?php

namespace PayAny\Repositories\API\Interfaces;

use Psr\Http\Message\ResponseInterface;

interface NotifierApiInterface
{
    public function notifyPayee(): ResponseInterface;
}
