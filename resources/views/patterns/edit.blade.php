<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Receita - {{ $pattern->name }}</title>

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
            <div class="mb-8 flex items-center justify-between">
                <a href="{{ route('patterns.show', $pattern) }}"
                    class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-[var(--coffee)] hover:text-[var(--terracotta)] transition group">
                    <span class="inline-block transition-transform group-hover:-translate-x-1 mr-2">&larr;</span>
                    Voltar
                </a>
                <a href="{{ route('patterns.show', $pattern) }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Visualizar
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 p-8 sm:p-12">
                <h1 class="text-3xl lg:text-4xl font-serif font-bold text-[var(--coffee)] mb-3">Editar Receita</h1>
                <p class="text-slate-500 font-light leading-relaxed mb-10">Atualize as informações da sua receita.</p>

                <form action="{{ route('patterns.update', $pattern) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-8">
                        <label for="name" class="block mb-3 text-xs font-bold uppercase tracking-wider text-[var(--coffee)]">
                            Nome da Receita <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $pattern->name) }}"
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
                            placeholder="Descreva sua receita..." required>{{ old('description', $pattern->description) }}</textarea>
                        @error('description')
                        <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-8">
                        <label for="price" class="block mb-3 text-xs font-bold uppercase tracking-wider text-[var(--coffee)]">
                            Preço (R$) <span class="text-red-600">*</span>
                        </label>
                        <input type="number" id="price" name="price" value="{{ old('price', $pattern->price) }}"
                            step="0.01" min="0"
                            class="w-full px-4 py-3 rounded-xl border-slate-200 border-2 focus:border-[var(--terracotta)] focus:ring-2 focus:ring-[var(--terracotta)]/20 transition-all outline-none"
                            placeholder="Ex: 25.00" required>
                        @error('price')
                        <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-8">
                        <label for="tags" class="block mb-3 text-xs font-bold uppercase tracking-wider text-[var(--coffee)]">Tags</label>
                        <input type="text" id="tags" name="tags"
                            value="{{ old('tags', $pattern->tags ? implode(', ', $pattern->tags) : '') }}"
                            class="w-full px-4 py-3 rounded-xl border-slate-200 border-2 focus:border-[var(--terracotta)] focus:ring-2 focus:ring-[var(--terracotta)]/20 transition-all outline-none"
                            placeholder="Ex: amigurumi, unicórnio, bebê (separadas por vírgula)">
                        <p class="text-xs text-slate-400 mt-2">Separe as tags com vírgula</p>
                        @error('tags')
                        <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($pattern->photos && count($pattern->photos) > 0)
                    <div class="mb-8">
                        <label class="block mb-3 text-xs font-bold uppercase tracking-wider text-[var(--coffee)]">Fotos Atuais</label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            @foreach($pattern->photos as $photo)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $photo) }}" alt="Foto" class="w-full h-32 object-cover rounded-xl border-2 border-slate-100">
                                <label class="absolute top-2 right-2 w-7 h-7 bg-red-600 text-white flex items-center justify-center rounded-full cursor-pointer font-bold text-lg shadow-lg hover:bg-red-700 transition-colors">
                                    <input type="checkbox" name="remove_photos[]" value="{{ $photo }}" class="hidden" onchange="this.parentElement.parentElement.style.opacity = this.checked ? '0.5' : '1'">
                                    &times;
                                </label>
                            </div>
                            @endforeach
                        </div>
                        <p class="text-xs text-slate-400 mt-3">Clique no X para marcar fotos para remoção</p>
                    </div>
                    @endif

                    <div class="mb-8">
                        <label for="photos" class="block mb-3 text-xs font-bold uppercase tracking-wider text-[var(--coffee)]">Adicionar Novas Fotos</label>
                        <input type="file" id="photos" name="photos[]" multiple accept="image/*"
                            class="w-full px-4 py-3 rounded-xl border-slate-200 border-2 focus:border-[var(--terracotta)] focus:ring-2 focus:ring-[var(--terracotta)]/20 transition-all outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[var(--ivory)] file:text-[var(--coffee)] hover:file:bg-[var(--dust)]">
                        <p class="text-xs text-slate-400 mt-2">Você pode selecionar múltiplas fotos (máx 2MB cada)</p>
                        @error('photos.*')
                        <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($pattern->attachment)
                    <div class="mb-8">
                        <label class="block mb-3 text-xs font-bold uppercase tracking-wider text-[var(--coffee)]">PDF Atual</label>
                        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-xl border border-slate-100">
                            <a href="{{ asset('storage/' . $pattern->attachment) }}" target="_blank" class="text-blue-600 hover:text-blue-700 font-medium flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                </svg>
                                Ver PDF atual
                            </a>
                            <label class="flex items-center gap-2 cursor-pointer ml-auto">
                                <input type="checkbox" name="remove_attachment" value="1" class="rounded border-slate-300 text-red-600 focus:ring-red-500">
                                <span class="text-sm text-red-600 font-medium">Remover PDF</span>
                            </label>
                        </div>
                    </div>
                    @endif

                    <div class="mb-8">
                        <label for="attachment" class="block mb-3 text-xs font-bold uppercase tracking-wider text-[var(--coffee)]">
                            @if($pattern->attachment)
                            Substituir Arquivo PDF
                            @else
                            Adicionar Arquivo PDF
                            @endif
                        </label>
                        <input type="file" id="attachment" name="attachment" accept=".pdf"
                            class="w-full px-4 py-3 rounded-xl border-slate-200 border-2 focus:border-[var(--terracotta)] focus:ring-2 focus:ring-[var(--terracotta)]/20 transition-all outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[var(--ivory)] file:text-[var(--coffee)] hover:file:bg-[var(--dust)]">
                        <p class="text-xs text-slate-400 mt-2">Arquivo PDF com a receita completa (máx 10MB)</p>
                        @error('attachment')
                        <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex gap-4 pt-6 border-t border-slate-100">
                        <a href="{{ route('patterns.show', $pattern) }}"
                            class="flex-1 text-center py-4 bg-slate-100 text-[var(--coffee)] rounded-xl font-semibold hover:bg-slate-200 transition-colors">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="btn-primary flex-1 py-4 bg-gradient-to-r from-[var(--terracotta)] to-[var(--coffee)] text-white rounded-xl font-semibold shadow-lg">
                            Atualizar Receita
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <x-footer />
</body>

</html>
