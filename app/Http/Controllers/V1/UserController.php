<?php

namespace PayAny\Http\Controllers\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PayAny\Http\Controllers\Controller;
use PayAny\Services\Interfaces\UserServiceInterface;
use PayAny\Services\Transaction;
use Throwable;

class UserController extends Controller
{
    protected UserServiceInterface $service;

    public function __construct(UserServiceInterface $service)
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

    public function transfer(int $id, Request $request, Transaction $transaction): JsonResponse
    {
        try {

            \Ramsey\Uuid\Uuid::uuid4();
            $transaction->fill([
                'payer_id' => $id,
                'payee_id' => $request->get('payee_id'),
                'value' => $request->get('value')
            ]);
            $transaction->dispatch();
            return responseHandler()->success(Response::HTTP_CREATED);
        } catch (Throwable $e) {
            return responseHandler()->error($e);
        }
    }

    public function credit()
    {

    }

    public function debit()
    {

    }

    public function getBalance(int $id)
    {

    }
}
