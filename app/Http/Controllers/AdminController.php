<?php

namespace App\Http\Controllers;

use App\Models\Pattern;
use App\Models\User;
use App\Models\Order;
use App\Models\Comment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user() || !auth()->user()->is_admin) {
                abort(403, 'Acesso não autorizado.');
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        $pendingPatterns = Pattern::where('status', 'pending')->count();
        $totalUsers = User::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'confirmed')->sum('total_amount');

        return view('admin.dashboard', compact('pendingPatterns', 'totalUsers', 'totalOrders', 'totalRevenue'));
    }

    public function pendingPatterns()
    {
        $patterns = Pattern::where('status', 'pending')->with('user')->latest()->paginate(20);
        return view('admin.patterns.pending', compact('patterns'));
    }

    public function approvePattern(Pattern $pattern)
    {
        $pattern->update(['status' => 'active']);
        return redirect()->back()->with('success', 'Receita aprovada com sucesso!');
    }

    public function rejectPattern(Request $request, Pattern $pattern)
    {
        $pattern->update(['status' => 'inactive']);
        return redirect()->back()->with('success', 'Receita rejeitada.');
    }

    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function banUser(User $user)
    {
        if ($user->is_admin) {
            return redirect()->back()->with('error', 'Não é possível banir um administrador.');
        }

        $user->update(['is_banned' => true]);
        return redirect()->back()->with('success', 'Usuário banido com sucesso.');
    }

    public function unbanUser(User $user)
    {
        $user->update(['is_banned' => false]);
        return redirect()->back()->with('success', 'Usuário desbloqueado com sucesso.');
    }

    public function deleteComment(Comment $comment)
    {
        $comment->delete();
        return redirect()->back()->with('success', 'Comentário deletado com sucesso.');
    }

    public function patterns()
    {
        $patterns = Pattern::with('user')->latest()->paginate(20);
        return view('admin.patterns.index', compact('patterns'));
    }

    public function orders()
    {
        $orders = Order::with('user')->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }
}
