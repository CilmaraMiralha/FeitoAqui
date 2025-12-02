<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Material - FeitoAqui</title>

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

    <section class="py-20 flex-grow">
        <div class="max-w-3xl mx-auto px-6 sm:px-8 lg:px-12">
            <div class="mb-8">
                <a href="{{ route('materials.index') }}"
                    class="inline-flex items-center text-sm text-[var(--terracotta)] hover:text-[var(--coffee)] transition-colors mb-4">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Voltar para Meus Materiais
                </a>
                <h1 class="text-3xl lg:text-4xl font-serif font-bold text-[var(--coffee)] mb-3">Cadastrar Material</h1>
                <p class="text-slate-500 font-light leading-relaxed">Adicione um novo material ao seu inventário.</p>
            </div>

            <div class="bg-white border border-slate-100 rounded-2xl p-8 lg:p-12 shadow-sm">
                <form action="{{ route('materials.store') }}" method="POST">
                    @csrf

                    <div class="mb-8">
                        <label for="name" class="block mb-3 text-sm font-bold text-[var(--coffee)] uppercase tracking-widest">
                            Nome do Material <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-[var(--terracotta)] transition-colors text-slate-700"
                            placeholder="Ex: Lã, Linha, Agulha..." required>
                        @error('name')
                            <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-8">
                        <label for="brand" class="block mb-3 text-sm font-bold text-[var(--coffee)] uppercase tracking-widest">
                            Marca
                        </label>
                        <input type="text" id="brand" name="brand" value="{{ old('brand') }}"
                            class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-[var(--terracotta)] transition-colors text-slate-700"
                            placeholder="Ex: Círculo, Pingouin, Barroco...">
                        @error('brand')
                            <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-8">
                        <label for="composition" class="block mb-3 text-sm font-bold text-[var(--coffee)] uppercase tracking-widest">
                            Composição
                        </label>
                        <textarea id="composition" name="composition" rows="3"
                            class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-[var(--terracotta)] transition-colors text-slate-700"
                            placeholder="Ex: 100% algodão, 50% acrílico 50% lã...">{{ old('composition') }}</textarea>
                        @error('composition')
                            <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-8">
                        <label for="fixed_weight" class="block mb-3 text-sm font-bold text-[var(--coffee)] uppercase tracking-widest">
                            Peso Fixo (gramas)
                        </label>
                        <input type="number" id="fixed_weight" name="fixed_weight" value="{{ old('fixed_weight') }}"
                            step="0.01" min="0"
                            class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-[var(--terracotta)] transition-colors text-slate-700"
                            placeholder="Ex: 125">
                        <div class="text-slate-500 text-sm mt-2 leading-relaxed">
                            Peso padrão do novelo/embalagem. <strong>Necessário para calcular status de estoque das variações.</strong>
                        </div>
                        @error('fixed_weight')
                            <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="bg-blue-50 border-l-4 border-blue-400 p-6 rounded-lg mb-8">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm text-blue-700 leading-relaxed">
                                <strong>Dica:</strong> Após cadastrar o material, você poderá adicionar variações (cores, códigos, quantidades em estoque).
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-4 pt-6 border-t border-slate-100">
                        <a href="{{ route('materials.index') }}"
                            class="flex-1 text-center py-4 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition-colors">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="btn-primary flex-1 py-4 bg-gradient-to-r from-[var(--terracotta)] to-[var(--coffee)] text-white rounded-xl font-bold text-sm uppercase tracking-widest">
                            Cadastrar Material
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <x-footer />
</body>
</html>
