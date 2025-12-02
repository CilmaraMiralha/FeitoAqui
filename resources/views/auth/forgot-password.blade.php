<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - FeitoAqui</title>

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
                <h1 class="text-3xl lg:text-4xl font-serif font-bold text-[var(--coffee)] mb-3">Recuperar Senha</h1>
                <p class="text-slate-500 font-light leading-relaxed">Informe seu email para receber o link de recuperação</p>
            </div>

            <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 p-8">
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                <form action="{{ route('password.email') }}" method="POST">
                    @csrf

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

                    <button type="submit"
                        class="w-full py-3.5 px-6 bg-gradient-to-r from-[var(--terracotta)] to-[var(--coffee)] text-white rounded-xl font-semibold btn-primary shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)]">
                        Enviar Link de Recuperação
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
                    Não tem uma conta?
                    <a href="{{ route('users.create') }}" class="text-[var(--terracotta)] hover:text-[var(--coffee)] font-semibold transition-colors">
                        Cadastre-se
                    </a>
                </p>
            </div>
        </div>
    </main>

    <x-footer />
</body>

</html>
