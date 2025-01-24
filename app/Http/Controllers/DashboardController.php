<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        // Просто передаём переменную в шаблон
        return view('cabinet.dashboard', [
            'testVariable' => 'Это тестовая переменная!',
        ]);

    }
}
