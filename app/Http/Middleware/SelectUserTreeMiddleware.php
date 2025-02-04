<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Tree;

class SelectUserTreeMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Получаем ID текущего авторизованного пользователя
        $userId = auth()->id();

        if ($userId && $request->route('id')) { // Проверяем, есть ли ID дерева в запросе
            // Находим все деревья пользователя
            $userTrees = Tree::where('user_id', $userId)->get();

            // Сбрасываем флаг selected для всех деревьев пользователя
            $userTrees->each(function ($tree) {
                $tree->selected = false;
                $tree->save();
            });

            // Находим текущее дерево по ID
            $tree = Tree::find($request->route('id'));

            if ($tree && $tree->user_id === $userId) { // Проверяем, принадлежит ли дерево пользователю
                // Устанавливаем selected = true для текущего дерева
                $tree->selected = true;
                $tree->save();
            }
        }

        return $next($request);
    }
}