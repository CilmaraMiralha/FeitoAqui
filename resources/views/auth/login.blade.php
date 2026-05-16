@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-[#4D2D52] via-[#4D2D52] to-[#DA98E0] p-6 md:p-10">
        <div class="mx-auto w-full max-w-md rounded-2xl bg-white/95 p-6 shadow-xl md:p-8">
            <h1 class="mb-1 text-2xl font-bold text-[#4D2D52]">Entrar</h1>
            <p class="mb-6 text-sm text-[#4D2D52]/80">Acesse sua conta para continuar.</p>

            <form action="{{ route('login.store') }}" method="POST" class="space-y-4">
                @csrf

                <x-form.input
                    name="email"
                    label="E-mail"
                    type="email"
                    :value="old('email')"
                    placeholder="Digite seu e-mail" />

                <x-form.input
                    name="password"
                    label="Senha"
                    type="password"
                    placeholder="Digite sua senha" />

                <label class="flex items-center gap-2 text-sm text-[#4D2D52]">
                    <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-[#DA98E0] text-[#5D8550] focus:ring-[#DA98E0]">
                    Lembrar de mim
                </label>

                <div class="pt-2">
                    <x-primary-btn variant="neutral" class="w-full">Entrar</x-primary-btn>
                </div>
            </form>
        </div>
    </div>
@endsection
