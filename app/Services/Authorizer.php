<?php


namespace PayAny\Services;


use Illuminate\Http\Response;
use InvalidArgumentException;
use PayAny\Repositories\API\Interfaces\AuthorizerApiInterface;
use PayAny\Repositories\DB\Interfaces\AuthorizationInterface;
use Psr\Http\Message\ResponseInterface;

class Authorizer
{
    private AuthorizationInterface $repository;
    private AuthorizerApiInterface $authorizer;

    public function __construct(AuthorizationInterface $repository, AuthorizerApiInterface $authorizer)
    {
        $this->repository = $repository;
        $this->authorizer = $authorizer;
    }

    public function dispatch(): ResponseInterface
    {
        return $this->authorizer->authorize();
    }

    public function fill(array $values)
    {
        $this->repository->fill($values);
    }

    public function store(): bool
    {
        if (empty($this->repository->getFill())) {
            $error = 'Fill method is empty';
            throw new InvalidArgumentException($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return $this->repository->store();
    }
}
