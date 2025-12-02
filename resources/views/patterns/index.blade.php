<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Receitas - FeitoAqui</title>

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
            <div class="flex items-end justify-between mb-14 pb-6 border-b border-slate-100">
                <div>
                    <h1 class="text-3xl lg:text-4xl font-serif font-bold text-[var(--coffee)] mb-3">Minhas Receitas</h1>
                    <p class="text-slate-500 font-light leading-relaxed">Gerencie suas receitas e crie novas obras de arte.</p>
                </div>
                <a href="{{ route('patterns.create') }}"
                    class="btn-primary inline-flex items-center px-6 py-3 bg-gradient-to-r from-[var(--terracotta)] to-[var(--coffee)] text-white rounded-xl font-semibold text-sm uppercase tracking-wider shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nova Receita
                </a>
            </div>

            @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 mb-8 rounded-xl shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 mb-8 rounded-xl shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            </div>
            @endif

            @if($patterns->isEmpty())
            <div class="bg-white border border-slate-100 rounded-2xl p-16 text-center shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)]">
                <div class="w-20 h-20 bg-[var(--ivory)] rounded-full flex items-center justify-center mx-auto mb-6 text-[var(--coffee)]">
                    <svg class="w-10 h-10 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-serif font-bold text-[var(--coffee)] mb-3">Nenhuma receita ainda</h2>
                <p class="text-slate-500 mb-8 max-w-md mx-auto leading-relaxed">Comece criando sua primeira receita para vender!</p>
                <a href="{{ route('patterns.create') }}"
                    class="btn-primary inline-flex items-center px-8 py-4 bg-gradient-to-r from-[var(--terracotta)] to-[var(--coffee)] text-white rounded-xl font-semibold shadow-lg">
                    Criar Primeira Receita
                </a>
            </div>
            @else
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
                        <div class="absolute top-4 right-4">
                            @if($pattern->status === 'active')
                            <span class="px-3 py-1 bg-green-500 text-white rounded-full text-[10px] font-bold uppercase tracking-wider shadow-sm">
                                Ativo
                            </span>
                            @elseif($pattern->status === 'pending')
                            <span class="px-3 py-1 bg-amber-500 text-white rounded-full text-[10px] font-bold uppercase tracking-wider shadow-sm">
                                Pendente
                            </span>
                            @else
                            <span class="px-3 py-1 bg-slate-500 text-white rounded-full text-[10px] font-bold uppercase tracking-wider shadow-sm">
                                Inativo
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="flex-1 p-8 flex flex-col">
                        <div class="mb-5">
                            <h3 class="text-lg font-serif font-bold text-[var(--coffee)] leading-tight mb-3 line-clamp-2 group-hover:text-[var(--terracotta)] transition-colors">
                                {{ $pattern->name }}
                            </h3>
                            <p class="text-sm text-slate-500 line-clamp-2">{{ Str::limit($pattern->description, 100) }}</p>
                        </div>

                        <div class="mt-auto">
                            <div class="mb-5 pb-5 border-b border-slate-50">
                                <span class="text-xl font-serif font-bold text-[var(--terracotta)]">
                                    R$ {{ number_format($pattern->price, 2, ',', '.') }}
                                </span>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('patterns.show', $pattern) }}"
                                    class="flex-1 text-center px-3 py-2 bg-blue-600 text-white rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-blue-700 transition-colors">
                                    Ver
                                </a>
                                <a href="{{ route('patterns.edit', $pattern) }}"
                                    class="flex-1 text-center px-3 py-2 bg-[var(--olive)] text-white rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-[var(--coffee)] transition-colors">
                                    Editar
                                </a>
                                <form action="{{ route('patterns.destroy', $pattern) }}" method="POST" class="flex-1" onsubmit="return confirm('Tem certeza que deseja excluir esta receita?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full px-3 py-2 bg-red-600 text-white rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-red-700 transition-colors">
                                        Excluir
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
            @endif
        </div>
    </main>

    <x-footer />
</body>

</html>
