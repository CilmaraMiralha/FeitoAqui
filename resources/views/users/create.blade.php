<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário - FeitoAqui</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')

    <style>
        :root {
            --coffee: #644536;
            --terracotta: #B2675E;
            --ivory: #F2F5EA;
            --dust: #D6DBD2;
            --olive: #6F7C12;
        }

        body {
            background-color: #FAFAF5;
            color: var(--coffee);
            line-height: 1.7;
        }

        .btn-primary {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(178, 103, 94, 0.3);
        }
    </style>
</head>

<body class="min-h-screen flex flex-col text-slate-600 antialiased">
    <x-header />

    <main class="flex-grow py-12 lg:py-20">
        <div class="max-w-4xl mx-auto px-6 sm:px-8 lg:px-12">
            <div class="mb-10">
                <h1 class="text-3xl lg:text-4xl font-serif font-bold text-[var(--coffee)] mb-3">Criar Conta</h1>
                <p class="text-slate-500 font-light leading-relaxed">Junte-se à nossa comunidade criativa e comece sua jornada.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 p-8 lg:p-12">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <!-- Informações Pessoais -->
                    <div class="mb-10">
                        <h2 class="text-xs font-bold uppercase tracking-wider text-[var(--coffee)] mb-6 pb-3 border-b border-slate-100">
                            Informações Pessoais
                        </h2>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-[var(--coffee)] mb-2">
                                    Nome <span class="text-[var(--terracotta)]">*</span>
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[var(--terracotta)]/20 focus:border-[var(--terracotta)] transition-all"
                                    required>
                                @error('name')
                                    <div class="text-[var(--terracotta)] text-sm mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="lastname" class="block text-xs font-bold uppercase tracking-wider text-[var(--coffee)] mb-2">
                                    Sobrenome <span class="text-[var(--terracotta)]">*</span>
                                </label>
                                <input type="text" id="lastname" name="lastname" value="{{ old('lastname') }}"
                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[var(--terracotta)]/20 focus:border-[var(--terracotta)] transition-all"
                                    required>
                                @error('lastname')
                                    <div class="text-[var(--terracotta)] text-sm mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="cpf" class="block text-xs font-bold uppercase tracking-wider text-[var(--coffee)] mb-2">
                                    CPF <span class="text-[var(--terracotta)]">*</span>
                                </label>
                                <input type="text" id="cpf" name="cpf" value="{{ old('cpf') }}"
                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[var(--terracotta)]/20 focus:border-[var(--terracotta)] transition-all"
                                    placeholder="000.000.000-00" maxlength="14" required>
                                <div class="text-slate-400 text-xs mt-1.5">Formato: 000.000.000-00</div>
                                @error('cpf')
                                    <div class="text-[var(--terracotta)] text-sm mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="birthDate" class="block text-xs font-bold uppercase tracking-wider text-[var(--coffee)] mb-2">
                                    Data de Nascimento <span class="text-[var(--terracotta)]">*</span>
                                </label>
                                <input type="date" id="birthDate" name="birthDate" value="{{ old('birthDate') }}"
                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[var(--terracotta)]/20 focus:border-[var(--terracotta)] transition-all"
                                    required>
                                @error('birthDate')
                                    <div class="text-[var(--terracotta)] text-sm mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="lg:col-span-2">
                                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-[var(--coffee)] mb-2">
                                    Email <span class="text-[var(--terracotta)]">*</span>
                                </label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[var(--terracotta)]/20 focus:border-[var(--terracotta)] transition-all"
                                    required>
                                @error('email')
                                    <div class="text-[var(--terracotta)] text-sm mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-[var(--coffee)] mb-2">
                                    Senha <span class="text-[var(--terracotta)]">*</span>
                                </label>
                                <input type="password" id="password" name="password"
                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[var(--terracotta)]/20 focus:border-[var(--terracotta)] transition-all"
                                    required>
                                <div class="text-slate-400 text-xs mt-1.5">Mínimo de 8 caracteres</div>
                                @error('password')
                                    <div class="text-[var(--terracotta)] text-sm mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-[var(--coffee)] mb-2">
                                    Confirmar Senha <span class="text-[var(--terracotta)]">*</span>
                                </label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[var(--terracotta)]/20 focus:border-[var(--terracotta)] transition-all"
                                    required>
                            </div>

                            <div class="lg:col-span-2">
                                <label for="socialMedia" class="block text-xs font-bold uppercase tracking-wider text-[var(--coffee)] mb-2">
                                    Redes Sociais
                                </label>
                                <input type="text" id="socialMedia" name="socialMedia" value="{{ old('socialMedia') }}"
                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[var(--terracotta)]/20 focus:border-[var(--terracotta)] transition-all"
                                    placeholder="@usuario">
                                @error('socialMedia')
                                    <div class="text-[var(--terracotta)] text-sm mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Dados de Vendedor -->
                    <div class="pt-10 border-t border-slate-100">
                        <h2 class="text-xs font-bold uppercase tracking-wider text-[var(--coffee)] mb-6">
                            Dados de Vendedor
                        </h2>

                        <div class="mb-6">
                            <label class="flex items-center cursor-pointer group">
                                <div class="relative">
                                    <input type="checkbox" id="is_seller" name="is_seller" value="1"
                                        {{ old('is_seller') ? 'checked' : '' }}
                                        class="w-5 h-5 text-[var(--terracotta)] border-slate-300 rounded focus:ring-2 focus:ring-[var(--terracotta)]/20 transition-all">
                                </div>
                                <span class="ml-3 text-sm font-medium text-slate-600 group-hover:text-[var(--coffee)] transition-colors">
                                    Quero vender minhas receitas na plataforma
                                </span>
                            </label>
                        </div>

                        <div id="seller_fields" style="display: {{ old('is_seller') ? 'block' : 'none' }};" class="space-y-6">
                            <div>
                                <label for="store_name" class="block text-xs font-bold uppercase tracking-wider text-[var(--coffee)] mb-2">
                                    Nome da Loja <span class="text-[var(--terracotta)]">*</span>
                                </label>
                                <input type="text" id="store_name" name="store_name" value="{{ old('store_name') }}"
                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[var(--terracotta)]/20 focus:border-[var(--terracotta)] transition-all"
                                    placeholder="Digite um nome único para sua loja">
                                <div class="text-slate-400 text-xs mt-1.5">Evite nomes genéricos como "Loja de Receitas" ou "Receitas de Amigurumi"</div>
                                @error('store_name')
                                    <div class="text-[var(--terracotta)] text-sm mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="cnpj" class="block text-xs font-bold uppercase tracking-wider text-[var(--coffee)] mb-2">
                                    CNPJ
                                </label>
                                <input type="text" id="cnpj" name="cnpj" value="{{ old('cnpj') }}"
                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[var(--terracotta)]/20 focus:border-[var(--terracotta)] transition-all"
                                    placeholder="00.000.000/0000-00" maxlength="18">
                                <div class="text-slate-400 text-xs mt-1.5">Formato: 00.000.000/0000-00 (opcional)</div>
                                @error('cnpj')
                                    <div class="text-[var(--terracotta)] text-sm mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Botões -->
                    <div class="flex flex-col sm:flex-row gap-4 mt-10 pt-8 border-t border-slate-100">
                        <a href="{{ route('users.show') }}"
                            class="flex-1 text-center py-3.5 px-6 bg-white border-2 border-slate-200 text-[var(--coffee)] rounded-xl font-semibold hover:border-[var(--coffee)] hover:bg-slate-50 transition-all">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="flex-1 py-3.5 px-6 bg-gradient-to-r from-[var(--terracotta)] to-[var(--coffee)] text-white rounded-xl font-semibold btn-primary shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)]">
                            Criar Conta
                        </button>
                    </div>
                </form>
            </div>

            <div class="mt-8 text-center">
                <p class="text-slate-500 text-sm">
                    Já tem uma conta?
                    <a href="{{ route('login') }}" class="text-[var(--terracotta)] hover:text-[var(--coffee)] font-semibold transition-colors">
                        Faça login aqui
                    </a>
                </p>
            </div>
        </div>
    </main>

    <x-footer />

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
    </script>
</body>

</html>
