<?php


namespace PayAny\Services;


use PayAny\Repositories\API\Interfaces\AuthorizerApiInterface;
use Psr\Http\Message\ResponseInterface;

class Authorizer
{
    private AuthorizationRepositoryInterface $repository;
    private AuthorizerApiInterface $authorizer;

    public function __construct(AuthorizationRepositoryInterface $repository, AuthorizerApiInterface $authorizer)
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

    public function store()
    {
        $this->repository->store();
    }
}
