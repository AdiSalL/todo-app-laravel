<?php

namespace App\Services\Impl;

use App\Models\Todo;
use App\Services\TodoListService;
use Illuminate\Support\Facades\Session;

class TodoListServiceImpl implements TodoListService{
    public function saveTodo(string $id, string $todo): void
    {
            $todo = new Todo([
"id" => $id,
"todo" => $todo,
            ]);
            $todo->save();
    }

    public function getTodoList(): array
    {
        return Todo::query()->get()->toArray();
    }

    public function removeTodo(string $todoId)
    {
        $todo = Todo::query()->find($todoId);
        $todo->delete();
    }

}