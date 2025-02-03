<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tree; // Подключите модель Tree
use App\Models\CanvasSetting; // Подключите модель Tree

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
        // Получаем ID текущего авторизованного пользователя
        $userId = auth()->id();
    
        // Находим текущее дерево по ID
        $tree = Tree::findOrFail($id);
    
        // Если дерево не принадлежит пользователю, возвращаем 403
        if ($tree->user_id !== $userId) {
            abort(403, 'Вы не имеете доступа к этому дереву.');
        }
    
        $canvasSetting = CanvasSetting::instance();
    
        // Передаем данные в Blade-шаблон
        return view('cabinet.showtree', [
            'canvasSetting' => $canvasSetting,
            'tree_id' => $tree->id,
            'userId' => $userId,
        ]);
    }

    public function getPersonsTree($id){

        // Находим запись по ID
        $tree = Tree::find($id);

        // Получаем всех персон, связанных с этим деревом
        return $tree->persons;
        
    }
}
