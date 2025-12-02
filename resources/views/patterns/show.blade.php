<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pattern->name }} - FeitoAqui</title>

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
    </style>
</head>

<body class="min-h-screen flex flex-col text-slate-600 antialiased">
    <x-header />

    <main class="py-20 flex-grow">
        <div class="max-w-6xl mx-auto px-6 sm:px-8 lg:px-12">
            <div class="mb-8">
                <a href="{{ route('patterns.index') }}"
                    class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-[var(--coffee)] hover:text-[var(--terracotta)] transition group">
                    <span class="inline-block transition-transform group-hover:-translate-x-1 mr-2">&larr;</span>
                    Voltar para Minhas Receitas
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

            <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 overflow-hidden">
                @if($pattern->photos && count($pattern->photos) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-8 bg-slate-50">
                    @foreach($pattern->photos as $photo)
                    <div class="relative overflow-hidden rounded-2xl aspect-square">
                        <img src="{{ asset('storage/' . $photo) }}" alt="{{ $pattern->name }}" class="w-full h-full object-cover">
                    </div>
                    @endforeach
                </div>
                @endif

                <div class="p-8 sm:p-12">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-6 mb-8 pb-8 border-b border-slate-100">
                        <div class="flex-1">
                            <h1 class="text-3xl lg:text-4xl font-serif font-bold text-[var(--coffee)] mb-4">{{ $pattern->name }}</h1>
                            <p class="text-3xl font-serif font-bold text-[var(--terracotta)]">R$ {{ number_format($pattern->price, 2, ',', '.') }}</p>
                        </div>
                        <div>
                            @if($pattern->status === 'active')
                            <span class="inline-block px-4 py-2 bg-green-500 text-white rounded-xl text-xs font-bold uppercase tracking-wider shadow-sm">
                                Ativo
                            </span>
                            @elseif($pattern->status === 'pending')
                            <span class="inline-block px-4 py-2 bg-amber-500 text-white rounded-xl text-xs font-bold uppercase tracking-wider shadow-sm">
                                Aguardando Aprovação
                            </span>
                            @else
                            <span class="inline-block px-4 py-2 bg-slate-500 text-white rounded-xl text-xs font-bold uppercase tracking-wider shadow-sm">
                                Inativo
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-8 pb-8 border-b border-slate-100">
                        <h2 class="text-xs font-bold uppercase tracking-wider text-[var(--coffee)] mb-4">Descrição</h2>
                        <p class="text-slate-600 whitespace-pre-wrap leading-relaxed">{{ $pattern->description }}</p>
                    </div>

                    @if($pattern->tags && count($pattern->tags) > 0)
                    <div class="mb-8 pb-8 border-b border-slate-100">
                        <h2 class="text-xs font-bold uppercase tracking-wider text-[var(--coffee)] mb-4">Tags</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach($pattern->tags as $tag)
                            <span class="px-4 py-2 bg-slate-50 text-[var(--coffee)] text-sm font-medium border border-slate-100 rounded-full hover:border-[var(--terracotta)] hover:bg-white hover:text-[var(--terracotta)] transition-all">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($pattern->attachment)
                    <div class="mb-8 pb-8 border-b border-slate-100">
                        <h2 class="text-xs font-bold uppercase tracking-wider text-[var(--coffee)] mb-4">Arquivo da Receita</h2>
                        <a href="{{ asset('storage/' . $pattern->attachment) }}" target="_blank"
                           class="btn-primary inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold shadow-lg hover:bg-blue-700">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                            </svg>
                            Download PDF
                        </a>
                    </div>
                    @endif

                    @if($pattern->user_id === Auth::id())
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('patterns.edit', $pattern) }}"
                            class="btn-primary flex-1 text-center px-6 py-4 bg-gradient-to-r from-[var(--olive)] to-[var(--coffee)] text-white rounded-xl font-semibold shadow-lg">
                            Editar Receita
                        </a>
                        <form action="{{ route('patterns.destroy', $pattern) }}" method="POST" class="flex-1"
                            onsubmit="return confirm('Tem certeza que deseja excluir esta receita? Esta ação não pode ser desfeita.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full px-6 py-4 bg-red-600 text-white rounded-xl font-semibold shadow-lg hover:bg-red-700 transition-colors">
                                Excluir Receita
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <x-footer />
</body>

</html>
