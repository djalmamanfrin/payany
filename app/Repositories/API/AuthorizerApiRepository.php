<?php

namespace PayAny\Repositories\API;

use Illuminate\Http\Response;
use InvalidArgumentException;
use PayAny\Models\Authorization;
use PayAny\Repositories\API\Interfaces\AuthorizerApiInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class AuthorizerApiRepository extends ApiRepository implements AuthorizerApiInterface
{
    public function __construct()
    {
        $host = config('api.authorizer.host');
        parent::__construct($host);
    }

    public function authorize(): ResponseInterface
    {
        return parent::get();
    }
}
