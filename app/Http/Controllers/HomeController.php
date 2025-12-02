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

        // Estatísticas para a home
        $stats = [
            'total_patterns' => Pattern::where('status', 'active')->count(),
            'total_sellers' => \App\Models\User::where('is_seller', true)->count(),
            'total_sales' => \App\Models\Order::where('status', 'confirmed')->count(),
        ];

        return view('home', compact('patterns', 'stats'));
    }
}
