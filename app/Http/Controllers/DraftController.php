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

    public function publish(Draft $draft)
    {
        if ($draft->user_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para publicar este rascunho.');
        }

        if (!Auth::user()->is_seller) {
            return redirect()->back()->with('error', 'Apenas vendedores podem publicar receitas.');
        }

        return view('drafts.publish', compact('draft'));
    }

    public function storePattern(Request $request, Draft $draft)
    {
        if ($draft->user_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para publicar este rascunho.');
        }

        if (!Auth::user()->is_seller) {
            abort(403, 'Apenas vendedores podem publicar receitas.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'tags' => 'nullable|string',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'attachment' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        // Processar tags
        if (!empty($validated['tags'])) {
            $tags = array_map('trim', explode(',', $validated['tags']));
            $validated['tags'] = $tags;
        } else {
            $validated['tags'] = null;
        }

        // Upload de fotos
        if ($request->hasFile('photos')) {
            $photos = [];
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('patterns/photos', 'public');
                $photos[] = $path;
            }
            $validated['photos'] = $photos;
        }

        // Upload do arquivo PDF
        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('patterns/pdfs', 'public');
        }

        \App\Models\Pattern::create($validated);
        $draft->delete();

        return redirect()->route('patterns.index')
            ->with('success', 'Receita criada com sucesso! Aguardando aprovação do administrador.');
    }
}
