<?php

namespace PayAny\Http\Controllers\V1\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use InvalidArgumentException;
use PayAny\Http\Controllers\Controller;
use PayAny\Services\Balance;
use PayAny\Services\Transfer;
use PayAny\Services\UserActions;
use Throwable;

class UserTransferAction extends Controller
{
    protected UserActions $service;

    public function __construct(UserActions $service)
    {
        $this->service = $service;
    }

    public function transfer(int $id, Request $request, Transfer $transfer, Balance $balance): JsonResponse
    {
        try {
            $fields = config('validator.user.transfer.fields');
            $messages = config('validator.user.transfer.messages');
//            $this->validate($request, $fields, $messages);

            $isEntrepreneur = $this->service->isEntrepreneur($id);
            if ($isEntrepreneur) {
                $error = 'Entrepreneur paying is not allowed to transfer';
                throw new InvalidArgumentException($error, Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $value = $request->get('value');
            $hasBalance = $this->service->hasBalance($balance, $id, $value);
//            if (! $hasBalance) {
//                $error = 'Payer has no funds to transfer';
//                throw new InvalidArgumentException($error, Response::HTTP_UNPROCESSABLE_ENTITY);
//            }

            $transfer->fill([
                'payer_id' => $id,
                'payee_id' => $request->get('payee_id'),
                'value' => $value
            ]);
            $transfer->dispatch();
            return responseHandler()->success(Response::HTTP_CREATED);
        } catch (Throwable $e) {
            return responseHandler()->error($e);
        }
    }
}
