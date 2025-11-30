<?php

namespace App\Http\Controllers;

use App\Models\Draft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DraftController extends Controller
{
    public function index()
    {
        $drafts = Auth::user()->drafts()->orderBy('updated_at', 'desc')->get();
        return view('drafts.index', compact('drafts'));
    }

    public function create()
    {
        return view('drafts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        Draft::create($validated);

        return redirect()->route('drafts.index')->with('success', 'Rascunho criado com sucesso!');
    }

    public function show(Draft $draft)
    {
        if ($draft->user_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para visualizar este rascunho.');
        }

        return view('drafts.show', compact('draft'));
    }

    public function edit(Draft $draft)
    {
        if ($draft->user_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para editar este rascunho.');
        }

        return view('drafts.edit', compact('draft'));
    }

    public function update(Request $request, Draft $draft)
    {
        if ($draft->user_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para editar este rascunho.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $draft->update($validated);

        return redirect()->route('drafts.show', $draft)->with('success', 'Rascunho atualizado com sucesso!');
    }

    public function destroy(Draft $draft)
    {
        if ($draft->user_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para excluir este rascunho.');
        }

        $draft->delete();

        return redirect()->route('drafts.index')->with('success', 'Rascunho excluído com sucesso!');
    }
}
