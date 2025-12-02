<?php

namespace App\Http\Controllers;

use App\Models\Pattern;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, Pattern $pattern)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$pattern->id])) {
            $cart[$pattern->id]['quantity']++;
        } else {
            $cart[$pattern->id] = [
                'name' => $pattern->name,
                'price' => $pattern->price,
                'quantity' => 1,
                'photo' => $pattern->photos[0] ?? null,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Receita adicionada ao carrinho!');
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Carrinho atualizado!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Item removido do carrinho!');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Carrinho limpo!');
    }
}
