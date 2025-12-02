<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Pattern;
use App\Models\Order;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Pattern $pattern)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:0|max:5',
            'description' => 'nullable|string|max:1000',
        ]);

        $order = Order::findOrFail($validated['order_id']);

        if ($order->user_id !== auth()->id()) {
            abort(403, 'Você não tem permissão para avaliar este pedido.');
        }

        if ($order->status !== 'confirmed') {
            return redirect()->back()->with('error', 'Você só pode avaliar pedidos confirmados.');
        }

        $hasPattern = $order->orderItems()->where('pattern_id', $pattern->id)->exists();
        if (!$hasPattern) {
            return redirect()->back()->with('error', 'Você não comprou esta receita.');
        }

        $existingReview = Review::where('user_id', auth()->id())
            ->where('pattern_id', $pattern->id)
            ->where('order_id', $order->id)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Você já avaliou esta receita.');
        }

        Review::create([
            'user_id' => auth()->id(),
            'order_id' => $order->id,
            'pattern_id' => $pattern->id,
            'rating' => $validated['rating'],
            'description' => $validated['description'],
        ]);

        return redirect()->back()->with('success', 'Avaliação adicionada com sucesso!');
    }

    public function update(Request $request, Review $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:0|max:5',
            'description' => 'nullable|string|max:1000',
        ]);

        $review->update($validated);

        return redirect()->back()->with('success', 'Avaliação atualizada com sucesso!');
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403);
        }

        $review->delete();

        return redirect()->back()->with('success', 'Avaliação removida com sucesso!');
    }
}
