<?php
namespace App\Services\Impl;

use App\Services\TodolistService;
use Illuminate\Support\Facades\Session;

class TodolistServiceImpl implements TodolistService
{

    public function saveTodo(string $id, string $todo, string $category): void
    {
        $data   = session()->get('todolist', []);
        $data[] = [
            'id'       => $id,
            'todo'     => $todo,
            'category' => $category,
        ];
        session()->put('todolist', $data);
    }

    public function getTodolist(): array
    {
        return Session::get("todolist", []);
    }

    public function removeTodo(string $todoId)
    {
        $todolist = Session::get("todolist");

        foreach ($todolist as $index => $value) {
            if ($value['id'] == $todoId) {
                unset($todolist[$index]);
                break;
            }
        }

        Session::put("todolist", $todolist);
    }

}
