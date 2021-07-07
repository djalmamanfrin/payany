<?php


namespace PayAny\Http\Controllers\V2;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PayAny\Models\Transaction;
use PayAny\Services\Balance;
use PayAny\Services\UserService;
use Throwable;

class UserController
{
    private UserService $service;
    public function __construct(UserService $service)
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

    public function balance(int $userId, Balance $balance): JsonResponse
    {
        try {
            $userBalance = $this->service->balance($balance, $userId);
            return responseHandler()->success(Response::HTTP_OK, ['balance' => $userBalance]);
        } catch (Throwable $e) {
            return responseHandler()->error($e);
        }
    }

    public function transfer(int $id, Request $request): JsonResponse
    {
        try {
            $this->service->transfer($id, $request);
            return responseHandler()->success(Response::HTTP_CREATED);
        } catch (Throwable $e) {
            return responseHandler()->error($e);
        }
    }
}
