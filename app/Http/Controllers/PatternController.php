<?php

namespace App\Http\Controllers;

use App\Models\Pattern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PatternController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()->patterns();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $patterns = $query->latest()->get();
        return view('patterns.index', compact('patterns'));
    }

    public function search(Request $request)
    {
        $query = Pattern::where('status', 'active')->with(['user', 'reviews']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereJsonContains('tags', $search);
            });
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->has('seller')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('store_name', 'like', "%{$request->seller}%");
            });
        }

        $patterns = $query->latest()->paginate(20);
        return view('patterns.search', compact('patterns'));
    }

    public function create()
    {
        // Apenas vendedores podem criar receitas
        if (!Auth::user()->is_seller) {
            return redirect()->route('users.edit', Auth::user())
                ->with('error', 'Você precisa ser um vendedor para criar receitas. Configure sua conta como vendedor primeiro.');
        }

        return view('patterns.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->is_seller) {
            abort(403, 'Apenas vendedores podem criar receitas.');
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
        $validated['status'] = 'pending'; // Aguarda aprovação do admin

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

        Pattern::create($validated);

        return redirect()->route('patterns.index')
            ->with('success', 'Receita criada com sucesso! Aguardando aprovação do administrador.');
    }

    public function show(Pattern $pattern)
    {
        return view('patterns.show', compact('pattern'));
    }

    public function edit(Pattern $pattern)
    {
        if ($pattern->user_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para editar esta receita.');
        }

        return view('patterns.edit', compact('pattern'));
    }

    public function update(Request $request, Pattern $pattern)
    {
        if ($pattern->user_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para editar esta receita.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'tags' => 'nullable|string',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'attachment' => 'nullable|file|mimes:pdf|max:10240',
            'remove_photos' => 'nullable|array',
            'remove_attachment' => 'nullable|boolean',
        ]);

        // Processar tags
        if (!empty($validated['tags'])) {
            $tags = array_map('trim', explode(',', $validated['tags']));
            $validated['tags'] = $tags;
        } else {
            $validated['tags'] = null;
        }

        // Remover fotos selecionadas
        if (!empty($validated['remove_photos'])) {
            $currentPhotos = $pattern->photos ?? [];
            foreach ($validated['remove_photos'] as $photoToRemove) {
                if (in_array($photoToRemove, $currentPhotos)) {
                    Storage::disk('public')->delete($photoToRemove);
                    $currentPhotos = array_values(array_diff($currentPhotos, [$photoToRemove]));
                }
            }
            $validated['photos'] = $currentPhotos;
        } else {
            $validated['photos'] = $pattern->photos ?? [];
        }

        // Upload de novas fotos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('patterns/photos', 'public');
                $validated['photos'][] = $path;
            }
        }

        // Remover attachment se solicitado
        if (!empty($validated['remove_attachment'])) {
            if ($pattern->attachment) {
                Storage::disk('public')->delete($pattern->attachment);
                $validated['attachment'] = null;
            }
        } else {
            unset($validated['remove_attachment']);
        }

        // Upload de novo attachment
        if ($request->hasFile('attachment')) {
            if ($pattern->attachment) {
                Storage::disk('public')->delete($pattern->attachment);
            }
            $validated['attachment'] = $request->file('attachment')->store('patterns/pdfs', 'public');
        }

        unset($validated['remove_photos']);
        unset($validated['remove_attachment']);

        $pattern->update($validated);

        return redirect()->route('patterns.show', $pattern)
            ->with('success', 'Receita atualizada com sucesso!');
    }

    public function destroy(Pattern $pattern)
    {
        if ($pattern->user_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para excluir esta receita.');
        }

        // Remover fotos
        if ($pattern->photos) {
            foreach ($pattern->photos as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }

        // Remover PDF
        if ($pattern->attachment) {
            Storage::disk('public')->delete($pattern->attachment);
        }

        $pattern->delete();

        return redirect()->route('patterns.index')
            ->with('success', 'Receita excluída com sucesso!');
    }
}
