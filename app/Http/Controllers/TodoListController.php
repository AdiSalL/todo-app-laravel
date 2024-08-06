<?php

namespace App\Http\Controllers;

use App\Services\TodoListService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TodoListController extends Controller
{   
    private TodoListService $todoListService;

    public function __construct(TodoListService $todoListService)
    {
        $this->todoListService = $todoListService;
    }

    public function todoList(Request $request) {
        $todoList = $this->todoListService->getTodoList();
        return response()->view("todolist.todo", [
            "title" => "Todo List",
            "todolist" => $todoList,
        ]);
    }

    public function addTodo(Request $request) {
        $todo = $request->input("todo");
        if(empty($todo)) {
            $todoList = $this->todoListService->getTodoList();
            return response()->view("todolist.todo", [
                "title" => 'Todolist',
                "todolist" => $todoList,
                "error" => "Todo Is Required"
            ]);
        }

        $this->todoListService->saveTodo(uniqid(), $todo);

        return redirect()->action([TodoListController::class, "todolist"]);
    }

    public function removeTodo(Request $request, string $todoId):RedirectResponse {
        $this->todoListService->removeTodo($todoId);
        return redirect()->action([TodoListController::class, "todolist"]);
    }
}
