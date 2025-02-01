<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    // Получить список персон
    public function index()
    {
        $persons = Person::all();
        return response()->json($persons);
    }

    // Создать новую персону
    public function store(Request $request)
    {
        // Валидация входных данных
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'death_date' => 'nullable|date',
            'tree_id' => 'required|exists:trees,id',
        ]);

        // Создаём персону
        $person = Person::create($validatedData);

        // Пытаемся установить новую персону как центральную для дерева
        $person->setAsCenterPerson($validatedData['tree_id']);

        // Возвращаем созданную персону
        return response()->json($person, 201);
    }

    // Получить конкретную персону
    public function show($id)
    {
        $person = Person::findOrFail($id);
        return response()->json($person);
    }

    // Обновить персону
    public function update(Request $request, $id)
    {
        $person = Person::findOrFail($id);

        $validatedData = $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'death_date' => 'nullable|date',
            'tree_id' => 'sometimes|exists:trees,id',
        ]);

        $person->update($validatedData);
        return response()->json($person);
    }

    // Получить список персон по tree_id
    public function byTree($tree_id)
    {
        // Ищем всех персон с указанным tree_id
        $persons = Person::where('tree_id', $tree_id)->get();

        // Возвращаем результат в формате JSON
        return response()->json($persons);
    }

    // Удалить персону
    public function destroy($id)
    {
        $person = Person::findOrFail($id);
        $person->delete();
        return response()->json(null, 204);
    }
}
