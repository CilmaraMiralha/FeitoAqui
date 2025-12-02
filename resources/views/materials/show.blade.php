<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $material->name }} - Detalhes - FeitoAqui</title>

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

        .hidden {
            display: none;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col text-slate-600 antialiased">
    <x-header />

    <section class="py-20 flex-grow">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
            <div class="mb-8">
                <a href="{{ route('materials.index') }}"
                    class="inline-flex items-center text-sm text-[var(--terracotta)] hover:text-[var(--coffee)] transition-colors mb-4">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Voltar para Meus Materiais
                </a>
                <div class="flex items-end justify-between mb-6 pb-6 border-b border-slate-100">
                    <div>
                        <h1 class="text-3xl lg:text-4xl font-serif font-bold text-[var(--coffee)] mb-3">{{ $material->name }}</h1>
                        <p class="text-slate-500 font-light leading-relaxed">Gerenciar detalhes e variações do material.</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('materials.edit', $material) }}"
                            class="btn-primary inline-flex items-center px-5 py-3 rounded-full bg-yellow-500 text-white font-bold text-sm uppercase tracking-widest hover:bg-yellow-600">
                            Editar Material
                        </a>
                        <form action="{{ route('materials.destroy', $material) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este material? Todas as variações também serão excluídas.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn-primary inline-flex items-center px-5 py-3 rounded-full bg-red-600 text-white font-bold text-sm uppercase tracking-widest hover:bg-red-700">
                                Excluir Material
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded-lg mb-8">
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-lg mb-8">
                    <p class="text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <!-- Material Information -->
            <div class="bg-white border border-slate-100 rounded-2xl p-8 shadow-sm mb-8">
                <h2 class="text-xs font-bold text-[var(--coffee)] uppercase tracking-widest mb-6">Informações do Material</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @if($material->brand)
                        <div class="bg-[var(--ivory)] p-6 rounded-xl">
                            <p class="text-xs text-slate-400 font-medium uppercase tracking-wide mb-2">Marca</p>
                            <p class="text-lg text-[var(--coffee)] font-bold">{{ $material->brand }}</p>
                        </div>
                    @endif

                    @if($material->composition)
                        <div class="bg-[var(--ivory)] p-6 rounded-xl">
                            <p class="text-xs text-slate-400 font-medium uppercase tracking-wide mb-2">Composição</p>
                            <p class="text-lg text-[var(--coffee)] font-bold">{{ $material->composition }}</p>
                        </div>
                    @endif

                    @if($material->fixed_weight)
                        <div class="bg-[var(--ivory)] p-6 rounded-xl">
                            <p class="text-xs text-slate-400 font-medium uppercase tracking-wide mb-2">Peso Fixo</p>
                            <p class="text-lg text-[var(--coffee)] font-bold">{{ $material->fixed_weight }}g</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Variations Section -->
            <div class="bg-white border border-slate-100 rounded-2xl p-8 shadow-sm">
                <div class="flex items-end justify-between mb-8 pb-6 border-b border-slate-100">
                    <div>
                        <h2 class="text-2xl font-serif font-bold text-[var(--coffee)] mb-2">Variações</h2>
                        <p class="text-slate-500 font-light leading-relaxed">Cores e quantidades em estoque.</p>
                    </div>
                    <button onclick="toggleAddVariationForm()"
                        class="btn-primary inline-flex items-center px-6 py-3 rounded-full bg-gradient-to-r from-[var(--terracotta)] to-[var(--coffee)] text-white font-bold text-sm uppercase tracking-widest">
                        + Nova Variação
                    </button>
                </div>

                <!-- Quick Weight Adjustment Panel -->
                @if($material->variations->count() > 0)
                    <div class="bg-[var(--ivory)] border border-slate-100 p-6 rounded-xl mb-8">
                        <h3 class="text-xs font-bold text-[var(--coffee)] uppercase tracking-widest mb-4">Ajuste Rápido de Peso</h3>
                        <form action="{{ route('materials.variations.adjust', $material) }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                                <div class="md:col-span-5">
                                    <select id="variation_id" name="variation_id" required onchange="updateCurrentWeight()"
                                        class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-[var(--terracotta)] transition-colors text-slate-700">
                                        <option value="">Selecione a variação...</option>
                                        @foreach($material->variations as $variation)
                                            <option value="{{ $variation->id }}" data-weight="{{ $variation->weight }}">
                                                {{ $variation->color }}
                                                @if($variation->color_code)
                                                    ({{ $variation->color_code }})
                                                @endif
                                                - {{ $variation->weight }}g
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="md:col-span-3">
                                    <input type="number" id="weight_adjustment" name="weight_adjustment" step="0.01" min="0.01" placeholder="Peso (g)" required
                                        class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-[var(--terracotta)] transition-colors text-slate-700">
                                </div>
                                <div class="md:col-span-2">
                                    <button type="submit" name="action" value="add"
                                        class="w-full px-4 py-3 rounded-xl bg-green-600 text-white font-bold hover:bg-green-700 transition-colors">
                                        + Adicionar
                                    </button>
                                </div>
                                <div class="md:col-span-2">
                                    <button type="submit" name="action" value="remove"
                                        class="w-full px-4 py-3 rounded-xl bg-red-600 text-white font-bold hover:bg-red-700 transition-colors">
                                        - Remover
                                    </button>
                                </div>
                            </div>
                            <div id="current-weight-info" class="hidden mt-3 text-sm text-slate-600">
                                Peso atual: <span id="current-weight-value" class="font-bold text-[var(--coffee)]">-</span>
                            </div>
                        </form>
                    </div>
                @endif

                <!-- Add Variation Form (hidden initially) -->
                <div id="addVariationForm" class="hidden mb-8 bg-[var(--ivory)] border-2 border-slate-200 p-8 rounded-xl">
                    <h3 class="text-lg font-bold text-[var(--coffee)] mb-6">Adicionar Nova Variação</h3>
                    <form action="{{ route('materials.variations.store', $material) }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="color" class="block mb-3 text-sm font-bold text-[var(--coffee)] uppercase tracking-widest">
                                    Cor <span class="text-red-600">*</span>
                                </label>
                                <input type="text" id="color" name="color" value="{{ old('color') }}"
                                    class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-[var(--terracotta)] transition-colors text-slate-700"
                                    placeholder="Ex: Azul marinho" required>
                            </div>

                            <div>
                                <label for="color_code" class="block mb-3 text-sm font-bold text-[var(--coffee)] uppercase tracking-widest">
                                    Código da Cor
                                </label>
                                <input type="text" id="color_code" name="color_code" value="{{ old('color_code') }}"
                                    class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-[var(--terracotta)] transition-colors text-slate-700"
                                    placeholder="Ex: 1234, 5678">
                                <div class="text-slate-500 text-xs mt-2">Código da embalagem</div>
                            </div>

                            <div>
                                <label for="weight" class="block mb-3 text-sm font-bold text-[var(--coffee)] uppercase tracking-widest">
                                    Peso (gramas) <span class="text-red-600">*</span>
                                </label>
                                <input type="number" id="weight" name="weight" value="{{ old('weight') }}"
                                    step="0.01" min="0"
                                    class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-[var(--terracotta)] transition-colors text-slate-700"
                                    placeholder="100" required>
                            </div>
                        </div>

                        <div class="flex gap-4 mt-6">
                            <button type="button" onclick="toggleAddVariationForm()"
                                class="flex-1 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition-colors">
                                Cancelar
                            </button>
                            <button type="submit"
                                class="btn-primary flex-1 py-3 bg-gradient-to-r from-[var(--terracotta)] to-[var(--coffee)] text-white rounded-xl font-bold">
                                Adicionar Variação
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Warning if no fixed weight -->
                @if(!$material->fixed_weight)
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-lg mb-6">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-yellow-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <p class="text-sm text-yellow-700 leading-relaxed">
                                <strong>Atenção:</strong> Cadastre o peso fixo do material para que o sistema possa calcular automaticamente o status de estoque das variações.
                                <a href="{{ route('materials.edit', $material) }}" class="underline font-bold hover:text-yellow-900">Adicionar peso fixo</a>
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Variations List -->
                @if($material->variations->isEmpty())
                    <div class="text-center py-16">
                        <div class="w-20 h-20 bg-[var(--ivory)] rounded-full flex items-center justify-center mx-auto mb-6 text-[var(--coffee)]">
                            <svg class="w-10 h-10 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-serif font-bold text-[var(--coffee)] mb-2">Nenhuma variação cadastrada</h3>
                        <p class="text-slate-500">Clique em "Nova Variação" para adicionar cores e quantidades.</p>
                    </div>
                @else
                    <div class="overflow-x-auto rounded-xl border border-slate-100">
                        <table class="w-full">
                            <thead class="bg-[var(--coffee)] text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-widest">Cor</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-widest">Código</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-widest">Peso (g)</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-widest">Status</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-widest">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($material->variations as $variation)
                                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors" id="variation-{{ $variation->id }}">
                                        <td class="px-6 py-4">
                                            <span class="font-bold text-[var(--coffee)]">{{ $variation->color }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($variation->color_code)
                                                <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs rounded-full font-medium border border-blue-200">
                                                    {{ $variation->color_code }}
                                                </span>
                                            @else
                                                <span class="text-slate-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div>
                                                <span class="font-bold text-slate-700">{{ $variation->weight }}g</span>
                                                @if($variation->percentage !== null)
                                                    <span class="text-sm text-slate-500 ml-1">
                                                        ({{ number_format($variation->percentage, 1) }}%)
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 {{ $variation->status['bg'] }} {{ $variation->status['text'] }} text-xs rounded-full font-bold">
                                                {{ $variation->status['label'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex gap-2 justify-end">
                                                <button onclick="editVariation({{ $variation->id }}, '{{ $variation->color }}', '{{ $variation->color_code }}', '{{ $variation->weight }}')"
                                                    class="w-8 h-8 rounded-full bg-slate-50 text-yellow-600 flex items-center justify-center hover:bg-yellow-50 transition-colors"
                                                    title="Editar">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                                <form action="{{ route('materials.variations.destroy', [$material, $variation]) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta variação?')">
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
                                        </td>
                                    </tr>
                                    <!-- Edit Form (hidden) -->
                                    <tr id="edit-form-{{ $variation->id }}" class="hidden bg-slate-50">
                                        <td colspan="5" class="px-6 py-6">
                                            <form action="{{ route('materials.variations.update', [$material, $variation]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                    <div>
                                                        <label class="block mb-2 text-sm font-bold text-[var(--coffee)] uppercase tracking-widest">Cor</label>
                                                        <input type="text" name="color" value="{{ $variation->color }}"
                                                            class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-[var(--terracotta)] transition-colors" required>
                                                    </div>
                                                    <div>
                                                        <label class="block mb-2 text-sm font-bold text-[var(--coffee)] uppercase tracking-widest">Código</label>
                                                        <input type="text" name="color_code" value="{{ $variation->color_code }}"
                                                            class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-[var(--terracotta)] transition-colors"
                                                            placeholder="Ex: 1234">
                                                    </div>
                                                    <div>
                                                        <label class="block mb-2 text-sm font-bold text-[var(--coffee)] uppercase tracking-widest">Peso (g)</label>
                                                        <input type="number" name="weight" value="{{ $variation->weight }}"
                                                            step="0.01" min="0" class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-[var(--terracotta)] transition-colors" required>
                                                    </div>
                                                </div>
                                                <div class="flex gap-4 mt-6">
                                                    <button type="button" onclick="cancelEdit({{ $variation->id }})"
                                                        class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition-colors">
                                                        Cancelar
                                                    </button>
                                                    <button type="submit"
                                                        class="btn-primary px-6 py-3 bg-gradient-to-r from-[var(--terracotta)] to-[var(--coffee)] text-white rounded-xl font-bold">
                                                        Salvar Alterações
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <x-footer />

    <script>
        function toggleAddVariationForm() {
            const form = document.getElementById('addVariationForm');
            form.classList.toggle('hidden');
        }

        function editVariation(id, color, colorCode, weight) {
            document.getElementById('variation-' + id).classList.add('hidden');
            document.getElementById('edit-form-' + id).classList.remove('hidden');
        }

        function cancelEdit(id) {
            document.getElementById('variation-' + id).classList.remove('hidden');
            document.getElementById('edit-form-' + id).classList.add('hidden');
        }

        function updateCurrentWeight() {
            const select = document.getElementById('variation_id');
            const selectedOption = select.options[select.selectedIndex];
            const weightInfo = document.getElementById('current-weight-info');
            const weightValue = document.getElementById('current-weight-value');

            if (selectedOption.value) {
                const currentWeight = selectedOption.getAttribute('data-weight');
                weightValue.textContent = currentWeight + 'g';
                weightInfo.classList.remove('hidden');
            } else {
                weightInfo.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
