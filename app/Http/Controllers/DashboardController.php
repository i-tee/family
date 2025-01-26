<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tree; // Подключите модель Tree

class DashboardController extends Controller
{
    public function index()
    {
        // Просто передаём переменную в шаблон
        return view('cabinet.dashboard', [
            'testVariable' => 'Это тестовая переменная!',
        ]);
    }

    public function chooseTree()
    {
        // Просто передаём переменную в шаблон
        return view('cabinet.choosetree');
    }

    public function showTree($id)
    {

        // Находим запись по ID
        $tree = Tree::find($id);

        // Если запись не найдена, возвращаем 404
        if (!$tree) {
            abort(404);
        }

        // Передаем данные в Blade-шаблон
        return view('cabinet.showtree', [
            'tree' => $tree,
            'persons' => $this->getPersonsTree($id)
        ]);

    }

    public function getPersonsTree($id){

        // Находим запись по ID
        $tree = Tree::find($id);

        // Получаем всех персон, связанных с этим деревом
        return $tree->persons;
        
    }
}
