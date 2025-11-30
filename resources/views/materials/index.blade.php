<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Materiais</title>
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
            <a href="{{ route('materials.index') }}" class="px-4 py-2 bg-[#B2675E] rounded transition-colors">
                Meus Materiais
            </a>
            <a href="{{ route('drafts.index') }}" class="px-4 py-2 bg-[#6F7C12] rounded hover:bg-[#5a6510] transition-colors">
                Meus Rascunhos
            </a>
            <a href="{{ route('patterns.index') }}" class="px-4 py-2 bg-[#6F7C12] rounded hover:bg-[#5a6510] transition-colors">
                Meus Patterns
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
            <div class="bg-white p-8 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold text-gray-800">Meus Materiais</h1>
                    <a href="{{ route('materials.create') }}" class="px-4 py-2 bg-[#B2675E] text-white rounded hover:bg-[#644536] transition-colors font-bold">
                        + Novo Material
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-5">
                        {{ session('success') }}
                    </div>
                @endif

                @if($materials->isEmpty())
                    <div class="text-center py-12">
                        <div class="text-gray-400 text-6xl mb-4">📦</div>
                        <p class="text-gray-600 text-lg mb-4">Você ainda não cadastrou nenhum material.</p>
                        <a href="{{ route('materials.create') }}" class="px-6 py-3 bg-[#B2675E] text-white rounded hover:bg-[#644536] transition-colors font-bold inline-block">
                            Cadastrar Primeiro Material
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($materials as $material)
                            <div class="border-2 border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="text-xl font-bold text-gray-800">{{ $material->name }}</h3>
                                    <div class="flex gap-2">
                                        <a href="{{ route('materials.show', $material) }}" class="text-blue-600 hover:text-blue-800" title="Visualizar">
                                            👁️
                                        </a>
                                        <a href="{{ route('materials.edit', $material) }}" class="text-yellow-600 hover:text-yellow-800" title="Editar">
                                            ✏️
                                        </a>
                                        <form action="{{ route('materials.destroy', $material) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este material?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" title="Excluir">
                                                🗑️
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                @if($material->brand)
                                    <p class="text-gray-600 mb-2"><strong>Marca:</strong> {{ $material->brand }}</p>
                                @endif

                                @if($material->composition)
                                    <p class="text-gray-600 mb-2"><strong>Composição:</strong> {{ $material->composition }}</p>
                                @endif

                                @if($material->fixed_weight)
                                    <p class="text-gray-600 mb-4"><strong>Peso:</strong> {{ $material->fixed_weight }}g</p>
                                @endif

                                <div class="border-t pt-4 mt-4">
                                    <p class="text-sm text-gray-500 mb-2">
                                        <strong>Variações:</strong> {{ $material->variations->count() }}
                                    </p>

                                    @if($material->variations->count() > 0)
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($material->variations->take(5) as $variation)
                                                <span class="px-2 py-1 text-xs bg-gray-200 rounded">
                                                    {{ $variation->color }}
                                                    @if($variation->color_code)
                                                        ({{ $variation->color_code }})
                                                    @endif
                                                </span>
                                            @endforeach
                                            @if($material->variations->count() > 5)
                                                <span class="px-2 py-1 text-xs bg-gray-300 rounded font-bold">
                                                    +{{ $material->variations->count() - 5 }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
