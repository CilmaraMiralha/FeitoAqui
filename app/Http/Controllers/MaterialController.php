<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Variation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Auth::user()->materials()->with('variations')->get();
        return view('materials.index', compact('materials'));
    }

    public function create()
    {
        return view('materials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'composition' => 'nullable|string',
            'fixed_weight' => 'nullable|numeric|min:0',
        ]);

        $validated['user_id'] = Auth::id();

        Material::create($validated);

        return redirect()->route('materials.index')->with('success', 'Material cadastrado com sucesso!');
    }

    public function show(Material $material)
    {
        if ($material->user_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para visualizar este material.');
        }

        $material->load('variations');
        return view('materials.show', compact('material'));
    }

    public function edit(Material $material)
    {
        if ($material->user_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para editar este material.');
        }

        return view('materials.edit', compact('material'));
    }

    public function update(Request $request, Material $material)
    {
        if ($material->user_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para editar este material.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'composition' => 'nullable|string',
            'fixed_weight' => 'nullable|numeric|min:0',
        ]);

        $material->update($validated);

        return redirect()->route('materials.show', $material)->with('success', 'Material atualizado com sucesso!');
    }

    public function destroy(Material $material)
    {
        if ($material->user_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para excluir este material.');
        }

        $material->delete();

        return redirect()->route('materials.index')->with('success', 'Material excluído com sucesso!');
    }

    public function storeVariation(Request $request, Material $material)
    {
        if ($material->user_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para adicionar variações a este material.');
        }

        $validated = $request->validate([
            'color' => 'required|string|max:255',
            'color_code' => 'nullable|string|max:255',
            'weight' => 'required|numeric|min:0',
        ]);

        $validated['material_id'] = $material->id;

        Variation::create($validated);

        return redirect()->route('materials.show', $material)->with('success', 'Variação adicionada com sucesso!');
    }

    public function updateVariation(Request $request, Material $material, Variation $variation)
    {
        if ($material->user_id !== Auth::id() || $variation->material_id !== $material->id) {
            abort(403, 'Você não tem permissão para editar esta variação.');
        }

        $validated = $request->validate([
            'color' => 'required|string|max:255',
            'color_code' => 'nullable|string|max:255',
            'weight' => 'required|numeric|min:0',
        ]);

        $variation->update($validated);

        return redirect()->route('materials.show', $material)->with('success', 'Variação atualizada com sucesso!');
    }

    public function destroyVariation(Material $material, Variation $variation)
    {
        if ($material->user_id !== Auth::id() || $variation->material_id !== $material->id) {
            abort(403, 'Você não tem permissão para excluir esta variação.');
        }

        $variation->delete();

        return redirect()->route('materials.show', $material)->with('success', 'Variação excluída com sucesso!');
    }

    public function adjustVariationWeight(Request $request, Material $material)
    {
        if ($material->user_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para ajustar esta variação.');
        }

        $validated = $request->validate([
            'variation_id' => 'required|exists:variations,id',
            'weight_adjustment' => 'required|numeric|min:0.01',
            'action' => 'required|in:add,remove',
        ]);

        $variation = Variation::findOrFail($validated['variation_id']);

        if ($variation->material_id !== $material->id) {
            abort(403, 'Esta variação não pertence a este material.');
        }

        if ($validated['action'] === 'add') {
            $variation->weight += $validated['weight_adjustment'];
            $message = 'Peso adicionado com sucesso!';
        } else {
            $newWeight = $variation->weight - $validated['weight_adjustment'];
            if ($newWeight < 0) {
                return redirect()->route('materials.show', $material)
                    ->with('error', 'Não é possível remover mais peso do que o disponível.');
            }
            $variation->weight = $newWeight;
            $message = 'Peso removido com sucesso!';
        }

        $variation->save();

        return redirect()->route('materials.show', $material)->with('success', $message);
    }
}
