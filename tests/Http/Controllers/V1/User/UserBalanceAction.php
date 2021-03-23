<?php


namespace Tests\Http\Controllers\User;


use Illuminate\Http\Response;
use Tests\TestCase;

class UserBalanceAction extends TestCase
{
    public function testBalance()
    {
        $id = 2;
        $response = $this->call('GET', "api/v1/users/{$id}/balance");
        $this->assertEquals(Response::HTTP_OK, $response->status());
        $this->seeJsonStructure([]);
    }

}
