@extends('layouts.app')

@section('title', 'Detalhes do Pedido')

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

    .order-item-card {
        transition: all 0.3s ease;
    }

    .order-item-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px -3px rgba(0,0,0,0.1);
    }
</style>

<div class="p-5">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('orders.index') }}" class="text-[var(--terracotta)] hover:text-[var(--coffee)] font-medium transition-colors">← Voltar para Meus Pedidos</a>
        </div>

        <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 p-8 sm:p-10">
            <div class="flex flex-col sm:flex-row justify-between items-start mb-8">
                <div>
                    <h1 class="text-4xl font-serif font-bold text-slate-900">Pedido #{{ $order->id }}</h1>
                    <p class="text-slate-500 mt-2">Data: {{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    @if($order->status === 'confirmed')
                    <span class="px-4 py-2 bg-green-50 text-green-800 border border-green-200 rounded-full text-sm font-bold">Confirmado</span>
                    @elseif($order->status === 'awaiting_payment')
                    <span class="px-4 py-2 bg-yellow-50 text-yellow-800 border border-yellow-200 rounded-full text-sm font-bold">Aguardando Pagamento</span>
                    @else
                    <span class="px-4 py-2 bg-red-50 text-red-800 border border-red-200 rounded-full text-sm font-bold">Não Confirmado</span>
                    @endif
                </div>
            </div>

            <!-- Informações de Pagamento -->
            @if($order->payment)
            <div class="bg-[var(--ivory)] p-6 rounded-xl mb-8 border border-slate-100">
                <h2 class="font-bold text-lg text-[var(--coffee)] mb-4 uppercase tracking-wider text-xs">Informações de Pagamento</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Método:</p>
                        <p class="font-bold text-slate-900">{{ $order->payment->payment_method === 'pix' ? 'PIX' : 'Cartão' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Status:</p>
                        @if($order->payment->status === 'approved')
                        <p class="font-bold text-green-600">Aprovado</p>
                        @elseif($order->payment->status === 'pending')
                        <p class="font-bold text-yellow-600">Pendente</p>
                        @else
                        <p class="font-bold text-red-600">Rejeitado</p>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Itens do Pedido -->
            <div class="mb-8">
                <h2 class="font-bold text-lg text-[var(--coffee)] mb-5 uppercase tracking-wider text-xs">Itens do Pedido</h2>
                <div class="space-y-4">
                    @foreach($order->orderItems as $item)
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-5 border border-slate-200 rounded-xl order-item-card">
                        <div class="flex items-center gap-4 w-full sm:w-auto">
                            @if($item->pattern->photos && count($item->pattern->photos) > 0)
                            <img src="{{ asset('storage/' . $item->pattern->photos[0]) }}" alt="{{ $item->pattern->name }}" class="w-20 h-20 object-cover rounded-xl">
                            @else
                            <div class="w-20 h-20 bg-slate-100 rounded-xl flex items-center justify-center">
                                <span class="text-slate-400 text-2xl">📄</span>
                            </div>
                            @endif
                            <div>
                                <h3 class="font-bold text-slate-900">{{ $item->pattern->name }}</h3>
                                <p class="text-sm text-slate-600">por {{ $item->pattern->user->store_name ?? $item->pattern->user->name }}</p>

                                @if($order->status === 'confirmed')
                                <a href="{{ asset('storage/' . $item->pattern->attachment) }}" target="_blank" class="text-sm text-[var(--terracotta)] hover:text-[var(--coffee)] font-medium mt-2 inline-block transition-colors">
                                    Baixar PDF
                                </a>
                                @endif
                            </div>
                        </div>
                        <div class="text-right mt-3 sm:mt-0">
                            <p class="font-bold text-[var(--terracotta)] text-lg">R$ {{ number_format($item->price_at_purchase, 2, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Total -->
            <div class="border-t border-slate-200 pt-6">
                <div class="flex justify-between items-center text-2xl">
                    <span class="font-bold text-slate-900">Total:</span>
                    <span class="font-bold text-[var(--terracotta)]">R$ {{ number_format($order->total_amount, 2, ',', '.') }}</span>
                </div>
            </div>

            @if($order->status === 'confirmed')
            <div class="bg-green-50 border border-green-200 rounded-xl p-5 mt-8">
                <p class="text-sm text-green-800">
                    <strong>Pedido confirmado!</strong> Você já pode acessar suas receitas baixando os PDFs acima.
                </p>
            </div>
            @elseif($order->status === 'awaiting_payment')
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 mt-8">
                <p class="text-sm text-yellow-800">
                    <strong>Aguardando pagamento.</strong> Assim que o pagamento for confirmado, você receberá um e-mail e poderá acessar suas receitas.
                </p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
