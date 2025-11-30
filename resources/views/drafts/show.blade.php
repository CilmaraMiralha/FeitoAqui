<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $draft->title }}</title>
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
        <div class="max-w-5xl mx-auto">
            <div class="mb-4">
                <a href="{{ route('drafts.index') }}" class="text-[#644536] hover:text-[#B2675E] font-bold">
                    ← Voltar para Meus Rascunhos
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

            <div class="bg-white p-8 rounded-lg shadow-lg">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $draft->title }}</h1>
                        <div class="text-sm text-gray-500">
                            <p>Criado em: {{ $draft->created_at->format('d/m/Y H:i') }}</p>
                            <p>Última atualização: {{ $draft->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg font-bold text-sm">
                        RASCUNHO
                    </span>
                </div>

                <div class="border-t border-gray-200 pt-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-700 mb-4">Conteúdo</h2>
                    @if($draft->content)
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <pre class="whitespace-pre-wrap font-mono text-sm text-gray-800">{{ $draft->content }}</pre>
                        </div>
                    @else
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 text-center">
                            <p class="text-gray-400 italic">Este rascunho ainda não possui conteúdo.</p>
                        </div>
                    @endif
                </div>

                <div style="display: flex; gap: 12px; padding-top: 24px; border-top: 1px solid #e5e7eb;">
                    <a href="{{ route('drafts.edit', $draft) }}"
                        style="flex: 1; text-align: center; padding: 12px; background-color: #6F7C12; color: white; border-radius: 8px; font-weight: bold; text-decoration: none;">
                        Editar Rascunho
                    </a>
                    <form action="{{ route('drafts.destroy', $draft) }}" method="POST" style="flex: 1;"
                        onsubmit="return confirm('Tem certeza que deseja excluir este rascunho? Esta ação não pode ser desfeita.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            style="width: 100%; padding: 12px; background-color: #dc2626; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 16px;">
                            Excluir Rascunho
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
