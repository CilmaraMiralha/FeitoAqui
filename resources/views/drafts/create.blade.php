<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Rascunho - FeitoAqui</title>

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
            <div class="mb-6">
                <a href="{{ route('drafts.index') }}" class="inline-flex items-center text-sm font-semibold text-[var(--coffee)] hover:text-[var(--terracotta)] transition-colors group">
                    <svg class="w-4 h-4 mr-2 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Voltar para Meus Rascunhos
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 p-8 lg:p-12">
                <div class="mb-8 pb-6 border-b border-slate-100">
                    <h1 class="text-3xl lg:text-4xl font-serif font-bold text-[var(--coffee)] mb-2">Criar Novo Rascunho</h1>
                    <p class="text-slate-500 font-light leading-relaxed">Comece a desenvolver sua nova receita de artesanato.</p>
                </div>

                <form action="{{ route('drafts.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label for="title" class="block mb-2 text-sm font-bold text-[var(--coffee)] uppercase tracking-wide">
                            Título <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}"
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

                    <div class="mb-8">
                        <label for="content" class="block mb-2 text-sm font-bold text-[var(--coffee)] uppercase tracking-wide">
                            Conteúdo
                        </label>
                        <textarea id="content" name="content" rows="18"
                            class="form-input w-full px-4 py-3 border-2 border-slate-200 rounded-xl bg-white text-[var(--coffee)] font-mono text-sm"
                            placeholder="Escreva aqui o conteúdo da sua receita...&#10;&#10;Materiais:&#10;- Linha X&#10;- Agulha Y&#10;&#10;Instruções:&#10;1. Fazer anel mágico...&#10;2. ...">{{ old('content') }}</textarea>
                        @error('content')
                        <div class="text-red-600 text-sm mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </div>
                        @enderror
                        <p class="text-xs text-slate-400 mt-2 flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Você pode editar e completar este rascunho a qualquer momento antes de publicar.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-slate-100">
                        <a href="{{ route('drafts.index') }}"
                            class="flex-1 text-center py-3.5 px-6 bg-slate-100 text-slate-700 rounded-full font-semibold hover:bg-slate-200 transition-colors">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="btn-primary flex-1 py-3.5 px-6 text-white rounded-full font-semibold shadow-lg">
                            Salvar Rascunho
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <x-footer />
</body>

</html>
