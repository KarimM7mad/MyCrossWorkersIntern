<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;

class loginTest extends TestCase {

    use DatabaseTransactions;

    //normal Login senario
    public function test0() {
        $controller = new LoginController();
        $loginData = [
            'email' => '22@g.com',
            'password' => '1111',
        ];
        $req = new Request($loginData);
        $controller->login($req);
        $this->assertEquals(2, auth()->user()->id);
    }

}
