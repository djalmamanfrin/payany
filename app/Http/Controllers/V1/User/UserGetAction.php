<?php


namespace PayAny\Http\Controllers\V2;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use PayAny\Services\UserActions;
use Throwable;

class UserGetAction
{
    protected UserActions $service;

    public function __construct(UserActions $service)
    {
        $this->service = $service;
    }

    public function get(int $id): JsonResponse
    {
        try {
            $user = $this->service->get($id);
            return responseHandler()->success(Response::HTTP_OK, $user);
        } catch (Throwable $e) {
            return responseHandler()->error($e);
        }
    }
}
