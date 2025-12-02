<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha - FeitoAqui</title>

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

    <main class="flex-grow flex items-center justify-center py-12 px-6 sm:px-8 lg:px-12">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <h1 class="text-3xl lg:text-4xl font-serif font-bold text-[var(--coffee)] mb-3">Redefinir Senha</h1>
                <p class="text-slate-500 font-light leading-relaxed">Digite sua nova senha abaixo</p>
            </div>

            <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 p-8">
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-6">
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-[var(--coffee)] mb-2">
                            Email
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[var(--terracotta)]/20 focus:border-[var(--terracotta)] transition-all"
                            required autofocus>
                        @error('email')
                            <div class="text-[var(--terracotta)] text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-[var(--coffee)] mb-2">
                            Nova Senha
                        </label>
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[var(--terracotta)]/20 focus:border-[var(--terracotta)] transition-all"
                            required>
                        <div class="text-slate-400 text-xs mt-1.5">Mínimo de 8 caracteres</div>
                        @error('password')
                            <div class="text-[var(--terracotta)] text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-[var(--coffee)] mb-2">
                            Confirmar Nova Senha
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[var(--terracotta)]/20 focus:border-[var(--terracotta)] transition-all"
                            required>
                    </div>

                    <button type="submit"
                        class="w-full py-3.5 px-6 bg-gradient-to-r from-[var(--terracotta)] to-[var(--coffee)] text-white rounded-xl font-semibold btn-primary shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)]">
                        Redefinir Senha
                    </button>
                </form>

                <div class="mt-6 pt-6 border-t border-slate-100 text-center">
                    <a href="{{ route('login') }}"
                        class="text-sm text-[var(--terracotta)] hover:text-[var(--coffee)] font-semibold transition-colors inline-flex items-center group">
                        <svg class="w-4 h-4 mr-2 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Voltar para o login
                    </a>
                </div>
            </div>

            <div class="mt-8 text-center">
                <p class="text-slate-500 text-sm">
                    Lembrou sua senha?
                    <a href="{{ route('login') }}" class="text-[var(--terracotta)] hover:text-[var(--coffee)] font-semibold transition-colors">
                        Faça login
                    </a>
                </p>
            </div>
        </div>
    </main>

    <x-footer />
</body>

</html>
