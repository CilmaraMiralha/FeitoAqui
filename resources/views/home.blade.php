<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FeitoAqui - Receitas de Artesanato</title>

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

        .hero-pattern {
            background-color: var(--coffee);
            background-image: radial-gradient(rgba(255, 255, 255, 0.07) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        .btn-primary {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(178, 103, 94, 0.3);
        }

        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.01);
        }

        /* Links animados no footer */
    </style>
</head>

<body class="min-h-screen flex flex-col text-slate-600 antialiased ">
    <x-header />

    <section class="hero-pattern text-white relative mb-4 overflow-hidden">
        <div class="absolute top-0 right-0 -mr-32 -mt-32 w-[30rem] h-[30rem] bg-[var(--terracotta)] rounded-full mix-blend-overlay filter blur-[100px] opacity-20"></div>
        <div class="absolute bottom-0 left-0 -ml-32 -mb-32 w-[30rem] h-[30rem] bg-[var(--olive)] rounded-full mix-blend-overlay filter blur-[100px] opacity-10"></div>

    </section>

    <section class="py-20 lg:py-32 flex-grow mb-8">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-16 items-start">
                <aside class="lg:col-span-3 space-y-10">
                    <div class="bg-white rounded-2xl p-10 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 sticky top-8">
                        <h2 class="text-[10px] font-bold text-[var(--coffee)] uppercase tracking-[0.2em] mb-8">
                            Categorias Populares
                        </h2>
                        <div class="flex flex-wrap gap-3">
                            @foreach(['Crochê', 'Tricô', 'Amigurumi', 'Macramê', 'Bordado'] as $category)
                            <a href="{{ route('patterns.search', ['search' => $category]) }}"
                                class="px-4 py-2 rounded-full bg-slate-50 text-[var(--coffee)] text-xs font-medium border border-slate-100 hover:border-[var(--terracotta)] hover:bg-white hover:text-[var(--terracotta)] transition-all duration-300">
                                {{ $category }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </aside>

                <main class="lg:col-span-9 mt-2">
                    <div class="flex items-end justify-between mb-14 pb-6 border-b border-slate-100">
                        <div>
                            <h2 class="text-3xl lg:text-4xl font-serif font-bold text-[var(--coffee)] mb-3">Destaques da Semana</h2>
                            <p class="text-slate-500 font-light leading-relaxed">As receitas favoritas da nossa comunidade criativa.</p>
                        </div>
                        <a href="{{ route('patterns.search') }}"
                            class="hidden sm:inline-flex items-center text-xs font-bold uppercase tracking-widest text-[var(--terracotta)] hover:text-[var(--coffee)] transition group">
                            Ver catálogo completo
                            <span class="inline-block transition-transform group-hover:translate-x-1 ml-2">&rarr;</span>
                        </a>
                    </div>

                    @if($patterns->isEmpty())
                    <div class="bg-white border border-slate-100 rounded-2xl p-16 text-center shadow-sm">
                        <div class="w-20 h-20 mt-2 bg-[var(--ivory)] rounded-full flex items-center justify-center mx-auto mb-6 text-[var(--coffee)]">
                            <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-serif font-bold text-[var(--coffee)] mb-3">Ainda não temos receitas</h3>
                        <p class="text-slate-500 mb-8 max-w-md mx-auto leading-relaxed">Nossa comunidade está apenas começando.</p>


                    </div>
                    @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                        @foreach($patterns->take(6) as $pattern)
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
                                <div class="absolute top-4 right-4 bg-white px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider text-[var(--coffee)] shadow-sm">
                                    {{ $pattern->category ?? 'Artesanato' }}
                                </div>
                            </div>

                            <div class="flex-1 p-8 flex flex-col">
                                <div class="mb-5">
                                    <h3 class="text-lg font-serif font-bold text-[var(--coffee)] leading-tight mb-3 line-clamp-2 group-hover:text-[var(--terracotta)] transition-colors">
                                        {{ $pattern->name }}
                                    </h3>
                                    <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">por {{ $pattern->user->store_name ?? explode(' ', $pattern->user->name)[0] }}</p>
                                </div>

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
                                    <a href="{{ route('login') }}" class="text-xs font-bold uppercase tracking-wider text-[var(--coffee)] hover:text-[var(--terracotta)] footer-link">
                                        Comprar
                                    </a>
                                    @endauth
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>
                    @endif
                </main>
            </div>
        </div>
    </section>

    <x-footer />
</body>

</html>