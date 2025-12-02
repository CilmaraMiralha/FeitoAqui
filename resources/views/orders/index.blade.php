@extends('layouts.app')

@section('title', 'Meus Pedidos')

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

    .order-card {
        transition: all 0.3s ease;
    }

    .order-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px -5px rgba(0,0,0,0.1);
    }
</style>

<div class="p-5">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <h1 class="text-4xl font-serif font-bold text-[var(--coffee)]">Meus Pedidos</h1>
            <a href="{{ route('orders.my-patterns') }}" class="px-6 py-3 bg-[var(--olive)] text-white rounded-xl font-bold text-sm hover:bg-[#5a6510] hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                Minhas Receitas Compradas
            </a>
        </div>

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-6 text-sm">
            {{ session('success') }}
        </div>
        @endif

        @if($orders->count() > 0)
        <div class="space-y-6">
            @foreach($orders as $order)
            <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 p-8 order-card">
                <div class="flex flex-col sm:flex-row justify-between items-start mb-6">
                    <div>
                        <h3 class="text-2xl font-serif font-bold text-slate-900">Pedido #{{ $order->id }}</h3>
                        <p class="text-sm text-slate-500 mt-1">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="mt-3 sm:mt-0">
                        @if($order->status === 'confirmed')
                        <span class="px-4 py-2 bg-green-50 text-green-800 border border-green-200 rounded-full text-sm font-bold">Confirmado</span>
                        @elseif($order->status === 'awaiting_payment')
                        <span class="px-4 py-2 bg-yellow-50 text-yellow-800 border border-yellow-200 rounded-full text-sm font-bold">Aguardando Pagamento</span>
                        @else
                        <span class="px-4 py-2 bg-red-50 text-red-800 border border-red-200 rounded-full text-sm font-bold">Não Confirmado</span>
                        @endif
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-5 mb-5">
                    <h4 class="font-bold text-slate-900 mb-3 uppercase tracking-wider text-xs">Itens:</h4>
                    <ul class="space-y-3">
                        @foreach($order->orderItems as $item)
                        <li class="flex justify-between items-center">
                            <span class="text-slate-700">{{ $item->pattern->name }}</span>
                            <span class="font-bold text-[var(--terracotta)]">R$ {{ number_format($item->price_at_purchase, 2, ',', '.') }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="border-t border-slate-100 pt-5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <span class="text-slate-600">Total:</span>
                        <span class="text-2xl font-bold text-[var(--terracotta)] ml-2">R$ {{ number_format($order->total_amount, 2, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('orders.show', $order) }}" class="px-6 py-3 bg-gradient-to-r from-[var(--terracotta)] to-[var(--coffee)] text-white rounded-xl font-bold text-sm hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                        Ver Detalhes
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-white p-10 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 text-center order-card">
            <p class="text-slate-600 mb-6 text-lg">Você ainda não fez nenhum pedido</p>
            <a href="{{ route('patterns.search') }}" class="inline-block px-8 py-4 bg-gradient-to-r from-[var(--terracotta)] to-[var(--coffee)] text-white rounded-xl font-bold uppercase tracking-wider text-sm hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                Buscar Receitas
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
