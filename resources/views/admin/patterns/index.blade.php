@extends('layouts.app')

@section('title', 'Todas as Receitas')

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
            <h1 class="text-4xl font-serif font-bold text-[var(--coffee)] mb-3">Todas as Receitas</h1>
            <p class="text-slate-600">Visualize e gerencie todas as receitas da plataforma</p>
        </div>

        <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-[var(--terracotta)] to-[var(--coffee)] text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Receita</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Vendedor</th>
                            <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Preço</th>
                            <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Data</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($patterns as $pattern)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    @if($pattern->photos && count($pattern->photos) > 0)
                                    <img src="{{ asset('storage/' . $pattern->photos[0]) }}" alt="{{ $pattern->name }}" class="w-16 h-16 object-cover rounded-xl shadow-sm">
                                    @else
                                    <div class="w-16 h-16 bg-slate-100 rounded-xl flex items-center justify-center border border-slate-200">
                                        <span class="text-slate-400 text-2xl">📄</span>
                                    </div>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="font-semibold text-slate-900 truncate">{{ $pattern->name }}</p>
                                        <p class="text-sm text-slate-600 truncate">{{ $pattern->description }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-900">
                                {{ $pattern->user->store_name ?? $pattern->user->name }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="font-bold text-[var(--terracotta)]">R$ {{ number_format($pattern->price, 2, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($pattern->status === 'active')
                                <span class="px-3 py-1.5 bg-green-50 text-green-700 border border-green-200 rounded-xl text-xs font-bold uppercase tracking-wider">Ativa</span>
                                @elseif($pattern->status === 'pending')
                                <span class="px-3 py-1.5 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-xl text-xs font-bold uppercase tracking-wider">Pendente</span>
                                @else
                                <span class="px-3 py-1.5 bg-red-50 text-red-700 border border-red-200 rounded-xl text-xs font-bold uppercase tracking-wider">Inativa</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-slate-600">
                                {{ $pattern->created_at->format('d/m/Y') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8">
            {{ $patterns->links() }}
        </div>
    </div>
</div>
@endsection
