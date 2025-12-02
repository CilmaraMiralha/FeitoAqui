@extends('layouts.app')

@section('title', 'Receitas Pendentes')

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
            <h1 class="text-4xl font-serif font-bold text-[var(--coffee)] mb-3">Receitas Pendentes de Aprovação</h1>
            <p class="text-slate-600">Revise e aprove receitas enviadas pelos vendedores</p>
        </div>

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-5 py-4 rounded-xl mb-6 shadow-sm">
            {{ session('success') }}
        </div>
        @endif

        @if($patterns->count() > 0)
        <div class="space-y-6">
            @foreach($patterns as $pattern)
            <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 p-8 hover:shadow-xl transition-all duration-300">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Imagem -->
                    <div>
                        @if($pattern->photos && count($pattern->photos) > 0)
                        <img src="{{ asset('storage/' . $pattern->photos[0]) }}" alt="{{ $pattern->name }}" class="w-full h-56 object-cover rounded-xl shadow-sm">
                        @else
                        <div class="w-full h-56 bg-slate-100 rounded-xl flex items-center justify-center border-2 border-dashed border-slate-300">
                            <span class="text-slate-400 text-5xl">📄</span>
                        </div>
                        @endif
                    </div>

                    <!-- Informações -->
                    <div class="md:col-span-2">
                        <h3 class="text-2xl font-serif font-bold text-[var(--coffee)] mb-3">{{ $pattern->name }}</h3>
                        <p class="text-slate-600 mb-5 leading-relaxed">{{ $pattern->description }}</p>

                        <div class="grid grid-cols-2 gap-5 mb-5">
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Vendedor</p>
                                <p class="font-semibold text-slate-900">{{ $pattern->user->store_name ?? $pattern->user->name }}</p>
                            </div>
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Preço</p>
                                <p class="font-bold text-[var(--terracotta)] text-lg">R$ {{ number_format($pattern->price, 2, ',', '.') }}</p>
                            </div>
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Data de Envio</p>
                                <p class="font-semibold text-slate-900">{{ $pattern->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Idioma</p>
                                <p class="font-semibold text-slate-900">{{ $pattern->language }}</p>
                            </div>
                        </div>

                        @if($pattern->tags)
                        <div class="mb-5">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tags</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($pattern->tags as $tag)
                                <span class="text-xs bg-[var(--dust)] text-[var(--coffee)] px-3 py-1.5 rounded-lg font-medium">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($pattern->attachment)
                        <div class="mb-6">
                            <a href="{{ asset('storage/' . $pattern->attachment) }}" target="_blank"
                               class="inline-flex items-center text-[var(--terracotta)] hover:text-[var(--coffee)] transition-colors font-semibold">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Visualizar PDF
                            </a>
                        </div>
                        @endif

                        <!-- Ações -->
                        <div class="flex gap-4 pt-4 border-t border-slate-100">
                            <form action="{{ route('admin.patterns.approve', $pattern) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="px-8 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl font-bold uppercase tracking-wider text-sm hover:shadow-lg transform hover:-translate-y-0.5 transition-all"
                                    onclick="return confirm('Tem certeza que deseja aprovar esta receita?')">
                                    Aprovar
                                </button>
                            </form>

                            <form action="{{ route('admin.patterns.reject', $pattern) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="px-8 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl font-bold uppercase tracking-wider text-sm hover:shadow-lg transform hover:-translate-y-0.5 transition-all"
                                    onclick="return confirm('Tem certeza que deseja rejeitar esta receita?')">
                                    Rejeitar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $patterns->links() }}
        </div>
        @else
        <div class="bg-white p-12 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 text-center">
            <div class="text-6xl mb-4">✅</div>
            <h3 class="text-xl font-serif font-bold text-[var(--coffee)] mb-2">Tudo em dia!</h3>
            <p class="text-slate-600">Nenhuma receita pendente de aprovação no momento</p>
        </div>
        @endif
    </div>
</div>
@endsection
