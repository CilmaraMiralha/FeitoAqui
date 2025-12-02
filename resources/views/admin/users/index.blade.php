@extends('layouts.app')

@section('title', 'Gerenciar Usuários')

@section('content')
<style>
    :root {
        --coffee: #644536;
        --terracotta: #B2675E;
        --ivory: #F2F5EA;
        --dust: #D6DBD2;
        --olive: #6F7C12;
    }
    body {
        background-color: #FAFAF5;
        color: var(--coffee);
        line-height: 1.7;
    }
</style>

<div class="min-h-screen py-12 px-6">
    <div class="max-w-7xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('admin.dashboard') }}" class="text-[var(--terracotta)] hover:text-[var(--coffee)] transition-colors font-medium inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Voltar ao Dashboard
            </a>
        </div>

        <div class="text-center mb-10">
            <h1 class="text-4xl font-serif font-bold text-[var(--coffee)] mb-3">Gerenciar Usuários</h1>
            <p class="text-slate-600">Visualize e gerencie todos os usuários da plataforma</p>
        </div>

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-5 py-4 rounded-xl mb-6 shadow-sm">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-xl mb-6 shadow-sm">
            {{ session('error') }}
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-[var(--terracotta)] to-[var(--coffee)] text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Nome</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Tipo</th>
                            <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($users as $user)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    @if($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-full object-cover ring-2 ring-slate-100">
                                    @else
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-[var(--terracotta)] to-[var(--coffee)] flex items-center justify-center text-white font-bold text-lg shadow-sm">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="font-semibold text-slate-900">{{ $user->name }} {{ $user->lastname }}</p>
                                        @if($user->store_name)
                                        <p class="text-sm text-slate-600 truncate">{{ $user->store_name }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-900">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col gap-2 items-center">
                                    @if($user->is_admin)
                                    <span class="text-xs bg-purple-50 text-purple-700 border border-purple-200 px-3 py-1.5 rounded-lg font-bold uppercase tracking-wider">Admin</span>
                                    @endif
                                    @if($user->is_seller)
                                    <span class="text-xs bg-blue-50 text-blue-700 border border-blue-200 px-3 py-1.5 rounded-lg font-bold uppercase tracking-wider">Vendedor</span>
                                    @else
                                    <span class="text-xs bg-slate-50 text-slate-700 border border-slate-200 px-3 py-1.5 rounded-lg font-bold uppercase tracking-wider">Cliente</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($user->is_banned)
                                <span class="px-4 py-2 bg-red-50 text-red-700 border border-red-200 rounded-xl text-xs font-bold uppercase tracking-wider">Banido</span>
                                @else
                                <span class="px-4 py-2 bg-green-50 text-green-700 border border-green-200 rounded-xl text-xs font-bold uppercase tracking-wider">Ativo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if(!$user->is_admin)
                                    @if($user->is_banned)
                                    <form action="{{ route('admin.users.unban', $user) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl font-bold text-xs uppercase tracking-wider hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                                            Desbanir
                                        </button>
                                    </form>
                                    @else
                                    <form action="{{ route('admin.users.ban', $user) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl font-bold text-xs uppercase tracking-wider hover:shadow-lg transform hover:-translate-y-0.5 transition-all"
                                            onclick="return confirm('Tem certeza que deseja banir este usuário?')">
                                            Banir
                                        </button>
                                    </form>
                                    @endif
                                @else
                                <span class="text-slate-400 text-sm">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
