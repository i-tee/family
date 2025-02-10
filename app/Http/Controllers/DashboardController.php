<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tree; // Подключите модель Tree
use App\Models\CanvasSetting; // Подключите модель CanvasSetting

use App\Services\TreeService;

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

    public function centralPerson($id)
    {
        $tree = Tree::find($id);
        return $tree->cp_id;
    }

    public function dd($id)
    {
        // Получаем всех персон из дерева
        $persons = $this->getPersonsTree($id);

        // Получаем centralId
        $centralId = $this->centralPerson($id);

        // Создаем экземпляр сервиса и рассчитываем координаты
        $treeCoordinateService = new TreeService();
        $personsWithCoordinates = $treeCoordinateService->calculateCoordinates($persons->toArray(), $centralId);

        // Передаем данные в Blade-шаблон
        return view('dd', [
            'persons' => $personsWithCoordinates,
            'cp_id' => $centralId,
        ]);
    }
}
