<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FeitoAqui')</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-[#F2F5EA] min-h-screen">
    <x-header />

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mx-auto max-w-7xl mt-4 rounded">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mx-auto max-w-7xl mt-4 rounded">
        {{ session('error') }}
    </div>
    @endif

    @auth
    <div class="hidden">
        <div class="flex items-center gap-4">
            @if(Auth::user()->photo)
            <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Foto" class="w-10 h-10 rounded-full object-cover">
            @else
            <div class="w-10 h-10 rounded-full bg-[#B2675E] flex items-center justify-center text-white font-bold">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            @endif
            <span class="font-semibold">Olá, {{ Auth::user()->name }}</span>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('home') }}" class="px-4 py-2 bg-[#6F7C12] rounded hover:bg-[#5a6510] transition-colors {{ request()->routeIs('home') ? '!bg-[#B2675E]' : '' }}">
                Início
            </a>
            <a href="{{ route('patterns.search') }}" class="px-4 py-2 bg-[#6F7C12] rounded hover:bg-[#5a6510] transition-colors">
                Buscar Receitas
            </a>
            @if(Auth::user()->is_admin)
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-purple-600 rounded hover:bg-purple-700 transition-colors">
                Admin
            </a>
            @endif
            @if(Auth::user()->is_seller)
            <a href="{{ route('materials.index') }}" class="px-4 py-2 bg-[#6F7C12] rounded hover:bg-[#5a6510] transition-colors {{ request()->routeIs('materials.*') ? '!bg-[#B2675E]' : '' }}">
                Materiais
            </a>
            <a href="{{ route('drafts.index') }}" class="px-4 py-2 bg-[#6F7C12] rounded hover:bg-[#5a6510] transition-colors {{ request()->routeIs('drafts.*') ? '!bg-[#B2675E]' : '' }}">
                Rascunhos
            </a>
            <a href="{{ route('patterns.index') }}" class="px-4 py-2 bg-[#6F7C12] rounded hover:bg-[#5a6510] transition-colors {{ request()->routeIs('patterns.*') ? '!bg-[#B2675E]' : '' }}">
                Minhas Receitas
            </a>
            @endif
            <a href="{{ route('orders.index') }}" class="px-4 py-2 bg-[#6F7C12] rounded hover:bg-[#5a6510] transition-colors {{ request()->routeIs('orders.*') ? '!bg-[#B2675E]' : '' }}">
                Pedidos
            </a>
            <a href="{{ route('cart.index') }}" class="px-4 py-2 bg-[#B2675E] rounded hover:bg-[#644536] transition-colors relative">
                🛒 Carrinho
                @if(session('cart') && count(session('cart')) > 0)
                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                    {{ count(session('cart')) }}
                </span>
                @endif
            </a>
            <a href="{{ route('users.edit', Auth::user()) }}" class="px-4 py-2 bg-[#6F7C12] rounded hover:bg-[#5a6510] transition-colors">
                Perfil
            </a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-700 rounded hover:bg-red-800 transition-colors">
                    Sair
                </button>
            </form>
        </div>
    </div>
    @endauth

    @yield('content')
</body>

</html>
