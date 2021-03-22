<?php

namespace PayAny\Repositories\API\Interfaces;

use Psr\Http\Message\ResponseInterface;

interface AuthorizerApiInterface
{
    public function authorize(): ResponseInterface;
}
