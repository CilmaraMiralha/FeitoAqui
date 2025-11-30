<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#F2F5EA] min-h-screen">
    <x-header />
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
    @endauth

    <div class="p-5">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Editar Perfil</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-5">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="text-center mb-8">
                @if($user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto de perfil"
                        class="w-36 h-36 rounded-full object-cover mx-auto mb-4 border-4 border-[#B2675E]">
                @else
                    <div class="w-36 h-36 rounded-full bg-[#D6DBD2] flex items-center justify-center mx-auto mb-4 text-5xl text-gray-600 border-4 border-gray-300">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
            </div>

            <div class="mb-5">
                <label for="photo" class="block mb-2 text-gray-700 font-bold">Foto de Perfil</label>
                <input type="file" id="photo" name="photo" accept="image/*"
                    class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors">
                <div class="text-gray-600 text-xs mt-1">Formatos: JPG, PNG, GIF (máx. 2MB)</div>
                @error('photo')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-5">
                <label for="name" class="block mb-2 text-gray-700 font-bold">
                    Nome <span class="text-red-600">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
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
                <input type="text" id="lastname" name="lastname" value="{{ old('lastname', $user->lastname) }}"
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
                <input type="text" id="cpf" name="cpf" value="{{ old('cpf', $user->cpf) }}"
                    class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors"
                    placeholder="000.000.000-00" maxlength="14" required>
                @error('cpf')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-5">
                <label for="email" class="block mb-2 text-gray-700 font-bold">
                    Email <span class="text-red-600">*</span>
                </label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
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
                <input type="date" id="birthDate" name="birthDate" value="{{ old('birthDate', $user->birthDate) }}"
                    class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors"
                    required>
                @error('birthDate')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-5">
                <label for="socialMedia" class="block mb-2 text-gray-700 font-bold">Redes Sociais</label>
                <input type="text" id="socialMedia" name="socialMedia" value="{{ old('socialMedia', $user->socialMedia) }}"
                    class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors"
                    placeholder="@usuario">
                @error('socialMedia')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="border-t-2 border-gray-200 pt-6 mt-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Dados de Vendedor</h2>

                <div class="mb-5">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" id="is_seller" name="is_seller" value="1"
                            {{ old('is_seller', $user->is_seller) ? 'checked' : '' }}
                            class="w-5 h-5 text-[#B2675E] border-gray-300 rounded focus:ring-[#B2675E]">
                        <span class="ml-2 text-gray-700 font-bold">Sou um vendedor</span>
                    </label>
                </div>

                <div id="seller_fields" style="display: {{ old('is_seller', $user->is_seller) ? 'block' : 'none' }};">
                    <div class="mb-5">
                        <label for="store_name" class="block mb-2 text-gray-700 font-bold">
                            Nome da Loja <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="store_name" name="store_name" value="{{ old('store_name', $user->store_name) }}"
                            class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors"
                            placeholder="Digite um nome único para sua loja">
                        <div class="text-gray-600 text-xs mt-1">Evite nomes genéricos como "Loja de Receitas" ou "Receitas de Amigurumi"</div>
                        @error('store_name')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="cnpj" class="block mb-2 text-gray-700 font-bold">CNPJ</label>
                        <input type="text" id="cnpj" name="cnpj" value="{{ old('cnpj', $user->cnpj) }}"
                            class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#B2675E] transition-colors"
                            placeholder="00.000.000/0000-00" maxlength="18">
                        <div class="text-gray-600 text-xs mt-1">Formato: 00.000.000/0000-00 (opcional)</div>
                        @error('cnpj')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex gap-3 mt-8">
                <a href="{{ route('users.show') }}"
                    class="flex-1 text-center py-3 bg-gray-600 text-white rounded-lg font-bold hover:bg-gray-700 transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                    class="flex-1 py-3 bg-[#B2675E] text-white rounded-lg font-bold hover:bg-[#644536] transition-colors">
                    Salvar Alterações
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

        // Máscara para CNPJ
        document.getElementById('cnpj').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 14) {
                value = value.replace(/^(\d{2})(\d)/, '$1.$2');
                value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
                value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
                value = value.replace(/(\d{4})(\d)/, '$1-$2');
                e.target.value = value;
            }
        });

        // Toggle para mostrar/ocultar campos de vendedor
        document.getElementById('is_seller').addEventListener('change', function(e) {
            const sellerFields = document.getElementById('seller_fields');
            if (e.target.checked) {
                sellerFields.style.display = 'block';
            } else {
                sellerFields.style.display = 'none';
                document.getElementById('store_name').value = '';
                document.getElementById('cnpj').value = '';
            }
        });

        // Preview da foto
        document.getElementById('photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.querySelector('.w-36.h-36');
                    if (preview.tagName === 'IMG') {
                        preview.src = e.target.result;
                    } else {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'w-36 h-36 rounded-full object-cover mx-auto mb-4 border-4 border-[#B2675E]';
                        preview.parentNode.replaceChild(img, preview);
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
    </div>
</body>
</html>
