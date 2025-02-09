<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MainTreeLinkMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Логика построения ссылки
        $userId = auth()->id(); // Получаем ID пользователя

        if ($userId) {
            // Найти дерево, принадлежащее пользователю, с selected = true
            $user = auth()->user();
            $tree = $user->trees()->where('selected', true)->first();

            if ($tree) {
                // Если дерево найдено, формируем данные
                $data = [
                    'mainTreeLink' => route('dashboard.tree.show', ['tree_id' => $tree->id]),
                    'mainTreeName' => $tree->name,
                    'mainTreeId'   => $tree->id,
                    'mainTree'   => $tree->only($tree->getFillable()),
                ];
            } else {
                // Если дерево не найдено, используем альтернативные значения
                $data = [
                    'mainTreeLink' => route('dashboard'),
                    'mainTreeName' => null,
                    'mainTreeId'   => null,
                    'mainTree'   => null,
                ];
            }
        } else {
            // Если пользователь не авторизован, используем альтернативные значения
            $data = [
                'mainTreeLink' => route('dashboard'),
                'mainTreeName' => null,
                'mainTreeId'   => null,
                'mainTree'   => null,
            ];
        }

        // Передаем данные в шаблон
        view()->share('mainTreeData', $data);

        return $next($request);
    }
}
