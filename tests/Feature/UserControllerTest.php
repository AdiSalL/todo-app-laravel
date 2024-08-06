<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage() {
        $this->get("/login")
        ->assertSeeText("Login");
    }

    public function testLoginSuccess() {
        $this->post("/login", [
            "user" => "admin",
            "password" => "admin",
        ])->assertRedirect("/")
        ->assertSessionHas("user", "admin");
    }

    public function testLoginForUserAlreadyLogin() {
        $this->withSession([
            "user" => "admin",
        ])->post("/login", [
            "user" => "admin",
            "password" => "admin",
        ])->assertRedirect("/");
    }


    public function testLoginFailed() {
        $this->post("/login", [
            "user" => "salah",
            "password" => "salah"
        ])->assertSeeText("User or password is wrong");
    }

    public function testLoginValidationError() {
        $this->post("/login", [])
        ->assertSeeText("User Or Password is required");
    }

    public function testLogOut() {
        $this->withSession([
            "user" => "admin"
        ])->post("logout")->assertRedirect("/")->assertSessionMissing("user");
    }

    public function testLoginPageForMember() {
        $this->withSession([
            "user" => "admin"
        ])->get("/login")
        ->assertRedirect("/");
    }

    public function testGuest() {
        $this->post("/logout")->assertRedirect("/");
    }
}
