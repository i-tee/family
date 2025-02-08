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

    // Создать родителя
    public function createParent($child, $parent)
    {

        // Определяем родителя в зависимости от пола
        $childIdKey = $parent['gender'] == 1 ? 'father_id' : 'mother_id';

        if (array_key_exists($childIdKey, $child) && $child[$childIdKey] !== null) {

            return response()->json(['error' => 'У персоны уже есть такой родитель.'], 409);
        } else {

            // Создаем персону
            $person = Person::create($parent);
            $child[$childIdKey] = $person->id;
            // Создаем новый объект Request из массива данных
            $request = Request::create('/api/persons/' . $child['id'], 'POST', $child);
            return $this->update($request, $child['id']);
        }
    }

    // Создать ребенка
    public function createChild($child, $parent)
    {

        // Определяем родителя в зависимости от пола
        $parentIdKey = $parent['gender'] == 1 ? 'father_id' : 'mother_id';
        $child[$parentIdKey] = $parent['id'];

        // Создаем персону
        $person = Person::create($child);
        // Возвращаем созданную персону
        return response()->json($person, 201);
    }

    // Встречаем данные родственных персон
    public function relativeCreate(Request $request)
    {

        switch ($request->bio) {

            case 'm':
            case 'f':   // mother or father

                $this->createParent($request->person, $request->form);
                break;

            case 's':
            case 'd':   // son or daughter

                $this->createChild($request->form, $request->person);
                break;

            default:
                echo 'Неизвестный тип';
                break;
        }

        //var_dump($request->bio);
        //var_dump($request->form);
        //var_dump($request->person);

        //return response()->json($request, 201);

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
            'mother_id' => 'nullable|exists:persons,id',
            'father_id' => 'nullable|exists:persons,id',
            'gender' => 'required|boolean',
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
            'mother_id' => 'nullable|exists:persons,id',
            'father_id' => 'nullable|exists:persons,id',
            'gender' => 'required|boolean',
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
