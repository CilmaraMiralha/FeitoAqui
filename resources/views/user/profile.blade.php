@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-[#4D2D52] via-[#4D2D52] to-[#DA98E0] p-6 md:p-10">
        @php
            $profileImageExists = $user->profile_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->profile_image);
        @endphp

        <div class="mx-auto w-full max-w-3xl rounded-2xl bg-white/95 p-6 shadow-xl md:p-8">
            <h1 class="mb-6 text-2xl font-bold text-[#4D2D52]">Perfil do Usuário</h1>

            <div class="mb-6 flex items-center gap-4">
                @if ($profileImageExists)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($user->profile_image) }}" alt="Foto de {{ $user->name }}" class="h-28 w-28 rounded-full border-4 border-[#DA98E0] object-cover">
                @else
                    <div class="flex h-28 w-28 items-center justify-center rounded-full border-4 border-[#DA98E0] bg-[#DA98E0]/25 text-sm font-semibold text-[#4D2D52]">
                        Sem foto
                    </div>
                @endif
                <div>
                    <p class="text-lg font-semibold text-[#4D2D52]">{{ $user->name }} {{ $user->last_name }}</p>
                    <p class="text-sm text-[#4D2D52]/70">ID: {{ $user->id }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-3 rounded-xl border border-[#DA98E0] bg-[#DA98E0]/15 p-4 text-[#4D2D52] md:grid-cols-2">
                <p><span class="font-semibold">E-mail:</span> {{ $user->email }}</p>
                <p><span class="font-semibold">CPF:</span> {{ $user->cpf }}</p>
                <p><span class="font-semibold">Idade:</span> {{ $user->age }} anos</p>
                <p><span class="font-semibold">Data de nascimento:</span> {{ $user->birth_date }}</p>
                <p><span class="font-semibold">Rede social:</span> {{ $user->social_media ?? 'Não informado' }}</p>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('user.index') }}" class="inline-flex items-center justify-center rounded-xl bg-[#AC6C45] px-4 py-2 text-sm font-semibold text-white transition-colors duration-200 hover:bg-[#925A39]">Voltar para listagem</a>
                <a href="{{ route('user.edit', $user->id) }}" class="inline-flex items-center justify-center rounded-xl bg-[#5D8550] px-4 py-2 text-sm font-semibold text-white transition-colors duration-200 hover:bg-[#4f7344]">Editar perfil</a>
                <button type="button" class="inline-flex items-center justify-center rounded-xl bg-[#B90053] px-4 py-2 text-sm font-semibold text-white opacity-70 cursor-not-allowed" disabled>Excluir (em breve)</button>
            </div>
        </div>
    </div>
@endsection
