<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $draft->title }} - FeitoAqui</title>

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

        .btn-danger {
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 12px -3px rgba(220, 38, 38, 0.3);
        }
    </style>
</head>

<body class="min-h-screen flex flex-col antialiased">
    <x-header />

    <main class="flex-grow py-12 px-6">
        <div class="max-w-5xl mx-auto">
            <div class="mb-6">
                <a href="{{ route('drafts.index') }}" class="inline-flex items-center text-sm font-semibold text-[var(--coffee)] hover:text-[var(--terracotta)] transition-colors group">
                    <svg class="w-4 h-4 mr-2 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Voltar para Meus Rascunhos
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

            <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 overflow-hidden">
                <div class="p-8 lg:p-12">
                    <div class="flex flex-col lg:flex-row justify-between items-start gap-6 mb-8 pb-8 border-b border-slate-100">
                        <div class="flex-1">
                            <div class="flex items-start gap-4 mb-4">
                                <h1 class="text-3xl lg:text-4xl font-serif font-bold text-[var(--coffee)] leading-tight flex-1">
                                    {{ $draft->title }}
                                </h1>
                                <span class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold uppercase tracking-wider whitespace-nowrap">
                                    Rascunho
                                </span>
                            </div>
                            <div class="flex flex-wrap gap-4 text-sm text-slate-500">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-[var(--coffee)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    <span class="font-medium">Criado em:</span>
                                    <span class="ml-1.5">{{ $draft->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-[var(--coffee)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">Última atualização:</span>
                                    <span class="ml-1.5">{{ $draft->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h2 class="text-xl font-serif font-bold text-[var(--coffee)] mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-[var(--terracotta)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Conteúdo
                        </h2>
                        @if($draft->content)
                        <div class="bg-[var(--ivory)] rounded-xl p-8 border border-slate-100">
                            <pre class="whitespace-pre-wrap font-mono text-sm text-[var(--coffee)] leading-relaxed">{{ $draft->content }}</pre>
                        </div>
                        @else
                        <div class="bg-slate-50 rounded-xl p-12 border-2 border-dashed border-slate-200 text-center">
                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <p class="text-slate-400 italic font-medium">Este rascunho ainda não possui conteúdo.</p>
                            <p class="text-slate-400 text-sm mt-2">Clique em "Editar Rascunho" para adicionar o conteúdo da sua receita.</p>
                        </div>
                        @endif
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-8 border-t border-slate-100">
                        <a href="{{ route('drafts.edit', $draft) }}"
                            class="flex-1 text-center py-3.5 px-6 bg-[var(--olive)] text-white rounded-full font-semibold hover:bg-[var(--coffee)] transition-colors shadow-md flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Editar Rascunho
                        </a>
                        <form action="{{ route('drafts.destroy', $draft) }}" method="POST" class="flex-1"
                            onsubmit="return confirm('Tem certeza que deseja excluir este rascunho? Esta ação não pode ser desfeita.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn-danger w-full py-3.5 px-6 bg-red-600 text-white rounded-full font-semibold hover:bg-red-700 shadow-md flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Excluir Rascunho
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <x-footer />
</body>

</html>
