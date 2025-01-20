<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tree;

class TreeController extends Controller
{

    public function index()
    {
        $trees = Tree::where('user_id', auth()->id())->get();

        return view('cabinet.family-tree', compact('trees'));
    }
    
}
