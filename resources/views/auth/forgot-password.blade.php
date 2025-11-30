<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gradient-to-br from-[#B2675E] to-[#644536] min-h-screen">
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
    @else
    <div class="bg-[#644536] text-white px-8 py-4 flex justify-between items-center shadow-md">
        <span class="font-bold text-lg">Sistema de Usuários</span>
        <div class="flex gap-4">
            <a href="{{ route('login') }}" class="px-4 py-2 bg-[#6F7C12] rounded hover:bg-[#5a6510] transition-colors">
                Login
            </a>
            <a href="{{ route('users.create') }}" class="px-4 py-2 bg-[#B2675E] rounded hover:bg-[#9a5850] transition-colors">
                Criar Conta
            </a>
        </div>
    </div>
    @endauth

    <div class="flex items-center justify-center p-5 min-h-[calc(100vh-64px)]">
        <div class="bg-white p-10 rounded-lg shadow-2xl w-full max-w-md">
        <h1 class="text-3xl font-bold text-gray-800 mb-3 text-center">Recuperar Senha</h1>
        <p class="text-center text-gray-600 mb-8 text-sm">Informe seu email para receber o link de recuperação</p>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-5">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label for="email" class="block mb-2 text-gray-700 font-bold">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="w-full px-3 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors"
                    required autofocus>
                @error('email')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="w-full py-3 bg-[#B2675E] text-white rounded-lg font-bold hover:bg-[#644536] transition-colors">
                Enviar Link de Recuperação
            </button>
        </form>

        <div class="mt-5 text-center">
            <a href="{{ route('login') }}" class="text-[#6F7C12] hover:underline text-sm">
                Voltar para o login
            </a>
        </div>
    </div>
    </div>
</body>
</html>
