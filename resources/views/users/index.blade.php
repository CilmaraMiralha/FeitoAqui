<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#F2F5EA]">
    <x-header />

    

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
