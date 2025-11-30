<?php

namespace App\Http\Controllers;

use App\Models\Pattern;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $patterns = Pattern::where('status', 'active')
            ->with('user')
            ->latest()
            ->get();

        return view('home', compact('patterns'));
    }
}
