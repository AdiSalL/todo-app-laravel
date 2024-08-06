<?php

namespace Tests\Feature;

use App\Services\UserService;
use App\Services\Impl\UserServiceImpl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    function setUp():void {
        parent::setUp();

        $this->userService = $this->app->make(UserService::class);
    }   


    public function testLoginSuccess() {

        self::assertTrue($this->userService->login("admin", "admin"));
    }

    public function testLoginFailed() {
        self::assertFalse($this->userService->login("admin", "wrong"));
    }

    public function testLoginWrongPassword() {
        self::assertFalse($this->userService->login("wrong", "admin"));
    }
}
