<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Rascunhos</title>
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
            <a href="{{ route('drafts.index') }}" class="px-4 py-2 bg-[#B2675E] rounded transition-colors">
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
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Meus Rascunhos</h1>
                <a href="{{ route('drafts.create') }}" class="px-6 py-3 bg-[#B2675E] text-white rounded-lg font-bold hover:bg-[#644536] transition-colors shadow-md">
                    + Novo Rascunho
                </a>
            </div>

            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                {{ session('error') }}
            </div>
            @endif

            @if($drafts->isEmpty())
            <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                <h2 class="text-2xl font-bold text-gray-700 mb-2">Nenhum rascunho ainda</h2>
                <p class="text-gray-600 mb-6">Comece criando seu primeiro rascunho de pattern!</p>
                <a href="{{ route('drafts.create') }}" class="inline-block px-6 py-3 bg-[#B2675E] text-white rounded-lg font-bold hover:bg-[#644536] transition-colors my-4">
                    Criar Primeiro Rascunho
                </a>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($drafts as $draft)
                <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-bold text-gray-800 flex-1">{{ $draft->title }}</h3>
                        </div>

                        <div class="mb-4">
                            @if($draft->content)
                            <p class="text-gray-600 line-clamp-3">
                                {{ Str::limit(strip_tags($draft->content), 150) }}
                            </p>
                            @else
                            <p class="text-gray-400 italic">Sem conteúdo ainda...</p>
                            @endif
                        </div>

                        <div class="text-sm text-gray-500 mb-4">
                            <p>Atualizado em: {{ $draft->updated_at->format('d/m/Y H:i') }}</p>
                        </div>

                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('drafts.show', $draft) }}" style="flex: 1; text-align: center; padding: 8px; background-color: #2563eb; color: white; border-radius: 8px; font-weight: bold; text-decoration: none; font-size: 14px;">
                                Visualizar
                            </a>
                            <a href="{{ route('drafts.edit', $draft) }}" style="flex: 1; text-align: center; padding: 8px; background-color: #6F7C12; color: white; border-radius: 8px; font-weight: bold; text-decoration: none; font-size: 14px;">
                                Editar
                            </a>
                            <form action="{{ route('drafts.destroy', $draft) }}" method="POST" style="flex: 1; margin: 0;" onsubmit="return confirm('Tem certeza que deseja excluir este rascunho?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="width: 100%; padding: 8px; background-color: #dc2626; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 14px;">
                                    Excluir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</body>

</html>