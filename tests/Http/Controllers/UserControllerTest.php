<?php

namespace Tests\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testTransfer()
    {
        $id = 7;
        $response = $this->call('POST', "api/v1/users/{$id}/transfer", ['payee_id' => 8, 'value' => 11]);
        $this->assertEquals(Response::HTTP_CREATED, $response->status());
        $this->seeJsonStructure([]);
    }

    public function testBalance()
    {
        $id = 2;
        $response = $this->call('GET', "api/v1/users/{$id}/balance");
        $this->assertEquals(Response::HTTP_OK, $response->status());
        $this->seeJsonStructure([]);
    }

}
