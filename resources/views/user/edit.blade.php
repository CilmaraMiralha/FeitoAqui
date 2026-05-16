@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-[#4D2D52] via-[#4D2D52] to-[#DA98E0] p-6 md:p-10">
        <div class="mx-auto w-full max-w-2xl rounded-2xl bg-white/95 p-6 shadow-xl md:p-8">
            <h1 class="mb-1 text-2xl font-bold text-[#4D2D52]">Editar Usuário</h1>
            <p class="mb-6 text-sm text-[#4D2D52]/80">Atualize os dados da conta.</p>

            <x-form.form action="{{ route('user.update') }}" method="POST">
                @csrf

                <x-form.input name="name" label="Nome" value="{{ $user['name'] }}" placeholder="Digite seu nome" />
                <x-form.input name="last_name" label="Sobrenome" value="{{ $user['last_name'] }}" placeholder="Digite seu sobrenome" />
                <x-form.input name="cpf" label="CPF" value="{{ $user['cpf'] }}" placeholder="Digite o seu CPF" />
                <x-form.input name="email" label="E-mail" value="{{ $user['email'] }}" placeholder="Digite o seu e-mail" />
                <x-form.input name="birth_date" label="Data de nascimento" type="date" value="{{ $user['birth_date'] }}" />
                <x-form.input name="password" label="Senha" type="password" placeholder="Digite a sua senha" />
                <x-form.input name="social_media" label="Rede social" value="{{ $user['social_media'] }}" placeholder="Digite o nome do seu perfil no Instagram" />
                <x-form.input name="profile_image" label="Foto de perfil" type="file" />

                <div class="flex flex-wrap gap-3 pt-2">
                    <x-primary-btn variant="confirm">Salvar alterações</x-primary-btn>
                    <a href="{{ route('user.index') }}" class="inline-flex items-center justify-center rounded-xl bg-[#B90053] px-4 py-2 text-sm font-semibold text-white transition-colors duration-200 hover:bg-[#9b0047]">Cancelar</a>
                </div>
            </x-form.form>
        </div>
    </div>
@endsection
