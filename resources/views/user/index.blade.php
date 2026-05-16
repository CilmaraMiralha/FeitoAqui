@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-[#4D2D52] via-[#4D2D52] to-[#DA98E0] p-6 md:p-10">
        <div class="mx-auto w-full max-w-6xl rounded-2xl bg-white/95 p-6 shadow-xl md:p-8">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h1 class="text-2xl font-bold text-[#4D2D52]">Usuários</h1>
                <a href="{{ route('user.create') }}" class="inline-flex items-center justify-center rounded-xl bg-[#AC6C45] px-4 py-2 text-sm font-semibold text-white transition-colors duration-200 hover:bg-[#925A39]">Novo cadastro</a>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($users as $user)
                    @php
                        $profileImageExists = $user->profile_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->profile_image);
                    @endphp
                    <article class="rounded-xl border border-[#DA98E0] bg-white p-4 shadow-sm">
                        <div class="mb-3 flex items-center gap-3">
                            @if ($profileImageExists)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($user->profile_image) }}" alt="Foto de {{ $user->name }}" class="h-14 w-14 rounded-full border-2 border-[#DA98E0] object-cover">
                            @else
                                <div class="flex h-14 w-14 items-center justify-center rounded-full border-2 border-[#DA98E0] bg-[#DA98E0]/25 text-xs font-semibold text-[#4D2D52]">
                                    Sem foto
                                </div>
                            @endif
                            <div>
                                <p class="font-semibold text-[#4D2D52]">{{ $user->name }} {{ $user->last_name }}</p>
                                <p class="text-xs text-[#4D2D52]/70">ID: {{ $user->id }}</p>
                            </div>
                        </div>

                        <div class="space-y-1 text-sm text-[#4D2D52]">
                            <p><span class="font-semibold">E-mail:</span> {{ $user->email }}</p>
                            <p><span class="font-semibold">CPF:</span> {{ $user->cpf }}</p>
                            <p><span class="font-semibold">Nascimento:</span> {{ $user->birth_date }}</p>
                            <p><span class="font-semibold">Rede social:</span> {{ $user->social_media ?? 'Não informado' }}</p>
                        </div>

                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('user.profile', $user->id) }}" class="inline-flex items-center justify-center rounded-lg bg-[#5D8550] px-3 py-2 text-xs font-semibold text-white transition-colors duration-200 hover:bg-[#4f7344]">Ver perfil</a>
                            <a href="{{ route('user.edit', $user->id) }}" class="inline-flex items-center justify-center rounded-lg bg-[#AC6C45] px-3 py-2 text-xs font-semibold text-white transition-colors duration-200 hover:bg-[#925A39]">Editar</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
@endsection
