<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class registerationTest extends TestCase {
    use DatabaseTransactions;
    //normal registeration
    public function test0() {
        $userData = [
        'name'=> 'LLLLLX',
        'email' =>'5@g.com',
        'password' =>'111111',
        'password_confirmation'=> '111111',
        'role'=> 'admin'
        ];
        $req = new Request($userData);
        $controller = new RegisterController();
        $controller->register($req);
        $this->assertDatabaseHas('users', ['email'=>'5@g.com']);
    }
    //Exception handling  
    public function test1() {
        $userData = [
        '_token'=> 'sylFTg3AZHamlc9TgZb1DsTAUcd3KyePkfzBMkBe',
        'name'=> 'LLLLLX',
        'email' =>'5@g.com',
        'password' =>'111111',
        'password_confirmation'=> '111111',
        'role'=> ''
        ];
        $req = new Request($userData);
        $controller = new RegisterController();
        $this->expectException(ValidationException::class);
        $controller->register($req);
    }
}
