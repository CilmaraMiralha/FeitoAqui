<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Rascunhos - FeitoAqui</title>

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
            background: linear-gradient(135deg, var(--terracotta) 0%, var(--coffee) 100%);
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
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>

<body class="min-h-screen flex flex-col antialiased">
    <x-header />

    <main class="flex-grow py-12 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-10 pb-6 border-b border-slate-100">
                <div>
                    <h1 class="text-3xl lg:text-4xl font-serif font-bold text-[var(--coffee)] mb-2">Meus Rascunhos</h1>
                    <p class="text-slate-500 font-light leading-relaxed">Gerencie seus rascunhos e transforme-os em receitas publicadas.</p>
                </div>
                <a href="{{ route('drafts.create') }}" class="btn-primary px-6 py-3 text-white rounded-full font-semibold text-sm shadow-lg whitespace-nowrap">
                    + Novo Rascunho
                </a>
            </div>

            @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-5 mb-8 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-5 mb-8 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            </div>
            @endif

            @if($drafts->isEmpty())
            <div class="bg-white border border-slate-100 rounded-2xl p-16 text-center shadow-sm">
                <div class="w-20 h-20 bg-[var(--ivory)] rounded-full flex items-center justify-center mx-auto mb-6 text-[var(--coffee)]">
                    <svg class="w-10 h-10 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-serif font-bold text-[var(--coffee)] mb-3">Nenhum rascunho ainda</h2>
                <p class="text-slate-500 mb-8 max-w-md mx-auto leading-relaxed">Comece criando seu primeiro rascunho de receita e desenvolva suas ideias!</p>
                <a href="{{ route('drafts.create') }}" class="btn-primary inline-block px-8 py-4 text-white rounded-full font-semibold shadow-lg">
                    Criar Primeiro Rascunho
                </a>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($drafts as $draft)
                <article class="card-hover bg-white border border-slate-100 rounded-2xl overflow-hidden flex flex-col h-full">
                    <div class="flex-1 p-8">
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-xl font-serif font-bold text-[var(--coffee)] leading-tight flex-1 line-clamp-2">
                                {{ $draft->title }}
                            </h3>
                            <span class="ml-3 px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-[10px] font-bold uppercase tracking-wider whitespace-nowrap">
                                Rascunho
                            </span>
                        </div>

                        <div class="mb-6">
                            @if($draft->content)
                            <p class="text-slate-600 text-sm leading-relaxed line-clamp-4">
                                {{ Str::limit(strip_tags($draft->content), 180) }}
                            </p>
                            @else
                            <p class="text-slate-400 italic text-sm">Sem conteúdo ainda...</p>
                            @endif
                        </div>

                        <div class="text-xs text-slate-400 font-medium mb-6 flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Atualizado em {{ $draft->updated_at->format('d/m/Y H:i') }}
                        </div>

                        <div class="grid grid-cols-3 gap-2 pt-6 border-t border-slate-50">
                            <a href="{{ route('drafts.show', $draft) }}"
                                class="text-center py-2.5 px-3 bg-blue-50 text-blue-700 rounded-lg font-semibold text-xs hover:bg-blue-100 transition-colors">
                                Ver
                            </a>
                            <a href="{{ route('drafts.edit', $draft) }}"
                                class="text-center py-2.5 px-3 bg-[var(--ivory)] text-[var(--olive)] rounded-lg font-semibold text-xs hover:bg-[var(--olive)] hover:text-white transition-colors">
                                Editar
                            </a>
                            <form action="{{ route('drafts.destroy', $draft) }}" method="POST" class="m-0"
                                onsubmit="return confirm('Tem certeza que deseja excluir este rascunho?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full py-2.5 px-3 bg-red-50 text-red-600 rounded-lg font-semibold text-xs hover:bg-red-600 hover:text-white transition-colors">
                                    Excluir
                                </button>
                            </form>
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
