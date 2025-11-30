<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Nova Receita</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-[#F2F5EA] min-h-screen">
    <x-header />


    <div class="p-5">
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Criar Nova Receita</h1>

            <form action="{{ route('patterns.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-5">
                    <label for="name" class="block mb-2 text-gray-700 font-bold">
                        Nome da Receita <span class="text-red-600">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
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
                        placeholder="Descreva sua receita..." required>{{ old('description') }}</textarea>
                    @error('description')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="price" class="block mb-2 text-gray-700 font-bold">
                        Preço (R$) <span class="text-red-600">*</span>
                    </label>
                    <input type="number" id="price" name="price" value="{{ old('price') }}"
                        step="0.01" min="0"
                        class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors"
                        placeholder="Ex: 25.00" required>
                    @error('price')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="tags" class="block mb-2 text-gray-700 font-bold">Tags</label>
                    <input type="text" id="tags" name="tags" value="{{ old('tags') }}"
                        class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors"
                        placeholder="Ex: amigurumi, unicórnio, bebê (separadas por vírgula)">
                    <p class="text-xs text-gray-500 mt-1">Separe as tags com vírgula</p>
                    @error('tags')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="photos" class="block mb-2 text-gray-700 font-bold">Fotos da Receita</label>
                    <input type="file" id="photos" name="photos[]" multiple accept="image/*"
                        class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors">
                    <p class="text-xs text-gray-500 mt-1">Você pode selecionar múltiplas fotos (máx 2MB cada)</p>
                    @error('photos.*')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="attachment" class="block mb-2 text-gray-700 font-bold">Arquivo PDF da Receita</label>
                    <input type="file" id="attachment" name="attachment" accept=".pdf"
                        class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors">
                    <p class="text-xs text-gray-500 mt-1">Arquivo PDF com a receita completa (máx 10MB)</p>
                    @error('attachment')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-5">
                    <p class="text-sm text-blue-700">
                        <strong>ℹ️ Informação:</strong> Sua receita será enviada para aprovação do administrador antes de ficar disponível para venda.
                    </p>
                </div>

                <div class="flex gap-3 mt-8">
                    <a href="{{ route('patterns.index') }}"
                        class="flex-1 text-center py-3 bg-gray-600 text-white rounded-lg font-bold hover:bg-gray-700 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="flex-1 py-3 bg-[#B2675E] text-white rounded-lg font-bold hover:bg-[#644536] transition-colors">
                        Criar Receita
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
