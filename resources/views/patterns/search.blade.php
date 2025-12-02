<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Receitas - FeitoAqui</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')

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

        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.01);
        }

        .btn-primary {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(178, 103, 94, 0.3);
        }
    </style>
</head>

<body class="min-h-screen flex flex-col text-slate-600 antialiased">
    <x-header />

    <main class="py-20 flex-grow">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
            <div class="mb-14">
                <h1 class="text-3xl lg:text-4xl font-serif font-bold text-[var(--coffee)] mb-3">Buscar Receitas</h1>
                <p class="text-slate-500 font-light leading-relaxed">Encontre a receita perfeita para o seu próximo projeto.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 p-8 mb-12">
                <form action="{{ route('patterns.search') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <label for="search" class="block mb-3 text-xs font-bold uppercase tracking-wider text-[var(--coffee)]">Buscar</label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                            class="w-full px-4 py-3 rounded-xl border-slate-200 border-2 focus:border-[var(--terracotta)] focus:ring-2 focus:ring-[var(--terracotta)]/20 transition-all outline-none"
                            placeholder="Nome ou tag...">
                    </div>

                    <div>
                        <label for="min_price" class="block mb-3 text-xs font-bold uppercase tracking-wider text-[var(--coffee)]">Preço Mínimo</label>
                        <input type="number" id="min_price" name="min_price" value="{{ request('min_price') }}" step="0.01" min="0"
                            class="w-full px-4 py-3 rounded-xl border-slate-200 border-2 focus:border-[var(--terracotta)] focus:ring-2 focus:ring-[var(--terracotta)]/20 transition-all outline-none"
                            placeholder="R$ 0,00">
                    </div>

                    <div>
                        <label for="max_price" class="block mb-3 text-xs font-bold uppercase tracking-wider text-[var(--coffee)]">Preço Máximo</label>
                        <input type="number" id="max_price" name="max_price" value="{{ request('max_price') }}" step="0.01" min="0"
                            class="w-full px-4 py-3 rounded-xl border-slate-200 border-2 focus:border-[var(--terracotta)] focus:ring-2 focus:ring-[var(--terracotta)]/20 transition-all outline-none"
                            placeholder="R$ 999,99">
                    </div>

                    <div>
                        <label for="seller" class="block mb-3 text-xs font-bold uppercase tracking-wider text-[var(--coffee)]">Vendedor</label>
                        <input type="text" id="seller" name="seller" value="{{ request('seller') }}"
                            class="w-full px-4 py-3 rounded-xl border-slate-200 border-2 focus:border-[var(--terracotta)] focus:ring-2 focus:ring-[var(--terracotta)]/20 transition-all outline-none"
                            placeholder="Nome da loja...">
                    </div>

                    <div class="sm:col-span-2 lg:col-span-4 flex gap-3">
                        <button type="submit" class="btn-primary px-8 py-3 bg-gradient-to-r from-[var(--terracotta)] to-[var(--coffee)] text-white rounded-xl font-semibold shadow-lg">
                            Buscar
                        </button>
                        <a href="{{ route('patterns.search') }}" class="px-8 py-3 bg-slate-100 text-[var(--coffee)] rounded-xl font-semibold hover:bg-slate-200 transition-colors">
                            Limpar Filtros
                        </a>
                    </div>
                </form>
            </div>

            @if($patterns->count() > 0)
            <div class="mb-8">
                <p class="text-sm text-slate-500">
                    Encontrados <span class="font-semibold text-[var(--coffee)]">{{ $patterns->total() }}</span>
                    {{ $patterns->total() === 1 ? 'resultado' : 'resultados' }}
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($patterns as $pattern)
                <article class="card-hover bg-white border border-slate-100 rounded-2xl overflow-hidden flex flex-col h-full group">
                    <div class="relative overflow-hidden aspect-square">
                        @if($pattern->photos && count($pattern->photos) > 0)
                        <img src="{{ asset('storage/' . $pattern->photos[0]) }}"
                            alt="{{ $pattern->name }}"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                        @else
                        <div class="w-full h-full bg-[var(--ivory)] flex items-center justify-center text-[var(--coffee)] opacity-40">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        @endif
                    </div>

                    <div class="flex-1 p-8 flex flex-col">
                        <div class="mb-5">
                            <h3 class="text-lg font-serif font-bold text-[var(--coffee)] leading-tight mb-3 line-clamp-2 group-hover:text-[var(--terracotta)] transition-colors">
                                {{ $pattern->name }}
                            </h3>
                            <p class="text-sm text-slate-500 line-clamp-2 mb-3">{{ $pattern->description }}</p>
                            <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">
                                por {{ $pattern->user->store_name ?? explode(' ', $pattern->user->name)[0] }}
                            </p>
                        </div>

                        @if($pattern->tags && count($pattern->tags) > 0)
                        <div class="flex flex-wrap gap-2 mb-5">
                            @foreach(array_slice($pattern->tags, 0, 3) as $tag)
                            <span class="text-xs bg-slate-50 px-3 py-1 rounded-full text-[var(--coffee)] border border-slate-100">{{ $tag }}</span>
                            @endforeach
                        </div>
                        @endif

                        <div class="mt-auto flex items-center justify-between pt-6 border-t border-slate-50">
                            <span class="text-xl font-serif font-bold text-[var(--terracotta)]">
                                R$ {{ number_format($pattern->price, 2, ',', '.') }}
                            </span>

                            @auth
                            <form action="{{ route('cart.add', $pattern) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-10 h-10 rounded-full bg-[var(--ivory)] text-[var(--coffee)] flex items-center justify-center hover:bg-[var(--coffee)] hover:text-white transition-colors duration-300" title="Adicionar ao carrinho">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </button>
                            </form>
                            @else
                            <a href="{{ route('login') }}" class="text-xs font-bold uppercase tracking-wider text-[var(--coffee)] hover:text-[var(--terracotta)] transition">
                                Comprar
                            </a>
                            @endauth
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $patterns->links() }}
            </div>
            @else
            <div class="bg-white border border-slate-100 rounded-2xl p-16 text-center shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)]">
                <div class="w-20 h-20 bg-[var(--ivory)] rounded-full flex items-center justify-center mx-auto mb-6 text-[var(--coffee)]">
                    <svg class="w-10 h-10 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-serif font-bold text-[var(--coffee)] mb-3">Nenhuma receita encontrada</h3>
                <p class="text-slate-500 mb-8 max-w-md mx-auto leading-relaxed">Tente ajustar seus filtros de busca ou explore outras categorias.</p>
                <a href="{{ route('patterns.search') }}"
                    class="btn-primary inline-flex items-center px-8 py-4 bg-gradient-to-r from-[var(--terracotta)] to-[var(--coffee)] text-white rounded-xl font-semibold shadow-lg">
                    Limpar Busca
                </a>
            </div>
            @endif
        </div>
    </main>

    <x-footer />
</body>

</html>
