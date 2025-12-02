<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Rascunho - FeitoAqui</title>

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

        .form-input {
            transition: all 0.2s ease;
        }

        .form-input:focus {
            border-color: var(--terracotta);
            box-shadow: 0 0 0 3px rgba(178, 103, 94, 0.1);
            outline: none;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col antialiased">
    <x-header />

    <main class="flex-grow py-12 px-6">
        <div class="max-w-4xl mx-auto">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <a href="{{ route('drafts.index') }}" class="inline-flex items-center text-sm font-semibold text-[var(--coffee)] hover:text-[var(--terracotta)] transition-colors group">
                    <svg class="w-4 h-4 mr-2 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Voltar para Meus Rascunhos
                </a>
                <a href="{{ route('drafts.show', $draft) }}" class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-full font-semibold text-sm hover:bg-blue-100 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Visualizar
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

            <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 p-8 lg:p-12">
                <div class="mb-8 pb-6 border-b border-slate-100">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h1 class="text-3xl lg:text-4xl font-serif font-bold text-[var(--coffee)] mb-2">Editar Rascunho</h1>
                            <p class="text-slate-500 font-light leading-relaxed">Continue desenvolvendo sua receita de artesanato.</p>
                        </div>
                        <span class="ml-4 px-4 py-2 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold uppercase tracking-wider">
                            Rascunho
                        </span>
                    </div>
                </div>

                <form action="{{ route('drafts.update', $draft) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="title" class="block mb-2 text-sm font-bold text-[var(--coffee)] uppercase tracking-wide">
                            Título <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title" value="{{ old('title', $draft->title) }}"
                            class="form-input w-full px-4 py-3 border-2 border-slate-200 rounded-xl bg-white text-[var(--coffee)]"
                            placeholder="Ex: Amigurumi de Unicórnio, Manta de Bebê..." required>
                        @error('title')
                        <div class="text-red-600 text-sm mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="content" class="block mb-2 text-sm font-bold text-[var(--coffee)] uppercase tracking-wide">
                            Conteúdo
                        </label>
                        <textarea id="content" name="content" rows="18"
                            class="form-input w-full px-4 py-3 border-2 border-slate-200 rounded-xl bg-white text-[var(--coffee)] font-mono text-sm"
                            placeholder="Escreva aqui o conteúdo da sua receita...">{{ old('content', $draft->content) }}</textarea>
                        @error('content')
                        <div class="text-red-600 text-sm mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </div>
                        @enderror>
                    </div>

                    <div class="bg-[var(--ivory)] rounded-xl p-5 mb-8 border border-slate-100">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div class="flex items-center text-slate-600">
                                <svg class="w-4 h-4 mr-2 text-[var(--coffee)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                <span class="font-medium">Criado em:</span>
                                <span class="ml-2">{{ $draft->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="flex items-center text-slate-600">
                                <svg class="w-4 h-4 mr-2 text-[var(--coffee)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="font-medium">Última atualização:</span>
                                <span class="ml-2">{{ $draft->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-slate-100">
                        <a href="{{ route('drafts.show', $draft) }}"
                            class="flex-1 text-center py-3.5 px-6 bg-slate-100 text-slate-700 rounded-full font-semibold hover:bg-slate-200 transition-colors">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="btn-primary flex-1 py-3.5 px-6 text-white rounded-full font-semibold shadow-lg">
                            Atualizar Rascunho
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <x-footer />
</body>

</html>
