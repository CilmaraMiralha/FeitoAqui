@extends('layouts.app')

@section('title', 'Painel Administrativo')

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
        <div class="text-center mb-12">
            <h1 class="text-4xl font-serif font-bold text-[var(--coffee)] mb-3">Painel Administrativo</h1>
            <p class="text-slate-600">Gerencie sua plataforma de forma eficiente</p>
        </div>

        <!-- Estatísticas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-6 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <h3 class="text-slate-600 text-xs font-bold uppercase tracking-wider mb-3">Receitas Pendentes</h3>
                <p class="text-4xl font-bold text-[var(--olive)]">{{ $pendingPatterns }}</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <h3 class="text-slate-600 text-xs font-bold uppercase tracking-wider mb-3">Total de Usuários</h3>
                <p class="text-4xl font-bold text-[var(--coffee)]">{{ $totalUsers }}</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <h3 class="text-slate-600 text-xs font-bold uppercase tracking-wider mb-3">Total de Pedidos</h3>
                <p class="text-4xl font-bold text-[var(--terracotta)]">{{ $totalOrders }}</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <h3 class="text-slate-600 text-xs font-bold uppercase tracking-wider mb-3">Receita Total</h3>
                <p class="text-4xl font-bold text-[var(--terracotta)]">R$ {{ number_format($totalRevenue, 2, ',', '.') }}</p>
            </div>
        </div>

        <!-- Menu Rápido -->
        <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 p-8">
            <h2 class="text-2xl font-serif font-bold text-[var(--coffee)] mb-6">Ações Rápidas</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                <a href="{{ route('admin.patterns.pending') }}" class="p-6 border-2 border-[var(--olive)]/20 bg-[var(--olive)]/5 rounded-xl hover:bg-[var(--olive)]/10 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <h3 class="font-bold text-lg mb-2 text-[var(--coffee)]">Receitas Pendentes</h3>
                    <p class="text-sm text-slate-600">Aprovar ou rejeitar receitas</p>
                </a>

                <a href="{{ route('admin.users.index') }}" class="p-6 border-2 border-[var(--coffee)]/20 bg-[var(--coffee)]/5 rounded-xl hover:bg-[var(--coffee)]/10 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <h3 class="font-bold text-lg mb-2 text-[var(--coffee)]">Gerenciar Usuários</h3>
                    <p class="text-sm text-slate-600">Visualizar e banir usuários</p>
                </a>

                <a href="{{ route('admin.patterns.index') }}" class="p-6 border-2 border-[var(--terracotta)]/20 bg-[var(--terracotta)]/5 rounded-xl hover:bg-[var(--terracotta)]/10 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <h3 class="font-bold text-lg mb-2 text-[var(--coffee)]">Todas as Receitas</h3>
                    <p class="text-sm text-slate-600">Visualizar todas as receitas</p>
                </a>

                <a href="{{ route('admin.orders.index') }}" class="p-6 border-2 border-[var(--terracotta)]/20 bg-[var(--terracotta)]/5 rounded-xl hover:bg-[var(--terracotta)]/10 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <h3 class="font-bold text-lg mb-2 text-[var(--coffee)]">Todos os Pedidos</h3>
                    <p class="text-sm text-slate-600">Visualizar todos os pedidos</p>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
