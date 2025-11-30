<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Receitas</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-[#F2F5EA] min-h-screen">
    <x-header />


    <div class="p-5">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Minhas Receitas</h1>
                <a href="{{ route('patterns.create') }}" class="px-6 py-3 bg-[#B2675E] text-white rounded-lg font-bold hover:bg-[#644536] transition-colors shadow-md">
                    + Nova Receita
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

            @if($patterns->isEmpty())
            <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                <h2 class="text-2xl font-bold text-gray-700 mb-2">Nenhuma receita ainda</h2>
                <p class="text-gray-600 mb-6">Comece criando sua primeira receita para vender!</p>
                <a href="{{ route('patterns.create') }}" class="inline-block px-6 py-3 bg-[#B2675E] text-white rounded-lg font-bold hover:bg-[#644536] transition-colors my-4">
                    Criar Primeira Receita
                </a>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($patterns as $pattern)
                <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow overflow-hidden">
                    @if($pattern->photos && count($pattern->photos) > 0)
                    <img src="{{ asset('storage/' . $pattern->photos[0]) }}" alt="{{ $pattern->name }}" class="w-full h-48 object-cover">
                    @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-400 text-4xl">📄</span>
                    </div>
                    @endif

                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-bold text-gray-800 flex-1">{{ $pattern->name }}</h3>
                        </div>

                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ Str::limit($pattern->description, 100) }}</p>

                        <div class="mb-4">
                            <p class="text-2xl font-bold text-[#B2675E]">R$ {{ number_format($pattern->price, 2, ',', '.') }}</p>
                        </div>

                        <div class="mb-4">
                            @if($pattern->status === 'active')
                            <span style="padding: 4px 12px; background-color: #10b981; color: white; border-radius: 4px; font-size: 12px; font-weight: 600;">
                                ATIVO
                            </span>
                            @elseif($pattern->status === 'pending')
                            <span style="padding: 4px 12px; background-color: #f59e0b; color: white; border-radius: 4px; font-size: 12px; font-weight: 600;">
                                AGUARDANDO APROVAÇÃO
                            </span>
                            @else
                            <span style="padding: 4px 12px; background-color: #6b7280; color: white; border-radius: 4px; font-size: 12px; font-weight: 600;">
                                INATIVO
                            </span>
                            @endif
                        </div>

                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('patterns.show', $pattern) }}" style="flex: 1; text-align: center; padding: 8px; background-color: #2563eb; color: white; border-radius: 8px; font-weight: bold; text-decoration: none; font-size: 14px;">
                                Ver
                            </a>
                            <a href="{{ route('patterns.edit', $pattern) }}" style="flex: 1; text-align: center; padding: 8px; background-color: #6F7C12; color: white; border-radius: 8px; font-weight: bold; text-decoration: none; font-size: 14px;">
                                Editar
                            </a>
                            <form action="{{ route('patterns.destroy', $pattern) }}" method="POST" style="flex: 1; margin: 0;" onsubmit="return confirm('Tem certeza que deseja excluir este pattern?')">
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
