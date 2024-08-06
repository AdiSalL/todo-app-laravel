<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodoList(){
        $this->withSession([
            "user"=> "admin",
            "todolist"=> [
                "id" => "1",
                "todo" => "makan"
            ],
            [
                "id" => "2",
                "todo" => "minum"
            ],
            [
                "id" => "1",
                "todo" => "berak"
            ]
        ])->get("/todolist")
        ->assertSeeText("1")
        ->assertSeeText("makan")
        ->assertSeeText("3")
        ->assertSeeText("minum")
        ->assertSeeText("2")
        ->assertSeeText("berak")
        ;
    }

    public function testAddTodoFailed() {
        $this->withSession([
            "user" => "admin"
        ])->post("/todolist", [])->assertSeeText("Todo Is Required");
    }

    public function testAddTodoSuccess(){
        $this->withSession([
            "user" => "admin"
        ])->post("/todolist", [
            "todo" => "makan"
        ])->assertRedirect("/todolist");
    }

    public function testRemoveTodoList(){
        $this->withSession([
            "user"=> "admin",
            "todolist"=> [
                "id" => "1",
                "todo" => "makan"
            ],
        ])->post("/todolist/1/delete")
        ->assertRedirect("/todolist");
    }

}


