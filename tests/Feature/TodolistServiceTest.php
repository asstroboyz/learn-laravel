<?php

namespace Tests\Feature;

use App\Services\TodolistService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TodolistServiceTest extends TestCase
{
    private TodolistService $todolistService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->todolistService = $this->app->make(TodolistService::class);
    }

    public function testTodolistNotNull()
    {
        self::assertNotNull($this->todolistService);
    }

    public function testSaveTodo()
    {
        $todoId = '1';
        $todo = 'Test Todo';

        $this->todolistService->saveTodo($todoId, $todo);
        $todoList = Session::get("todolist");
        foreach ($todoList as $value) {
            self::assertEquals($todoId, $value['id']);
            self::assertEquals($todo, $value['todo']);
        }
    }

    public function testTodoListEmpty()
    {
        self::assertEquals([], $this->todolistService->getTodolist());
    }

    public function testGetTodolist()
    {
        $expectedTodo = [
            [
                'id' => '1',
                'todo' => 'Test Todo'
            ],
            [
                'id' => '2',
                'todo' => 'Another Todo'
            ]
        ];
        $this->todolistService->saveTodo('1', 'Test Todo');
        $this->todolistService->saveTodo('2', 'Another Todo');
        self::assertEquals($expectedTodo, $this->todolistService->getTodolist());
    }

    public function testRemoveTodo()
    {

        $this->todolistService->saveTodo('1', 'Test Todo');
        $this->todolistService->saveTodo('2', 'Another Todo');

        // Total: 2
        self::assertCount(2, $this->todolistService->getTodolist());

        // Hapus id yang tidak ada: tidak berubah
        $this->todolistService->removeTodo('3');
        self::assertCount(2, $this->todolistService->getTodolist());

        // Hapus todo dengan id '1'
        $this->todolistService->removeTodo('1');
        self::assertCount(1, $this->todolistService->getTodolist());

        // Hapus todo dengan id '2'
        $this->todolistService->removeTodo('2');
        self::assertCount(0, $this->todolistService->getTodolist());


    }
}
