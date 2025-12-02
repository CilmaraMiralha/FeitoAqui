<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Pattern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->with(['orderItems.pattern', 'payment'])->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['orderItems.pattern', 'payment']);
        return view('orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Carrinho está vazio!');
        }

        try {
            DB::beginTransaction();

            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => $total,
                'status' => 'awaiting_payment',
            ]);

            foreach ($cart as $patternId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'pattern_id' => $patternId,
                    'price_at_purchase' => $item['price'],
                ]);
            }

            session()->forget('cart');

            DB::commit();

            return redirect()->route('orders.show', $order)->with('success', 'Pedido criado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'Erro ao criar pedido: ' . $e->getMessage());
        }
    }

    public function myPatterns()
    {
        $orders = auth()->user()->orders()
            ->where('status', 'confirmed')
            ->with(['orderItems.pattern'])
            ->get();

        $patterns = $orders->flatMap(function ($order) {
            return $order->orderItems->pluck('pattern');
        })->unique('id');

        return view('orders.my-patterns', compact('patterns'));
    }
}
