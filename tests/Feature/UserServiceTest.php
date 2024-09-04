<?php

namespace Tests\Feature;

use App\Services\UserService;
use App\Services\Impl\UserServiceImpl;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB as FacadesDB;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    function setUp():void {
        parent::setUp();
        
        FacadesDB::delete("DELETE FROM users");
        $this->userService = $this->app->make(UserService::class);
    }   


    public function testLoginSuccess() {
        $this->seed([UserSeeder::class]);
        self::assertTrue($this->userService->login("admin@admin.com", "rahasia"));
    }

    public function testLoginFailed() {
        self::assertFalse($this->userService->login("admin", "wrong"));
    }

    public function testLoginWrongPassword() {
        self::assertFalse($this->userService->login("wrong", "admin"));
    }
}
