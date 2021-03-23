<?php

namespace Tests\Services;

use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Mockery;
use PayAny\Models\Transaction;
use PayAny\Models\User;
use PayAny\Models\Wallet;
use PayAny\Repositories\API\Interfaces\AuthorizerApiInterface;
use PayAny\Repositories\API\Interfaces\NotifierApiInterface;
use PayAny\Repositories\DB\Interfaces\WalletRepositoryInterface;
use PayAny\Services\Transfer;
use Tests\TestCase;

class NewTransactionTest extends TestCase
{
    public function payload()
    {
        $payload = ['payer' => 1, 'payee' => 5, 'value' => 10.00];
        return [
            [$payload]
        ];
    }

    /**
     * @dataProvider payload
     */
    public function ExpectInvalidArgumentExceptionIfStoreMethodReturnIsFalse(array $payload)
    {
        $this->expectException(InvalidArgumentException::class);

        $model = Mockery::mock(Transfer::class);
        $model->shouldReceive([
            'fill' => $payload,
            'save' => false
        ]);
        $transaction = new Transaction($model, $payload);
        $transaction->dispatch();
    }

    /**
     * @dataProvider payload
     */
    public function ExpectHttpUnprocessableEntityStatusCodeIfStoreMethodReturnIsFalse(array $payload)
    {
        $this->expectExceptionCode(Response::HTTP_UNPROCESSABLE_ENTITY);

        $model = Mockery::mock(Transfer::class);
        $model->shouldReceive([
            'fill' => $payload,
            'save' => false
        ]);
        $transaction = new Transaction($model, $payload);
        $transaction->dispatch();
    }

    /**
     * @dataProvider payload
     */
    public function PayerColumnRequiredValidation(array $payload)
    {
        unset($payload['payer']);
        $this->expectException(ValidationException::class);

        $model = Mockery::mock(Transfer::class);
        $model->shouldReceive([
            'fill' => $payload,
            'save' => false
        ]);
        $transaction = new Transaction($model, $payload);
        $transaction->dispatch();

    }

    /**
     * @dataProvider payload
     */
    public function PayeeColumnRequiredValidation(array $payload)
    {
        unset($payload['payee']);
        $this->expectException(ValidationException::class);

        $model = Mockery::mock(Transfer::class);
        $model->shouldReceive([
            'fill' => $payload,
            'save' => false
        ]);
        $transaction = new Transaction($model, $payload);
        $transaction->dispatch();

    }

    /**
     * @dataProvider payload
     */
    public function ValueColumnRequiredValidation(array $payload)
    {
        unset($payload['value']);
        $this->expectException(ValidationException::class);

        $model = Mockery::mock(Transfer::class);
        $model->shouldReceive([
            'fill' => $payload,
            'save' => false
        ]);
        $transaction = new Transaction($model, $payload);
        $transaction->dispatch();

    }

    /**
     * @dataProvider payload
     */
    public function IfReturnOfMethodAuthorizerIsAnAuthorizerInterface(array $payload)
    {
        $model = Mockery::mock(Transfer::class);
        $model->shouldReceive([
            'getId' => 1
        ]);
        $transaction = new Transaction($model, $payload);
        $this->assertInstanceOf(AuthorizerApiInterface::class, $transaction->authorizer());
    }

    /**
     * @dataProvider payload
     */
    public function IfReturnReturnOfMethodNotifierIsANotifierInterface(array $payload)
    {
        $model = Mockery::mock(Transfer::class);
        $model->shouldReceive([
            'getId' => 1
        ]);
        $transaction = new Transaction($model, $payload);
        $this->assertInstanceOf(NotifierApiInterface::class, $transaction->notifier());
    }

    /**
     * @dataProvider payload
     */
    public function IfReturnOfMethodPayerWalletIsANotifierInterface(array $payload)
    {
        $wallet = Mockery::mock(Wallet::class);
        $wallet->shouldReceive([
            'fill' => $wallet
        ]);
        $user = Mockery::mock(User::class);
        $user->shouldReceive([
            'wallet' => $wallet
        ]);
        $model = Mockery::mock(Transfer::class);
        $model->shouldReceive([
            'getId' => 1,
            'getFillable' => $payload,
            'payee' => $user
        ]);
        $transaction = new Transaction($model, $payload);
        $this->assertInstanceOf(WalletRepositoryInterface::class, $transaction->payerWallet());
    }

    /**
     * @dataProvider payload
     */
    public function IfReturnOfMethodPayeeWalletIsANotifierInterface(array $payload)
    {
        $wallet = Mockery::mock(Wallet::class);
        $wallet->shouldReceive([
            'fill' => $wallet
        ]);
        $user = Mockery::mock(User::class);
        $user->shouldReceive([
            'wallet' => $wallet
        ]);
        $model = Mockery::mock(Transfer::class);
        $model->shouldReceive([
            'getId' => 1,
            'getFillable' => $payload,
            'payee' => $user
        ]);
        $transaction = new Transaction($model, $payload);
        $this->assertInstanceOf(WalletRepositoryInterface::class, $transaction->payeeWallet());
    }

    /**
     * @dataProvider payload
     */
    public function ExpectExceptionIfStatusParamNotFoundInTransactionStatusClass(array $payload)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(Response::HTTP_UNPROCESSABLE_ENTITY);

        $model = Mockery::mock(Transfer::class);
        $transaction = new Transaction($model, $payload);
        $transaction->update('status');
    }
}
