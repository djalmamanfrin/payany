<?php

namespace PayAny\Http\Controllers\V1\Wallet;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use PayAny\Services\Balance;
use PayAny\Services\UserActions;
use Throwable;

class WalletGetBalanceAction
{

    public function getBalance(int $id, Balance $balance): JsonResponse
    {
        try {
           $balance = $balance->get($id);
            return responseHandler()->success(Response::HTTP_OK, ['balance' => $balance]);
        } catch (Throwable $e) {
            return responseHandler()->error($e);
        }
    }
}
