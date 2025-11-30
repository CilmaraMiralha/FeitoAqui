<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Material</title>
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
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Cadastrar Material</h1>

            <form action="{{ route('materials.store') }}" method="POST">
                @csrf

                <div class="mb-5">
                    <label for="name" class="block mb-2 text-gray-700 font-bold">
                        Nome do Material <span class="text-red-600">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors"
                        placeholder="Ex: Lã, Linha, Agulha..." required>
                    @error('name')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="brand" class="block mb-2 text-gray-700 font-bold">Marca</label>
                    <input type="text" id="brand" name="brand" value="{{ old('brand') }}"
                        class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors"
                        placeholder="Ex: Círculo, Pingouin, Barroco...">
                    @error('brand')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="composition" class="block mb-2 text-gray-700 font-bold">Composição</label>
                    <textarea id="composition" name="composition" rows="3"
                        class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors"
                        placeholder="Ex: 100% algodão, 50% acrílico 50% lã...">{{ old('composition') }}</textarea>
                    @error('composition')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="fixed_weight" class="block mb-2 text-gray-700 font-bold">Peso Fixo (gramas)</label>
                    <input type="number" id="fixed_weight" name="fixed_weight" value="{{ old('fixed_weight') }}"
                        step="0.01" min="0"
                        class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors"
                        placeholder="Ex: 125">
                    <div class="text-gray-600 text-xs mt-1">
                        Peso padrão do novelo/embalagem. <strong>Necessário para calcular status de estoque das variações.</strong>
                    </div>
                    @error('fixed_weight')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-5">
                    <p class="text-sm text-blue-700">
                        <strong>💡 Dica:</strong> Após cadastrar o material, você poderá adicionar variações (cores, códigos, quantidades em estoque).
                    </p>
                </div>

                <div class="flex gap-3 mt-8">
                    <a href="{{ route('materials.index') }}"
                        class="flex-1 text-center py-3 bg-gray-600 text-white rounded-lg font-bold hover:bg-gray-700 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="flex-1 py-3 bg-[#B2675E] text-white rounded-lg font-bold hover:bg-[#644536] transition-colors">
                        Cadastrar Material
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
