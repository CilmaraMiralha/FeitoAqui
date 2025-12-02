@extends('layouts.app')

@section('title', 'Carrinho de Compras')

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

    .cart-card {
        transition: all 0.3s ease;
    }

    .cart-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px -5px rgba(0,0,0,0.1);
    }

    .cart-item-row {
        transition: all 0.2s ease;
    }

    .cart-item-row:hover {
        background-color: #F8F9FA;
    }
</style>

<div class="p-5">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-4xl font-serif font-bold text-[var(--coffee)] mb-8">Carrinho de Compras</h1>

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-6 text-sm">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 text-sm">
            {{ session('error') }}
        </div>
        @endif

        @if(empty($cart))
        <div class="bg-white p-10 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 text-center cart-card">
            <p class="text-slate-600 mb-6 text-lg">Seu carrinho está vazio</p>
            <a href="{{ route('patterns.search') }}" class="inline-block px-8 py-4 bg-gradient-to-r from-[var(--terracotta)] to-[var(--coffee)] text-white rounded-xl font-bold uppercase tracking-wider text-sm hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                Buscar Receitas
            </a>
        </div>
        @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 overflow-hidden cart-card">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-[var(--coffee)] to-[var(--terracotta)] text-white">
                            <tr>
                                <th class="px-6 py-4 text-left font-bold uppercase tracking-wider text-xs">Receita</th>
                                <th class="px-6 py-4 text-center font-bold uppercase tracking-wider text-xs">Preço</th>
                                <th class="px-6 py-4 text-center font-bold uppercase tracking-wider text-xs">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $id => $item)
                            <tr class="border-b border-slate-100 cart-item-row">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        @if($item['photo'])
                                        <img src="{{ asset('storage/' . $item['photo']) }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded-xl">
                                        @else
                                        <div class="w-16 h-16 bg-slate-100 rounded-xl flex items-center justify-center">
                                            <span class="text-slate-400 text-2xl">📄</span>
                                        </div>
                                        @endif
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $item['name'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <p class="font-bold text-[var(--terracotta)]">R$ {{ number_format($item['price'], 2, ',', '.') }}</p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('cart.remove', $id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium transition-colors" onclick="return confirm('Tem certeza que deseja remover este item?')">
                                            Remover
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    <form action="{{ route('cart.clear') }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-xl font-bold text-sm hover:bg-red-700 hover:shadow-lg transform hover:-translate-y-0.5 transition-all" onclick="return confirm('Tem certeza que deseja limpar o carrinho?')">
                            Limpar Carrinho
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white p-8 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 sticky top-5 cart-card">
                    <h2 class="text-2xl font-serif font-bold text-[var(--coffee)] mb-6">Resumo do Pedido</h2>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-slate-600">
                            <span>Subtotal</span>
                            <span class="font-semibold">R$ {{ number_format($total, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-xl font-bold border-t border-slate-100 pt-3">
                            <span class="text-slate-900">Total</span>
                            <span class="text-[var(--terracotta)]">R$ {{ number_format($total, 2, ',', '.') }}</span>
                        </div>
                    </div>

                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-4 bg-gradient-to-r from-[var(--terracotta)] to-[var(--coffee)] text-white rounded-xl font-bold uppercase tracking-wider text-sm hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                            Finalizar Compra
                        </button>
                    </form>

                    <a href="{{ route('patterns.search') }}" class="block text-center mt-4 text-[var(--terracotta)] hover:text-[var(--coffee)] transition-colors font-medium">
                        Continuar Comprando
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
