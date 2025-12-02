<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Nova Receita - FeitoAqui</title>

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
        <div class="max-w-4xl mx-auto px-6 sm:px-8 lg:px-12">
            <div class="mb-8">
                <a href="{{ route('patterns.index') }}"
                    class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-[var(--coffee)] hover:text-[var(--terracotta)] transition group">
                    <span class="inline-block transition-transform group-hover:-translate-x-1 mr-2">&larr;</span>
                    Voltar para Minhas Receitas
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 p-8 sm:p-12">
                <h1 class="text-3xl lg:text-4xl font-serif font-bold text-[var(--coffee)] mb-3">Criar Nova Receita</h1>
                <p class="text-slate-500 font-light leading-relaxed mb-10">Preencha os campos abaixo para criar sua receita.</p>

                <form action="{{ route('patterns.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-8">
                        <label for="name" class="block mb-3 text-xs font-bold uppercase tracking-wider text-[var(--coffee)]">
                            Nome da Receita <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            class="w-full px-4 py-3 rounded-xl border-slate-200 border-2 focus:border-[var(--terracotta)] focus:ring-2 focus:ring-[var(--terracotta)]/20 transition-all outline-none"
                            placeholder="Ex: Amigurumi de Unicórnio" required>
                        @error('name')
                        <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-8">
                        <label for="description" class="block mb-3 text-xs font-bold uppercase tracking-wider text-[var(--coffee)]">
                            Descrição <span class="text-red-600">*</span>
                        </label>
                        <textarea id="description" name="description" rows="6"
                            class="w-full px-4 py-3 rounded-xl border-slate-200 border-2 focus:border-[var(--terracotta)] focus:ring-2 focus:ring-[var(--terracotta)]/20 transition-all outline-none"
                            placeholder="Descreva sua receita..." required>{{ old('description') }}</textarea>
                        @error('description')
                        <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-8">
                        <label for="price" class="block mb-3 text-xs font-bold uppercase tracking-wider text-[var(--coffee)]">
                            Preço (R$) <span class="text-red-600">*</span>
                        </label>
                        <input type="number" id="price" name="price" value="{{ old('price') }}"
                            step="0.01" min="0"
                            class="w-full px-4 py-3 rounded-xl border-slate-200 border-2 focus:border-[var(--terracotta)] focus:ring-2 focus:ring-[var(--terracotta)]/20 transition-all outline-none"
                            placeholder="Ex: 25.00" required>
                        @error('price')
                        <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-8">
                        <label for="tags" class="block mb-3 text-xs font-bold uppercase tracking-wider text-[var(--coffee)]">Tags</label>
                        <input type="text" id="tags" name="tags" value="{{ old('tags') }}"
                            class="w-full px-4 py-3 rounded-xl border-slate-200 border-2 focus:border-[var(--terracotta)] focus:ring-2 focus:ring-[var(--terracotta)]/20 transition-all outline-none"
                            placeholder="Ex: amigurumi, unicórnio, bebê (separadas por vírgula)">
                        <p class="text-xs text-slate-400 mt-2">Separe as tags com vírgula</p>
                        @error('tags')
                        <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-8">
                        <label for="photos" class="block mb-3 text-xs font-bold uppercase tracking-wider text-[var(--coffee)]">Fotos da Receita</label>
                        <input type="file" id="photos" name="photos[]" multiple accept="image/*"
                            class="w-full px-4 py-3 rounded-xl border-slate-200 border-2 focus:border-[var(--terracotta)] focus:ring-2 focus:ring-[var(--terracotta)]/20 transition-all outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[var(--ivory)] file:text-[var(--coffee)] hover:file:bg-[var(--dust)]">
                        <p class="text-xs text-slate-400 mt-2">Você pode selecionar múltiplas fotos (máx 2MB cada)</p>
                        @error('photos.*')
                        <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-8">
                        <label for="attachment" class="block mb-3 text-xs font-bold uppercase tracking-wider text-[var(--coffee)]">Arquivo PDF da Receita</label>
                        <input type="file" id="attachment" name="attachment" accept=".pdf"
                            class="w-full px-4 py-3 rounded-xl border-slate-200 border-2 focus:border-[var(--terracotta)] focus:ring-2 focus:ring-[var(--terracotta)]/20 transition-all outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[var(--ivory)] file:text-[var(--coffee)] hover:file:bg-[var(--dust)]">
                        <p class="text-xs text-slate-400 mt-2">Arquivo PDF com a receita completa (máx 10MB)</p>
                        @error('attachment')
                        <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="bg-blue-50 border-l-4 border-blue-400 p-5 rounded-xl mb-8">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                            <p class="text-sm text-blue-700 leading-relaxed">
                                <strong class="font-semibold">Informação:</strong> Sua receita será enviada para aprovação do administrador antes de ficar disponível para venda.
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-4 pt-6 border-t border-slate-100">
                        <a href="{{ route('patterns.index') }}"
                            class="flex-1 text-center py-4 bg-slate-100 text-[var(--coffee)] rounded-xl font-semibold hover:bg-slate-200 transition-colors">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="btn-primary flex-1 py-4 bg-gradient-to-r from-[var(--terracotta)] to-[var(--coffee)] text-white rounded-xl font-semibold shadow-lg">
                            Criar Receita
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <x-footer />
</body>

</html>
