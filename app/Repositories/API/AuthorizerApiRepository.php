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
    private int $transactionEventId;
    private Authorization $model;

    public function __construct(Authorization $model, int $transactionEventId)
    {
        $host = config('api.authorizer.host');
        parent::__construct($host);
        $this->model = $model;
        $this->transactionEventId = $transactionEventId;
    }

    public function authorize(): ResponseInterface
    {
        return parent::get();
    }

    public function store(ResponseInterface $response): int
    {
        return $this->model
            ->fill([
                'transaction_id' => $this->transactionEventId,
                'payload' => $response->getBody()->getContents(),
                'status_code' => $response->getStatusCode()
            ])
            ->save();
    }
}
