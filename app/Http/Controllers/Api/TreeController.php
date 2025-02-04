<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tree;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TreeController extends Controller
{
    // Получить список всех деревьев
    public function index(): JsonResponse
    {
        $trees = Tree::where('user_id', auth()->id())->get();
        return response()->json($trees);
    }

    // Создать новое дерево
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $tree = Tree::create([
            'name' => $validatedData['name'],
            'user_id' => auth()->id(),
        ]);

        return response()->json($tree, 201);
    }

    // Получить конкретное дерево
    public function show($id): JsonResponse
    {
        $tree = Tree::where('user_id', auth()->id())->findOrFail($id);
        return response()->json($tree);
    }

    // Обновить дерево
    public function update(Request $request, $id): JsonResponse
    {
        $tree = Tree::where('user_id', auth()->id())->findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $tree->update($validatedData);

        return response()->json($tree);
    }

    // Удалить дерево
    public function destroy($id): JsonResponse
    {
        $tree = Tree::where('user_id', auth()->id())->findOrFail($id);
        $tree->delete();

        return response()->json(null, 204);
    }
}