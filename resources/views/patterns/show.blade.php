<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pattern->name }}</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-[#F2F5EA] min-h-screen">
    <x-header />


    <div class="p-5">
        <div class="max-w-6xl mx-auto">
            <div class="mb-4">
                <a href="{{ route('patterns.index') }}" class="text-[#644536] hover:text-[#B2675E] font-bold">
                    ← Voltar para Minhas Receitas
                </a>
            </div>

            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Galeria de Fotos -->
                @if($pattern->photos && count($pattern->photos) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-6 bg-gray-50">
                    @foreach($pattern->photos as $photo)
                    <img src="{{ asset('storage/' . $photo) }}" alt="{{ $pattern->name }}" class="w-full h-64 object-cover rounded-lg shadow">
                    @endforeach
                </div>
                @endif

                <div class="p-8">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $pattern->name }}</h1>
                            <p class="text-4xl font-bold text-[#B2675E]">R$ {{ number_format($pattern->price, 2, ',', '.') }}</p>
                        </div>
                        <div>
                            @if($pattern->status === 'active')
                            <span style="padding: 8px 16px; background-color: #10b981; color: white; border-radius: 8px; font-weight: 600;">
                                ATIVO
                            </span>
                            @elseif($pattern->status === 'pending')
                            <span style="padding: 8px 16px; background-color: #f59e0b; color: white; border-radius: 8px; font-weight: 600;">
                                AGUARDANDO APROVAÇÃO
                            </span>
                            @else
                            <span style="padding: 8px 16px; background-color: #6b7280; color: white; border-radius: 8px; font-weight: 600;">
                                INATIVO
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6 mb-6">
                        <h2 class="text-xl font-bold text-gray-700 mb-3">Descrição</h2>
                        <p class="text-gray-600 whitespace-pre-wrap">{{ $pattern->description }}</p>
                    </div>

                    @if($pattern->tags && count($pattern->tags) > 0)
                    <div class="border-t border-gray-200 pt-6 mb-6">
                        <h2 class="text-xl font-bold text-gray-700 mb-3">Tags</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach($pattern->tags as $tag)
                            <span class="px-3 py-1 bg-gray-200 text-gray-700 rounded-full text-sm">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($pattern->attachment)
                    <div class="border-t border-gray-200 pt-6 mb-6">
                        <h2 class="text-xl font-bold text-gray-700 mb-3">Arquivo da Receita</h2>
                        <a href="{{ asset('storage/' . $pattern->attachment) }}" target="_blank"
                           class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition-colors">
                            📄 Download PDF
                        </a>
                    </div>
                    @endif

                    @if($pattern->user_id === Auth::id())
                    <div style="display: flex; gap: 12px; padding-top: 24px; border-top: 1px solid #e5e7eb;">
                        <a href="{{ route('patterns.edit', $pattern) }}"
                            style="flex: 1; text-align: center; padding: 12px; background-color: #6F7C12; color: white; border-radius: 8px; font-weight: bold; text-decoration: none;">
                            Editar Receita
                        </a>
                        <form action="{{ route('patterns.destroy', $pattern) }}" method="POST" style="flex: 1;"
                            onsubmit="return confirm('Tem certeza que deseja excluir esta receita? Esta ação não pode ser desfeita.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                style="width: 100%; padding: 12px; background-color: #dc2626; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 16px;">
                                Excluir Receita
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>

</html>
