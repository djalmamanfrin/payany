<?php

namespace PayAny\Repositories\DB;

use Illuminate\Http\Response;
use InvalidArgumentException;
use PayAny\Models\Authorization;
use PayAny\Repositories\DB\Interfaces\AuthorizationRepositoryInterface;

class AuthorizationRepository implements AuthorizationRepositoryInterface
{
    private Authorization $model;

    public function __construct(Authorization $model)
    {
        $this->model = $model;
    }

    public function fill(array $values): Authorization
    {
        return $this->model->fill($values);
    }

    private function expectInvalidArgumentExceptionIfFillableEmpty()
    {
        if (empty($this->model->getFillable())) {
            $error = 'Fillable of ' . Authorization::class . 'class empty';
            throw new InvalidArgumentException($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function store(): bool
    {
        $this->expectInvalidArgumentExceptionIfFillableEmpty();
        return $this->model->save();
    }
}
