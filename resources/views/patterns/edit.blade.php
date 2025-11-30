<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Receita - {{ $pattern->name }}</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-[#F2F5EA] min-h-screen">
    <x-header />


    <div class="p-5">
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Editar Receita</h1>
                <a href="{{ route('patterns.show', $pattern) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition-colors">
                    Visualizar
                </a>
            </div>

            <form action="{{ route('patterns.update', $pattern) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <label for="name" class="block mb-2 text-gray-700 font-bold">
                        Nome da Receita <span class="text-red-600">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $pattern->name) }}"
                        class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors"
                        placeholder="Ex: Amigurumi de Unicórnio" required>
                    @error('name')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="description" class="block mb-2 text-gray-700 font-bold">
                        Descrição <span class="text-red-600">*</span>
                    </label>
                    <textarea id="description" name="description" rows="6"
                        class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors"
                        placeholder="Descreva sua receita..." required>{{ old('description', $pattern->description) }}</textarea>
                    @error('description')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="price" class="block mb-2 text-gray-700 font-bold">
                        Preço (R$) <span class="text-red-600">*</span>
                    </label>
                    <input type="number" id="price" name="price" value="{{ old('price', $pattern->price) }}"
                        step="0.01" min="0"
                        class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors"
                        placeholder="Ex: 25.00" required>
                    @error('price')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="tags" class="block mb-2 text-gray-700 font-bold">Tags</label>
                    <input type="text" id="tags" name="tags"
                        value="{{ old('tags', $pattern->tags ? implode(', ', $pattern->tags) : '') }}"
                        class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors"
                        placeholder="Ex: amigurumi, unicórnio, bebê (separadas por vírgula)">
                    <p class="text-xs text-gray-500 mt-1">Separe as tags com vírgula</p>
                    @error('tags')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Fotos Existentes -->
                @if($pattern->photos && count($pattern->photos) > 0)
                <div class="mb-5">
                    <label class="block mb-2 text-gray-700 font-bold">Fotos Atuais (clique no X para remover)</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($pattern->photos as $photo)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $photo) }}" alt="Foto" class="w-full h-32 object-cover rounded-lg border-2 border-gray-200">
                            <label style="position: absolute; top: 8px; right: 8px; background-color: #dc2626; color: white; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 50%; cursor: pointer; font-weight: bold; font-size: 16px; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"
                                   onmouseover="this.style.backgroundColor='#b91c1c'"
                                   onmouseout="this.style.backgroundColor='#dc2626'">
                                <input type="checkbox" name="remove_photos[]" value="{{ $photo }}" style="display: none;" onchange="this.parentElement.parentElement.style.opacity = this.checked ? '0.5' : '1'">
                                ×
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-500 mt-2">As fotos marcadas serão removidas ao salvar</p>
                </div>
                @endif

                <!-- Novas Fotos -->
                <div class="mb-5">
                    <label for="photos" class="block mb-2 text-gray-700 font-bold">Adicionar Novas Fotos</label>
                    <input type="file" id="photos" name="photos[]" multiple accept="image/*"
                        class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors">
                    <p class="text-xs text-gray-500 mt-1">Você pode selecionar múltiplas fotos (máx 2MB cada)</p>
                    @error('photos.*')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- PDF Existente -->
                @if($pattern->attachment)
                <div class="mb-5">
                    <label class="block mb-2 text-gray-700 font-bold">PDF Atual</label>
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                        <a href="{{ asset('storage/' . $pattern->attachment) }}" target="_blank" class="text-blue-600 hover:underline">
                            📄 Ver PDF atual
                        </a>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remove_attachment" value="1" class="form-checkbox">
                            <span class="text-sm text-red-600">Remover PDF</span>
                        </label>
                    </div>
                </div>
                @endif

                <!-- Novo PDF -->
                <div class="mb-5">
                    <label for="attachment" class="block mb-2 text-gray-700 font-bold">
                        @if($pattern->attachment)
                        Substituir Arquivo PDF
                        @else
                        Adicionar Arquivo PDF
                        @endif
                    </label>
                    <input type="file" id="attachment" name="attachment" accept=".pdf"
                        class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors">
                    <p class="text-xs text-gray-500 mt-1">Arquivo PDF com a receita completa (máx 10MB)</p>
                    @error('attachment')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex gap-3 mt-8">
                    <a href="{{ route('patterns.show', $pattern) }}"
                        class="flex-1 text-center py-3 bg-gray-600 text-white rounded-lg font-bold hover:bg-gray-700 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="flex-1 py-3 bg-[#B2675E] text-white rounded-lg font-bold hover:bg-[#644536] transition-colors">
                        Atualizar Receita
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
