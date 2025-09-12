<?php
namespace App\Http\Controllers;

use App\Services\TodolistService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class Todolistcontroller extends Controller
{

    private TodolistService $todolistService;

    public function __construct(TodolistService $todolistService)
    {
        $this->todolistService = $todolistService;
    }

    public function todoList(Request $request)
    {
        $todolist = $this->todolistService->getTodolist();
        // Daftar kategori master (bisa diganti sesuai kebutuhan)
        $allCategories = ['Bug', 'Feature', 'Deploy', 'Docs', 'Personal', 'Review', 'Banner Ads', 'Social Media', 'Content Strategy', 'Email A/B Tests'];

        // Kategori dari data
        $grouped = collect($todolist)->groupBy('category')->toArray();

        // Gabungkan semua kategori biar sidebar & modal selalu muncul
        foreach ($allCategories as $cat) {
            if (! isset($grouped[$cat])) {
                $grouped[$cat] = [];
            }

        }
        ksort($grouped); // Urutkan alfabet

        $selected    = $request->query('category');
        $todosToShow = $selected && isset($grouped[$selected]) ? [$selected => $grouped[$selected]] : $grouped;

        return response()->view("todolist.todolist", [
            "title"            => "Sticky Wall",
            "grouped"          => $grouped,
            "todos"            => $todosToShow,
            "selectedCategory" => $selected,
            "allCategories"    => $allCategories,
        ]);
    }

    public function addTodo(Request $request)
    {
        $todo     = $request->input("todo");
        $category = $request->input("category");
        if (empty($todo) || empty($category)) {
            $todolist = $this->todolistService->getTodolist();
            $grouped  = collect($todolist)->groupBy('category')->toArray();
            return response()->view("todolist.todolist", [
                "title"   => "Todolist",
                "grouped" => $grouped,
                "error"   => "Todo & Category wajib diisi",
            ]);
        }
        $this->todolistService->saveTodo(uniqid(), $todo, $category);
        return redirect()->action([TodolistController::class, 'todoList']);
    }

    public function removeTodo(Request $request, string $todoId): RedirectResponse
    {
        $this->todolistService->removeTodo($todoId);
        return redirect()->action([TodolistController::class, 'todoList']);
    }
}
