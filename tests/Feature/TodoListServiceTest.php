<?php

namespace Tests\Feature;

use App\Services\TodoListService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TodoListServiceTest extends TestCase
{
    private TodoListService $todoListService;

    protected function setUp():void {
        parent::setUp();

        $this->todoListService = $this->app->make(TodoListService::class);
    }

    public function testTodoList() {
        self::assertNotNull($this->todoListService);
    }

    public function testSaveTodo() {
        $this->todoListService->saveTodo("1", "Makan");

        $todolist = Session::get("todolist");
    
        foreach($todolist as $value) {
            self::assertEquals(1, $value["id"]);
        }
    }

    public function testGetTodoListEmpty() {
        self::assertEquals([], $this->todoListService->getTodoList());
    }

    public function testGetTodoListNotEmpty() {
        $expected = [
            [
                "id" => "1",
                "todo" => 'Makan'
            ],
            [
                "id" => "2",
                "todo" => 'Minum'
            ]
        ];
        $this->todoListService->saveTodo("1", "Makan");
        $this->todoListService->saveTodo("2", "Minum");
        self::assertEquals($expected, $this->todoListService->getTodoList());
    }
    
    public function testRemoveTodo() {

        $this->todoListService->saveTodo("1", "Makan");
        $this->todoListService->saveTodo("2", "Minum");
        self::assertEquals(2, sizeof($this->todoListService->getTodoList()));

        $this->todoListService->removeTodo(2);

        self::assertEquals(1, sizeof($this->todoListService->getTodoList()));
    }
    


}
