<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\CPF;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function create(): View
    {
        return view("user.create");
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['string', 'required'],
            'last_name' => ['string', 'required'],
            'cpf' => ['unique:users', new CPF()],
            'email' => ['email', 'required', 'unique:users'],
            'birth_date' => ['date', 'required', 'before_or_equal:' . now()->subYears(18)->toDateString()],
            'password' => ['string', 'required', 'min:6'],
            'social_media' => ['nullable', 'string'],
            'profile_image' => ['image', 'required']
        ]);

        $validated['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        $user = User::create($validated);
        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/');
    }

    public function edit(int $id): View
    {
        abort_unless(Auth::id() === $id, 403);

        $user = User::find($id);

        return view("user.edit", ['user' => $user]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if (!$user) {
            abort(401);
        }

        $validated = $request->validate([
            'name' => ['string', 'required'],
            'last_name' => ['string', 'required'],
            'cpf' => ['required', new CPF(), Rule::unique('users', 'cpf')->ignore($user->id)],
            'email' => ['email', 'required', Rule::unique('users', 'email')->ignore($user->id)],
            'birth_date' => ['date', 'required', 'before_or_equal:' . now()->subYears(18)->toDateString()],
            'password' => ['nullable', 'string', 'min:6'],
            'social_media' => ['nullable', 'string'],
            'profile_image' => ['nullable', 'image']
        ]);

        if ($request->hasFile('profile_image')) {
            $validated['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        } else {
            unset($validated['profile_image']);
        }

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('user.profile', $user->id);
    }

    //perfil do usuário
    public function show(int $id): View
    {
        abort_unless(Auth::id() === $id, 403);

        $user = User::find($id);
        return view("user.profile", ['user' => $user]);
    }

    //limitar ao adm posteriormente
    public function index(): View
    {
        return view("user.index", ['users' => User::all()]);
    }
}
