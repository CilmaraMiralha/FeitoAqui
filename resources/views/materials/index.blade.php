<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Materiais - FeitoAqui</title>

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
    </style>
</head>

<body class="min-h-screen flex flex-col text-slate-600 antialiased">
    <x-header />

    <section class="py-20 flex-grow">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
            <div class="flex items-end justify-between mb-14 pb-6 border-b border-slate-100">
                <div>
                    <h1 class="text-3xl lg:text-4xl font-serif font-bold text-[var(--coffee)] mb-3">Meus Materiais</h1>
                    <p class="text-slate-500 font-light leading-relaxed">Organize e gerencie seus materiais de artesanato.</p>
                </div>
                <a href="{{ route('materials.create') }}"
                    class="btn-primary inline-flex items-center px-6 py-3 rounded-full bg-gradient-to-r from-[var(--terracotta)] to-[var(--coffee)] text-white font-bold text-sm uppercase tracking-widest">
                    + Novo Material
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded-lg mb-8">
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if($materials->isEmpty())
                <div class="bg-white border border-slate-100 rounded-2xl p-16 text-center shadow-sm">
                    <div class="w-20 h-20 bg-[var(--ivory)] rounded-full flex items-center justify-center mx-auto mb-6 text-[var(--coffee)]">
                        <svg class="w-10 h-10 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-serif font-bold text-[var(--coffee)] mb-3">Nenhum material cadastrado</h3>
                    <p class="text-slate-500 mb-8 max-w-md mx-auto leading-relaxed">Comece organizando seus materiais para facilitar o gerenciamento de seus projetos.</p>
                    <a href="{{ route('materials.create') }}"
                        class="btn-primary inline-flex items-center px-8 py-4 rounded-full bg-gradient-to-r from-[var(--terracotta)] to-[var(--coffee)] text-white font-bold text-sm uppercase tracking-widest">
                        Cadastrar Primeiro Material
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($materials as $material)
                        <article class="card-hover bg-white border border-slate-100 rounded-2xl overflow-hidden flex flex-col h-full group">
                            <div class="p-8 flex-1">
                                <div class="flex justify-between items-start mb-6">
                                    <h3 class="text-xl font-serif font-bold text-[var(--coffee)] leading-tight group-hover:text-[var(--terracotta)] transition-colors">
                                        {{ $material->name }}
                                    </h3>
                                    <div class="flex gap-2">
                                        <a href="{{ route('materials.show', $material) }}"
                                            class="w-8 h-8 rounded-full bg-slate-50 text-blue-600 flex items-center justify-center hover:bg-blue-50 transition-colors"
                                            title="Visualizar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('materials.edit', $material) }}"
                                            class="w-8 h-8 rounded-full bg-slate-50 text-yellow-600 flex items-center justify-center hover:bg-yellow-50 transition-colors"
                                            title="Editar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('materials.destroy', $material) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este material?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-8 h-8 rounded-full bg-slate-50 text-red-600 flex items-center justify-center hover:bg-red-50 transition-colors"
                                                title="Excluir">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="space-y-3 mb-6">
                                    @if($material->brand)
                                        <div class="flex items-start gap-2">
                                            <span class="text-xs text-slate-400 font-medium uppercase tracking-wide min-w-[80px]">Marca:</span>
                                            <span class="text-sm text-slate-600 font-medium">{{ $material->brand }}</span>
                                        </div>
                                    @endif

                                    @if($material->composition)
                                        <div class="flex items-start gap-2">
                                            <span class="text-xs text-slate-400 font-medium uppercase tracking-wide min-w-[80px]">Composição:</span>
                                            <span class="text-sm text-slate-600 font-medium">{{ $material->composition }}</span>
                                        </div>
                                    @endif

                                    @if($material->fixed_weight)
                                        <div class="flex items-start gap-2">
                                            <span class="text-xs text-slate-400 font-medium uppercase tracking-wide min-w-[80px]">Peso:</span>
                                            <span class="text-sm text-slate-600 font-medium">{{ $material->fixed_weight }}g</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="border-t border-slate-50 pt-6">
                                    <p class="text-xs text-slate-400 font-medium uppercase tracking-wide mb-3">
                                        Variações: {{ $material->variations->count() }}
                                    </p>

                                    @if($material->variations->count() > 0)
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($material->variations->take(5) as $variation)
                                                <span class="px-3 py-1 text-xs bg-[var(--ivory)] text-[var(--coffee)] rounded-full font-medium">
                                                    {{ $variation->color }}
                                                    @if($variation->color_code)
                                                        ({{ $variation->color_code }})
                                                    @endif
                                                </span>
                                            @endforeach
                                            @if($material->variations->count() > 5)
                                                <span class="px-3 py-1 text-xs bg-[var(--coffee)] text-white rounded-full font-bold">
                                                    +{{ $material->variations->count() - 5 }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <x-footer />
</body>
</html>
