<?php

namespace Tests\Http\Controllers\V1\User;

use Illuminate\Http\Response;
use Tests\TestCase;

class UserTransferAction extends TestCase
{
    public function testTransfer()
    {
        $id = 3;
        $response = $this->call('POST', "api/v1/users/{$id}/transfer", ['payee_id' => 5, 'value' => 11]);
        $this->assertEquals(Response::HTTP_CREATED, $response->status());
        $this->seeJsonStructure([]);
    }
}
