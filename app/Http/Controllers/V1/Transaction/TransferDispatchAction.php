<?php

namespace PayAny\Http\Controllers\V1\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PayAny\Http\Controllers\Controller;
use PayAny\Services\Transfer;
use Throwable;

class TransferDispatchAction extends Controller
{
    public function dispatch(int $id, Request $request, Transfer $transfer): JsonResponse
    {
        try {
            $value = $request->get('value');
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
