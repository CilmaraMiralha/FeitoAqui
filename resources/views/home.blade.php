<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FeitoAqui - Receitas de Artesanato</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-[#F2F5EA] min-h-screen">
    <x-header />

    <div class="p-5">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8 text-center">
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Receitas de Artesanato</h1>
                <p class="text-gray-600">Encontre as melhores receitas para seus projetos de crochê, tricô e amigurumi</p>
            </div>

            @if($patterns->isEmpty())
            <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                <div class="text-6xl mb-4">🧶</div>
                <h2 class="text-2xl font-bold text-gray-700 mb-2">Nenhuma receita disponível ainda</h2>
                <p class="text-gray-600">Em breve teremos receitas incríveis para você!</p>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($patterns as $pattern)
                <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow overflow-hidden">
                    @if($pattern->photos && count($pattern->photos) > 0)
                    <img src="{{ asset('storage/' . $pattern->photos[0]) }}" alt="{{ $pattern->name }}" class="w-full h-48 object-cover">
                    @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-400 text-4xl">🧶</span>
                    </div>
                    @endif

                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">{{ $pattern->name }}</h3>

                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ Str::limit($pattern->description, 80) }}</p>

                        @if($pattern->tags && count($pattern->tags) > 0)
                        <div class="flex flex-wrap gap-1 mb-3">
                            @foreach(array_slice($pattern->tags, 0, 3) as $tag)
                            <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">{{ $tag }}</span>
                            @endforeach
                            @if(count($pattern->tags) > 3)
                            <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">+{{ count($pattern->tags) - 3 }}</span>
                            @endif
                        </div>
                        @endif

                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <p class="text-2xl font-bold text-[#B2675E]">R$ {{ number_format($pattern->price, 2, ',', '.') }}</p>
                            </div>
                            <div class="text-xs text-gray-500">
                                por {{ $pattern->user->store_name ?? $pattern->user->name }}
                            </div>
                        </div>

                        <a href="{{ route('patterns.show', $pattern) }}" style="display: block; text-align: center; padding: 10px; background-color: #B2675E; color: white; border-radius: 8px; font-weight: bold; text-decoration: none; font-size: 14px;">
                            Ver Detalhes
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</body>

</html>
