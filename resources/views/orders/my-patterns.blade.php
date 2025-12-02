@extends('layouts.app')

@section('title', 'Minhas Receitas Compradas')

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

    .pattern-card {
        transition: all 0.3s ease;
    }

    .pattern-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px -8px rgba(0,0,0,0.15);
    }

    .pattern-img {
        transition: all 0.3s ease;
    }

    .pattern-card:hover .pattern-img {
        transform: scale(1.05);
    }
</style>

<div class="p-5">
    <div class="max-w-6xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('orders.index') }}" class="text-[var(--terracotta)] hover:text-[var(--coffee)] font-medium transition-colors">← Voltar para Meus Pedidos</a>
        </div>

        <h1 class="text-4xl font-serif font-bold text-[var(--coffee)] mb-8">Minhas Receitas Compradas</h1>

        @if($patterns->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($patterns as $pattern)
            <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 overflow-hidden pattern-card">
                <div class="overflow-hidden">
                    @if($pattern->photos && count($pattern->photos) > 0)
                    <img src="{{ asset('storage/' . $pattern->photos[0]) }}" alt="{{ $pattern->name }}" class="w-full h-48 object-cover pattern-img">
                    @else
                    <div class="w-full h-48 bg-slate-100 flex items-center justify-center">
                        <span class="text-slate-400 text-4xl">📄</span>
                    </div>
                    @endif
                </div>

                <div class="p-6">
                    <h3 class="text-xl font-serif font-bold text-slate-900 mb-2">{{ $pattern->name }}</h3>
                    <p class="text-slate-600 text-sm mb-4 line-clamp-2">{{ $pattern->description }}</p>

                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-xs bg-[var(--olive)] text-white px-3 py-1 rounded-full font-bold uppercase tracking-wider">{{ $pattern->user->store_name ?? $pattern->user->name }}</span>
                    </div>

                    @if($pattern->tags)
                    <div class="flex flex-wrap gap-2 mb-5">
                        @foreach($pattern->tags as $tag)
                        <span class="text-xs bg-slate-100 text-slate-600 px-3 py-1 rounded-full font-medium">{{ $tag }}</span>
                        @endforeach
                    </div>
                    @endif

                    <a href="{{ asset('storage/' . $pattern->attachment) }}" target="_blank"
                        class="block w-full text-center py-3 bg-gradient-to-r from-[var(--terracotta)] to-[var(--coffee)] text-white rounded-xl font-bold uppercase tracking-wider text-sm hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                        Baixar PDF
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-white p-10 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 text-center pattern-card">
            <p class="text-slate-600 mb-6 text-lg">Você ainda não comprou nenhuma receita</p>
            <a href="{{ route('patterns.search') }}" class="inline-block px-8 py-4 bg-gradient-to-r from-[var(--terracotta)] to-[var(--coffee)] text-white rounded-xl font-bold uppercase tracking-wider text-sm hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                Buscar Receitas
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
