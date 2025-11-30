<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $material->name }} - Detalhes</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#F2F5EA] min-h-screen">
    @auth
    <div class="bg-[#644536] text-white px-8 py-4 flex justify-between items-center shadow-md">
        <div class="flex items-center gap-4">
            @if(Auth::user()->photo)
                <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Foto" class="w-10 h-10 rounded-full object-cover">
            @else
                <div class="w-10 h-10 rounded-full bg-[#B2675E] flex items-center justify-center text-white font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif
            <span class="font-semibold">Olá, {{ Auth::user()->name }}</span>
        </div>
        <div class="flex gap-4">
            @if(Auth::user()->is_admin)
                <a href="{{ route('users.show') }}" class="px-4 py-2 bg-[#6F7C12] rounded hover:bg-[#5a6510] transition-colors">
                    Lista de Usuários
                </a>
            @endif
            <a href="{{ route('materials.index') }}" class="px-4 py-2 bg-[#6F7C12] rounded hover:bg-[#5a6510] transition-colors">
                Meus Materiais
            </a>
            <a href="{{ route('drafts.index') }}" class="px-4 py-2 bg-[#6F7C12] rounded hover:bg-[#5a6510] transition-colors">
                Meus Rascunhos
            </a>
            <a href="{{ route('users.edit', Auth::user()) }}" class="px-4 py-2 bg-[#6F7C12] rounded hover:bg-[#5a6510] transition-colors">
                Meu Perfil
            </a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-700 rounded hover:bg-red-800 transition-colors">
                    Sair
                </button>
            </form>
        </div>
    </div>
    @endauth

    <div class="p-5">
        <div class="max-w-6xl mx-auto">
            <!-- Informações do Material -->
            <div class="bg-white p-8 rounded-lg shadow-lg mb-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <a href="{{ route('materials.index') }}" class="text-[#B2675E] hover:underline mb-2 inline-block">
                            ← Voltar para Meus Materiais
                        </a>
                        <h1 class="text-3xl font-bold text-gray-800">{{ $material->name }}</h1>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('materials.edit', $material) }}" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition-colors">
                            Editar Material
                        </a>
                        <form action="{{ route('materials.destroy', $material) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este material? Todas as variações também serão excluídas.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-colors">
                                Excluir Material
                            </button>
                        </form>
                    </div>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-5">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @if($material->brand)
                        <div class="bg-gray-50 p-4 rounded">
                            <p class="text-gray-600 text-sm">Marca</p>
                            <p class="text-gray-800 font-bold">{{ $material->brand }}</p>
                        </div>
                    @endif

                    @if($material->composition)
                        <div class="bg-gray-50 p-4 rounded">
                            <p class="text-gray-600 text-sm">Composição</p>
                            <p class="text-gray-800 font-bold">{{ $material->composition }}</p>
                        </div>
                    @endif

                    @if($material->fixed_weight)
                        <div class="bg-gray-50 p-4 rounded">
                            <p class="text-gray-600 text-sm">Peso Fixo</p>
                            <p class="text-gray-800 font-bold">{{ $material->fixed_weight }}g</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Variações -->
            <div class="bg-white p-8 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Variações</h2>
                    <button onclick="toggleAddVariationForm()" class="px-4 py-2 bg-[#B2675E] text-white rounded hover:bg-[#644536] transition-colors font-bold">
                        + Nova Variação
                    </button>
                </div>

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-5">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Painel de Controle Rápido de Peso -->
                @if($material->variations->count() > 0)
                    <div style="background: #f9fafb; padding: 20px; border-radius: 8px; border: 1px solid #e5e7eb; margin-bottom: 24px;">
                        <h3 style="font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 12px;">Ajuste Rápido de Peso</h3>
                        <form action="{{ route('materials.variations.adjust', $material) }}" method="POST">
                            @csrf
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr>
                                    <td style="padding-right: 10px; width: 40%;">
                                        <select id="variation_id" name="variation_id" required onchange="updateCurrentWeight()" style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 14px;">
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
                                    </td>
                                    <td style="padding-right: 10px; width: 20%;">
                                        <input type="number" id="weight_adjustment" name="weight_adjustment" step="0.01" min="0.01" placeholder="Peso (g)" required style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 14px;">
                                    </td>
                                    <td style="padding-right: 5px; width: 20%;">
                                        <button type="submit" name="action" value="add" style="width: 100%; padding: 8px 16px; background-color: #16a34a; color: white; border: none; border-radius: 4px; font-size: 14px; font-weight: 600; cursor: pointer;">
                                            + Adicionar
                                        </button>
                                    </td>
                                    <td style="width: 20%;">
                                        <button type="submit" name="action" value="remove" style="width: 100%; padding: 8px 16px; background-color: #dc2626; color: white; border: none; border-radius: 4px; font-size: 14px; font-weight: 600; cursor: pointer;">
                                            - Remover
                                        </button>
                                    </td>
                                </tr>
                            </table>
                            <div id="current-weight-info" class="hidden" style="margin-top: 8px; font-size: 12px; color: #4b5563;">
                                Peso atual: <span id="current-weight-value" style="font-weight: 600;">-</span>
                            </div>
                        </form>
                    </div>
                @endif

                <!-- Formulário de Nova Variação (inicialmente oculto) -->
                <div id="addVariationForm" class="hidden mb-6 bg-gray-50 p-6 rounded-lg border-2 border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Adicionar Nova Variação</h3>
                    <form action="{{ route('materials.variations.store', $material) }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="color" class="block mb-2 text-gray-700 font-bold">
                                    Cor <span class="text-red-600">*</span>
                                </label>
                                <input type="text" id="color" name="color" value="{{ old('color') }}"
                                    class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E]"
                                    placeholder="Ex: Azul marinho" required>
                            </div>

                            <div>
                                <label for="color_code" class="block mb-2 text-gray-700 font-bold">Código da Cor</label>
                                <input type="text" id="color_code" name="color_code" value="{{ old('color_code') }}"
                                    class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E]"
                                    placeholder="Ex: 1234, 5678">
                                <div class="text-gray-600 text-xs mt-1">Código da embalagem</div>
                            </div>

                            <div>
                                <label for="weight" class="block mb-2 text-gray-700 font-bold">
                                    Peso (gramas) <span class="text-red-600">*</span>
                                </label>
                                <input type="number" id="weight" name="weight" value="{{ old('weight') }}"
                                    step="0.01" min="0"
                                    class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E]"
                                    placeholder="100" required>
                            </div>
                        </div>

                        <div class="flex gap-3 mt-4">
                            <button type="button" onclick="toggleAddVariationForm()" class="flex-1 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                                Cancelar
                            </button>
                            <button type="submit" class="flex-1 py-2 bg-[#B2675E] text-white rounded-lg hover:bg-[#644536]">
                                Adicionar Variação
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Lista de Variações -->
                @if(!$material->fixed_weight)
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                        <p class="text-sm text-yellow-700">
                            <strong>⚠️ Atenção:</strong> Cadastre o peso fixo do material para que o sistema possa calcular automaticamente o status de estoque das variações.
                            <a href="{{ route('materials.edit', $material) }}" class="underline font-bold">Adicionar peso fixo</a>
                        </p>
                    </div>
                @endif

                @if($material->variations->isEmpty())
                    <div class="text-center py-12">
                        <div class="text-gray-400 text-6xl mb-4">🎨</div>
                        <p class="text-gray-600 text-lg">Nenhuma variação cadastrada ainda.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-3 text-left">Cor</th>
                                    <th class="px-4 py-3 text-left">Código</th>
                                    <th class="px-4 py-3 text-left">Peso (g)</th>
                                    <th class="px-4 py-3 text-left">Status</th>
                                    <th class="px-4 py-3 text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($material->variations as $variation)
                                    <tr class="border-b hover:bg-gray-50" id="variation-{{ $variation->id }}">
                                        <td class="px-4 py-3">
                                            <span class="font-semibold">{{ $variation->color }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($variation->color_code)
                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">{{ $variation->color_code }}</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <div>
                                                <span class="font-bold">{{ $variation->weight }}g</span>
                                                @if($variation->percentage !== null)
                                                    <span class="text-sm text-gray-500">
                                                        ({{ number_format($variation->percentage, 1) }}%)
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 {{ $variation->status['bg'] }} {{ $variation->status['text'] }} text-xs rounded font-semibold">
                                                {{ $variation->status['label'] }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <button onclick="editVariation({{ $variation->id }}, '{{ $variation->color }}', '{{ $variation->color_code }}', '{{ $variation->weight }}')"
                                                    class="text-yellow-600 hover:text-yellow-800 mr-2" title="Editar">
                                                ✏️
                                            </button>
                                            <form action="{{ route('materials.variations.destroy', [$material, $variation]) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta variação?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800" title="Excluir">
                                                    🗑️
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <!-- Formulário de Edição (oculto) -->
                                    <tr id="edit-form-{{ $variation->id }}" class="hidden bg-gray-50">
                                        <td colspan="5" class="px-4 py-4">
                                            <form action="{{ route('materials.variations.update', [$material, $variation]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                    <div>
                                                        <label class="block mb-1 text-sm font-bold">Cor</label>
                                                        <input type="text" name="color" value="{{ $variation->color }}"
                                                            class="w-full px-3 py-2 border-2 rounded-lg" required>
                                                    </div>
                                                    <div>
                                                        <label class="block mb-1 text-sm font-bold">Código</label>
                                                        <input type="text" name="color_code" value="{{ $variation->color_code }}"
                                                            class="w-full px-3 py-2 border-2 rounded-lg"
                                                            placeholder="Ex: 1234">
                                                    </div>
                                                    <div>
                                                        <label class="block mb-1 text-sm font-bold">Peso (g)</label>
                                                        <input type="number" name="weight" value="{{ $variation->weight }}"
                                                            step="0.01" min="0" class="w-full px-3 py-2 border-2 rounded-lg" required>
                                                    </div>
                                                </div>
                                                <div class="flex gap-3 mt-4">
                                                    <button type="button" onclick="cancelEdit({{ $variation->id }})"
                                                            class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                                                        Cancelar
                                                    </button>
                                                    <button type="submit" class="px-4 py-2 bg-[#B2675E] text-white rounded hover:bg-[#644536]">
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
    </div>

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
