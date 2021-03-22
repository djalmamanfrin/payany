<?php

namespace PayAny\Http\Controllers\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use InvalidArgumentException;
use PayAny\Http\Controllers\Controller;
use PayAny\Services\Credit;
use PayAny\Services\Transfer;
use PayAny\Services\UserActions;
use Throwable;

class UserController extends Controller
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

    public function store(Request $request): JsonResponse
    {
        try {
            $this->service->store($request->all());
            return responseHandler()->success(Response::HTTP_CREATED);
        } catch (Throwable $e) {
            return responseHandler()->error($e);
        }
    }

    public function transfer(int $id, Request $request, Transfer $transfer, Credit $credit): JsonResponse
    {
        try {
            $isEntrepreneur = $this->service->isEntrepreneur($id);
            if (! $isEntrepreneur) {
                $error = 'Entrepreneur paying is not allowed to transfer';
                throw new InvalidArgumentException($error, Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $value = $request->get('value');
            $hasFunds = $this->service->hasFunds($credit, $id, $value);
            if (! $hasFunds) {
                $error = 'Payer has no funds to transfer';
                throw new InvalidArgumentException($error, Response::HTTP_UNPROCESSABLE_ENTITY);
            }

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

    public function credit(int $id, Request $request, Credit $credit)
    {
        $credit->fill([

        ]);
    }

    public function getBalance(int $id)
    {

    }
}
