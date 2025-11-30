<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\NotGenericStoreName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Acesso negado. Apenas administradores podem visualizar a lista de usuários.');
        }

        $users = User::all();
        return view('users.index', ['users' => $users]);
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'birthDate' => 'required|date',
            'password' => 'required|string|min:8|confirmed',
            'socialMedia' => 'nullable|string|max:255',
            'is_seller' => 'nullable|boolean',
            'store_name' => ['nullable', 'string', 'max:255', 'required_if:is_seller,true', new NotGenericStoreName()],
            'cnpj' => 'nullable|string|max:18',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);

        Auth::login($user);

        return redirect()->route('users.edit', $user)->with('success', 'Usuário cadastrado com sucesso!');
    }

    public function edit(User $user): View
    {
        if (Auth::id() !== $user->id) {
            abort(403, 'Você não tem permissão para editar este perfil.');
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (Auth::id() !== $user->id) {
            abort(403, 'Você não tem permissão para editar este perfil.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:users,cpf,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'birthDate' => 'required|date',
            'socialMedia' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_seller' => 'nullable|boolean',
            'store_name' => ['nullable', 'string', 'max:255', 'required_if:is_seller,true', new NotGenericStoreName()],
            'cnpj' => 'nullable|string|max:18',
        ]);

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $path = $request->file('photo')->store('photos', 'public');
            $validated['photo'] = $path;
        }

        $user->update($validated);

        return redirect()->route('users.edit', $user)->with('success', 'Perfil atualizado com sucesso!');
    }
}
