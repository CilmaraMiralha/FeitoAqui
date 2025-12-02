<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar - FeitoAqui</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex flex-col bg-[#FAFAF5] antialiased">
    <x-header />

    <main class="flex-grow flex items-center justify-center px-6 py-16">
        <div class="w-full max-w-md">
            <div class="text-center mb-10">
                <h1 class="text-4xl font-serif font-bold text-[var(--coffee)] mb-3">Bem-vindo de volta!</h1>
                <p class="text-slate-500 font-light">Entre na sua conta para continuar</p>
            </div>

            <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 p-10">
                @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-6 text-sm">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 text-sm">
                    {{ session('error') }}
                </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-xs font-bold text-[var(--coffee)] uppercase tracking-wider mb-3">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-[var(--terracotta)] focus:ring-2 focus:ring-[var(--terracotta)]/20 transition-all"
                            placeholder="seu@email.com"
                            required autofocus>
                        @error('email')
                        <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-[var(--coffee)] uppercase tracking-wider mb-3">Senha</label>
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-[var(--terracotta)] focus:ring-2 focus:ring-[var(--terracotta)]/20 transition-all"
                            placeholder="••••••••"
                            required>
                        @error('password')
                        <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" id="remember" name="remember"
                                class="w-4 h-4 rounded border-slate-300 text-[var(--terracotta)] focus:ring-[var(--terracotta)]/20">
                            <span class="ml-2 text-sm text-slate-600 group-hover:text-slate-900 transition-colors">Lembrar-me</span>
                        </label>

                        <a href="{{ route('password.request') }}"
                           class="text-sm text-[var(--terracotta)] hover:text-[var(--coffee)] transition-colors font-medium">
                            Esqueceu a senha?
                        </a>
                    </div>

                    <button type="submit"
                            class="w-full py-4 bg-gradient-to-r from-[var(--terracotta)] to-[var(--coffee)] text-white rounded-xl font-bold uppercase tracking-wider text-sm hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                        Entrar na conta
                    </button>
                </form>

                <div class="mt-8 pt-8 border-t border-slate-100 text-center">
                    <p class="text-sm text-slate-600 mb-4">Ainda não tem uma conta?</p>
                    <a href="{{ route('users.create') }}"
                       class="inline-flex items-center justify-center px-6 py-3 bg-[var(--olive)] text-white rounded-xl font-bold text-sm hover:bg-[#5a6510] transition-all">
                        Criar conta grátis
                    </a>
                </div>
            </div>
        </div>
    </main>

    <x-footer />
</body>
</html>
