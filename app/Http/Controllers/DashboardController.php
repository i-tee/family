<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tree; // Подключите модель Tree
use App\Models\CanvasSetting; // Подключите модель CanvasSetting

class DashboardController extends Controller
{
    public function index()
    {
        return view('cabinet.dashboard', [
            'testVariable' => 'Это тестовая переменная!',
        ]);
    }

    public function chooseTree()
    {
        return view('cabinet.choosetree');
    }

    public function showTree($id)
    {
        $userId = auth()->id();
        $tree = Tree::findOrFail($id);

        if ($tree->user_id !== $userId) {
            abort(403, 'Вы не имеете доступа к этому дереву.');
        }

        $canvasSetting = CanvasSetting::instance();

        return view('cabinet.showtree', [
            'canvasSetting' => $canvasSetting,
            'tree_id' => $tree->id,
            'userId' => $userId,
        ]);
    }

    public function getPersonsTree($id)
    {
        $tree = Tree::find($id);
        return $tree->persons;
    }

    public function dd($id)
    {
        $persons = $this->getPersonsTree($id);
        $centralId = $this->centralPerson($id);
        $this->assignGenerations($persons, $centralId);

        return view('dd', [
            'persons' => $persons->toArray(),
            'cp_id' => $centralId
        ]);
    }

    public function centralPerson($id)
    {
        $tree = Tree::find($id);
        return $tree->cp_id;
    }

    public function getNextXForY(&$generationMap, $y)
    {
        if (!isset($generationMap[$y])) {
            $generationMap[$y] = 0; // Первый представитель в этом поколении
        } else {
            $generationMap[$y]++; // Увеличиваем счетчик для этого поколения
        }
        return $generationMap[$y];
    }

    public function assignGenerations(&$people, $centralId, $y = 0, &$generationMap = [])
    {
        $peopleById = [];
        foreach ($people as &$person) {
            $peopleById[$person['id']] = &$person;
        }

        if (isset($peopleById[$centralId])) {
            $peopleById[$centralId]['y'] = 0;
            $peopleById[$centralId]['x'] = 0;

            // Обработка родителей
            $this->processParents($peopleById, $peopleById[$centralId], $generationMap);

            // Обработка детей
            $this->processChildren($peopleById, $peopleById[$centralId], $generationMap);
        }
    }

    protected function processParents(&$peopleById, &$person, &$generationMap)
    {
        if ($person['mother_id'] !== null && isset($peopleById[$person['mother_id']])) {
            $mother = &$peopleById[$person['mother_id']];
            if (!isset($mother['y'])) {
                $mother['y'] = $person['y'] + 1;
                $mother['x'] = $this->getNextXForY($generationMap, $mother['y']);
                $this->processParents($peopleById, $mother, $generationMap);
            }
        }

        if ($person['father_id'] !== null && isset($peopleById[$person['father_id']])) {
            $father = &$peopleById[$person['father_id']];
            if (!isset($father['y'])) {
                $father['y'] = $person['y'] + 1;
                $father['x'] = $this->getNextXForY($generationMap, $father['y']);
                $this->processParents($peopleById, $father, $generationMap);
            }
        }
    }

    protected function processChildren(&$peopleById, &$person, &$generationMap)
    {
        foreach ($peopleById as &$child) {
            if (($child['mother_id'] == $person['id'] || $child['father_id'] == $person['id']) && !isset($child['y'])) {
                $child['y'] = $person['y'] - 1;
                $child['x'] = $this->getNextXForY($generationMap, $child['y']);
                $this->processChildren($peopleById, $child, $generationMap);
            }
        }
    }
}