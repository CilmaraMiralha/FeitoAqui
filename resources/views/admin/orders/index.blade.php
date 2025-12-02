@extends('layouts.app')

@section('title', 'Todos os Pedidos')

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
            <h1 class="text-4xl font-serif font-bold text-[var(--coffee)] mb-3">Todos os Pedidos</h1>
            <p class="text-slate-600">Visualize e acompanhe todos os pedidos realizados na plataforma</p>
        </div>

        <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-[var(--terracotta)] to-[var(--coffee)] text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Total</th>
                            <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Data</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($orders as $order)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-bold text-[var(--coffee)] bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-200">
                                    #{{ $order->id }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-900">{{ $order->user->name }} {{ $order->user->lastname }}</p>
                                <p class="text-sm text-slate-600">{{ $order->user->email }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="font-bold text-lg text-[var(--terracotta)]">R$ {{ number_format($order->total_amount, 2, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($order->status === 'confirmed')
                                <span class="px-4 py-2 bg-green-50 text-green-700 border border-green-200 rounded-xl text-xs font-bold uppercase tracking-wider">Confirmado</span>
                                @elseif($order->status === 'awaiting_payment')
                                <span class="px-4 py-2 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-xl text-xs font-bold uppercase tracking-wider">Aguardando</span>
                                @else
                                <span class="px-4 py-2 bg-red-50 text-red-700 border border-red-200 rounded-xl text-xs font-bold uppercase tracking-wider">Não Confirmado</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <p class="text-sm font-semibold text-slate-900">{{ $order->created_at->format('d/m/Y') }}</p>
                                <p class="text-xs text-slate-600">{{ $order->created_at->format('H:i') }}</p>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
