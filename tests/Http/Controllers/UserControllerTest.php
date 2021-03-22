<?php

namespace Tests\Http\Controllers;

use Illuminate\Http\Response;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testTransfer()
    {
        $id = 2;
        $response = $this->call('POST', "api/v1/users/{$id}/transfer", ['payee_id' => 3, 'value' => 10]);
        $this->assertEquals(Response::HTTP_CREATED, $response->status());
        $this->seeJsonStructure([]);
    }

}
