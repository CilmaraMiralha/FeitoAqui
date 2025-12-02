<div class="bg-[#644536] text-white shadow-md">
    <div class="max-w-7xl mx-auto px-8 py-4">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <span class="text-3xl">🧶</span>
                <div>
                    <h1 class="text-2xl font-bold">FeitoAqui</h1>
                    <p class="text-xs text-gray-300">Receitas de Artesanato</p>
                </div>
            </a>

            <!-- Menu -->
            <div class="flex items-center gap-4">
                @auth
                    @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-purple-600 rounded hover:bg-purple-700 transition-colors">
                        Admin
                    </a>
                    @endif

                    <a href="{{ route('patterns.search') }}" class="px-4 py-2 bg-[#6F7C12] rounded hover:bg-[#5a6510] transition-colors">
                        Buscar
                    </a>

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
                        🛒
                        @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                            {{ count(session('cart')) }}
                        </span>
                        @endif
                    </a>

                    <!-- User Menu -->
                    <div class="flex items-center gap-3 ml-3 pl-3 border-l border-gray-500">
                        @if(Auth::user()->photo)
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Foto" class="w-10 h-10 rounded-full object-cover">
                        @else
                        <div class="w-10 h-10 rounded-full bg-[#B2675E] flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        @endif
                        <div class="flex items-center gap-2">
                            <a href="{{ route('users.edit', Auth::user()) }}" class="hover:underline">
                                {{ Auth::user()->name }}
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-3 py-1 bg-red-700 rounded hover:bg-red-800 transition-colors text-sm">
                                    Sair
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('patterns.search') }}" class="px-4 py-2 bg-[#6F7C12] rounded hover:bg-[#5a6510] transition-colors">
                        Buscar Receitas
                    </a>
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-[#B2675E] rounded hover:bg-[#644536] transition-colors">
                        Entrar
                    </a>
                    <a href="{{ route('users.create') }}" class="px-4 py-2 bg-[#6F7C12] rounded hover:bg-[#5a6510] transition-colors">
                        Criar Conta
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>
