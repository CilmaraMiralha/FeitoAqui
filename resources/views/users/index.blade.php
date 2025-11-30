<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#F2F5EA]">
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
            <a href="{{ route('users.show') }}" class="px-4 py-2 bg-[#6F7C12] rounded hover:bg-[#5a6510] transition-colors">
                Lista de Usuários
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

    <div class="max-w-7xl mx-auto p-5">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Lista de Usuários</h1>
                <a href="{{ route('users.create') }}" class="px-5 py-2 bg-[#B2675E] text-white rounded-lg font-bold hover:bg-[#644536] transition-colors">
                    + Novo Usuário
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-5">
                    {{ session('success') }}
                </div>
            @endif

            @if($users->count() > 0)
                <p class="mb-5 text-gray-700">Total de usuários: <strong>{{ $users->count() }}</strong></p>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-[#B2675E] text-white">
                                <th class="px-4 py-3 text-left font-bold">ID</th>
                                <th class="px-4 py-3 text-left font-bold">Nome</th>
                                <th class="px-4 py-3 text-left font-bold">Sobrenome</th>
                                <th class="px-4 py-3 text-left font-bold">CPF</th>
                                <th class="px-4 py-3 text-left font-bold">Email</th>
                                <th class="px-4 py-3 text-left font-bold">Data de Nascimento</th>
                                <th class="px-4 py-3 text-left font-bold">Redes Sociais</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr class="border-b border-gray-200 hover:bg-[#F2F5EA] transition-colors">
                                    <td class="px-4 py-3">{{ $user->id }}</td>
                                    <td class="px-4 py-3">{{ $user->name }}</td>
                                    <td class="px-4 py-3">{{ $user->lastname }}</td>
                                    <td class="px-4 py-3">{{ $user->cpf }}</td>
                                    <td class="px-4 py-3">{{ $user->email }}</td>
                                    <td class="px-4 py-3">{{ $user->birthDate ? \Carbon\Carbon::parse($user->birthDate)->format('d/m/Y') : '-' }}</td>
                                    <td class="px-4 py-3">
                                        @if($user->socialMedia)
                                            <span class="inline-block px-3 py-1 bg-[#D6DBD2] rounded text-sm">{{ $user->socialMedia }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12 text-gray-600">
                    <p class="text-lg">Nenhum usuário cadastrado.</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
