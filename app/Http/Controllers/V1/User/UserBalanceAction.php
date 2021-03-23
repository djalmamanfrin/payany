<?php

namespace PayAny\Http\Controllers\V1\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use PayAny\Services\Balance;
use PayAny\Services\UserActions;
use Throwable;

class UserBalanceAction
{
    protected UserActions $service;

    public function __construct(UserActions $service)
    {
        $this->service = $service;
    }

    public function balance(int $id, Balance $balance): JsonResponse
    {
        try {
           $userBalance = $this->service->balance($balance, $id);
            return responseHandler()->success(Response::HTTP_OK, ['balance' => $userBalance]);
        } catch (Throwable $e) {
            return responseHandler()->error($e);
        }
    }
}
