<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
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

    <div class="p-5">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Cadastro de Usuário</h1>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label for="name" class="block mb-2 text-gray-700 font-bold">
                    Nome <span class="text-red-600">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors"
                    required>
                @error('name')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-5">
                <label for="lastname" class="block mb-2 text-gray-700 font-bold">
                    Sobrenome <span class="text-red-600">*</span>
                </label>
                <input type="text" id="lastname" name="lastname" value="{{ old('lastname') }}"
                    class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors"
                    required>
                @error('lastname')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-5">
                <label for="cpf" class="block mb-2 text-gray-700 font-bold">
                    CPF <span class="text-red-600">*</span>
                </label>
                <input type="text" id="cpf" name="cpf" value="{{ old('cpf') }}"
                    class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors"
                    placeholder="000.000.000-00" maxlength="14" required>
                <div class="text-gray-600 text-xs mt-1">Formato: 000.000.000-00</div>
                @error('cpf')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-5">
                <label for="email" class="block mb-2 text-gray-700 font-bold">
                    Email <span class="text-red-600">*</span>
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors"
                    required>
                @error('email')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-5">
                <label for="birthDate" class="block mb-2 text-gray-700 font-bold">
                    Data de Nascimento <span class="text-red-600">*</span>
                </label>
                <input type="date" id="birthDate" name="birthDate" value="{{ old('birthDate') }}"
                    class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors"
                    required>
                @error('birthDate')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-5">
                <label for="password" class="block mb-2 text-gray-700 font-bold">
                    Senha <span class="text-red-600">*</span>
                </label>
                <input type="password" id="password" name="password"
                    class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors"
                    required>
                <div class="text-gray-600 text-xs mt-1">Mínimo de 8 caracteres</div>
                @error('password')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-5">
                <label for="password_confirmation" class="block mb-2 text-gray-700 font-bold">
                    Confirmar Senha <span class="text-red-600">*</span>
                </label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors"
                    required>
            </div>

            <div class="mb-5">
                <label for="socialMedia" class="block mb-2 text-gray-700 font-bold">Redes Sociais</label>
                <input type="text" id="socialMedia" name="socialMedia" value="{{ old('socialMedia') }}"
                    class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors"
                    placeholder="@usuario">
                @error('socialMedia')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex gap-3 mt-8">
                <a href="{{ route('users.show') }}"
                    class="flex-1 text-center py-3 bg-gray-600 text-white rounded-lg font-bold hover:bg-gray-700 transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                    class="flex-1 py-3 bg-[#B2675E] text-white rounded-lg font-bold hover:bg-[#644536] transition-colors">
                    Cadastrar
                </button>
            </div>
        </form>
    </div>

    <script>
        // Máscara para CPF
        document.getElementById('cpf').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                e.target.value = value;
            }
        });
    </script>
    </div>
</body>
</html>
