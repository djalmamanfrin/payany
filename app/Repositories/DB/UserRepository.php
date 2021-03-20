<?php


namespace PayAny\Repositories\DB;


use Illuminate\Database\Eloquent\Builder;
use PayAny\Models\User;
use PayAny\Repositories\DB\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    private User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    private function builder(): Builder
    {
        return $this->model->newQuery();
    }


    public function get(int $id): User
    {
        return $this->builder()->findOrFail($id)->get();
    }

    public function store(array $params): bool
    {
        return $this->model
            ->fill($params)
            ->save();
    }

    public function findPayerOrFail(int $id): User
    {
        return $this->builder()
            ->whereNotNull('cpf')
            ->whereNull('cnpj')
            ->findOrFail($id)
            ->get();
    }

    public function findPayeeOrFail(int $id): User
    {
        return $this->builder()
            ->findOrFail($id)
            ->get();
    }
}
