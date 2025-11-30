<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Rascunho</title>
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
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Criar Novo Rascunho</h1>

            <form action="{{ route('drafts.store') }}" method="POST">
                @csrf

                <div class="mb-5">
                    <label for="title" class="block mb-2 text-gray-700 font-bold">
                        Título <span class="text-red-600">*</span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}"
                        class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors"
                        placeholder="Ex: Amigurumi de Unicórnio, Manta de Bebê..." required>
                    @error('title')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="content" class="block mb-2 text-gray-700 font-bold">Conteúdo</label>
                    <textarea id="content" name="content" rows="15"
                        class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors font-mono text-sm"
                        placeholder="Escreva aqui o conteúdo do seu pattern...&#10;&#10;Materiais:&#10;- Linha X&#10;- Agulha Y&#10;&#10;Instruções:&#10;1. Fazer anel mágico...&#10;2. ...">{{ old('content') }}</textarea>
                    @error('content')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex gap-3 mt-8">
                    <a href="{{ route('drafts.index') }}"
                        class="flex-1 text-center py-3 bg-gray-600 text-white rounded-lg font-bold hover:bg-gray-700 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="flex-1 py-3 bg-[#B2675E] text-white rounded-lg font-bold hover:bg-[#644536] transition-colors">
                        Salvar Rascunho
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>