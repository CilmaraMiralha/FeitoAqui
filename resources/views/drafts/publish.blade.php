<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar Rascunho - FeitoAqui</title>

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
    </style>
</head>

<body class="min-h-screen flex flex-col antialiased">
    <x-header />

    <main class="flex-grow py-12 px-6">
        <div class="max-w-4xl mx-auto">
            <div class="mb-6">
                <a href="{{ route('drafts.show', $draft) }}" class="inline-flex items-center text-sm font-semibold text-[var(--coffee)] hover:text-[var(--terracotta)] transition-colors group">
                    <svg class="w-4 h-4 mr-2 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Voltar para o Rascunho
                </a>
            </div>

            @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 text-sm">
                {{ session('error') }}
            </div>
            @endif

            <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 p-8 lg:p-12">
                <div class="mb-8 pb-6 border-b border-slate-100">
                    <h1 class="text-3xl lg:text-4xl font-serif font-bold text-[var(--coffee)] mb-2">Publicar Rascunho como Receita</h1>
                    <p class="text-slate-500 font-light leading-relaxed">Complete as informações para transformar seu rascunho em uma receita publicada.</p>
                </div>

                <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-xl mb-6 text-sm">
                    <p class="font-semibold mb-1">Rascunho Selecionado</p>
                    <p class="text-blue-700">{{ $draft->title }}</p>
                </div>

                <form action="{{ route('drafts.store-pattern', $draft) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-xs font-bold text-[var(--coffee)] uppercase tracking-wider mb-3">
                                Nome da Receita <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name', $draft->title) }}"
                                class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-[var(--terracotta)] focus:ring-2 focus:ring-[var(--terracotta)]/20 transition-all"
                                required>
                            @error('name')
                            <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-xs font-bold text-[var(--coffee)] uppercase tracking-wider mb-3">
                                Descrição <span class="text-red-500">*</span>
                            </label>
                            <textarea id="description" name="description" rows="6"
                                class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-[var(--terracotta)] focus:ring-2 focus:ring-[var(--terracotta)]/20 transition-all"
                                required>{{ old('description', $draft->content) }}</textarea>
                            @error('description')
                            <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <label for="price" class="block text-xs font-bold text-[var(--coffee)] uppercase tracking-wider mb-3">
                                    Preço (R$) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0"
                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-[var(--terracotta)] focus:ring-2 focus:ring-[var(--terracotta)]/20 transition-all"
                                    placeholder="0.00" required>
                                @error('price')
                                <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tags" class="block text-xs font-bold text-[var(--coffee)] uppercase tracking-wider mb-3">
                                    Tags
                                </label>
                                <input type="text" id="tags" name="tags" value="{{ old('tags') }}"
                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-[var(--terracotta)] focus:ring-2 focus:ring-[var(--terracotta)]/20 transition-all"
                                    placeholder="Ex: crochê, amigurumi, iniciante">
                                @error('tags')
                                <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                                @enderror
                                <p class="text-slate-500 text-xs mt-2">Separe as tags por vírgula</p>
                            </div>
                        </div>

                        <div>
                            <label for="photos" class="block text-xs font-bold text-[var(--coffee)] uppercase tracking-wider mb-3">
                                Fotos da Receita
                            </label>
                            <input type="file" id="photos" name="photos[]" multiple accept="image/*"
                                class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-[var(--terracotta)] focus:ring-2 focus:ring-[var(--terracotta)]/20 transition-all">
                            <p class="text-slate-500 text-xs mt-2">Você pode selecionar múltiplas fotos</p>
                            @error('photos.*')
                            <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="attachment" class="block text-xs font-bold text-[var(--coffee)] uppercase tracking-wider mb-3">
                                Arquivo PDF da Receita
                            </label>
                            <input type="file" id="attachment" name="attachment" accept=".pdf"
                                class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-[var(--terracotta)] focus:ring-2 focus:ring-[var(--terracotta)]/20 transition-all">
                            <p class="text-slate-500 text-xs mt-2">Arquivo PDF com as instruções detalhadas</p>
                            @error('attachment')
                            <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-xl mb-6 text-sm">
                        <p class="font-semibold mb-1">Atenção</p>
                        <p class="text-yellow-700">Após publicar, sua receita será enviada para aprovação do administrador. O rascunho será excluído após a publicação bem-sucedida.</p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-slate-100">
                        <a href="{{ route('drafts.show', $draft) }}"
                            class="flex-1 text-center py-4 px-6 bg-slate-100 text-slate-700 rounded-xl font-semibold hover:bg-slate-200 transition-colors">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="flex-1 py-4 px-6 bg-gradient-to-r from-[var(--terracotta)] to-[var(--coffee)] text-white rounded-xl font-bold uppercase tracking-wider text-sm hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                            Publicar Receita
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <x-footer />
</body>

</html>
