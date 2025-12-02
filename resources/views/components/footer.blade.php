<footer class="w-full bg-[#644536] text-[#F2F5EA] mt-auto border-t-8 border-[#B2675E]" style="background-color: var(--coffee, #644536); color: var(--ivory, #F2F5EA); border-top-color: var(--terracotta, #B2675E);">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 py-16">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 lg:gap-16">

            <div class="md:col-span-5 space-y-6">
                <h3 class="text-3xl font-serif font-bold flex items-center gap-3">
                    🧶 FeitoAqui
                </h3>
                <p class="text-sm text-[#D6DBD2] max-w-sm leading-relaxed opacity-80">
                    Valorizando o trabalho manual e conectando paixões.
                    Nossa missão é transformar cada ponto em uma oportunidade de negócio e criatividade.
                </p>
            </div>

            <div class="md:col-span-3 lg:col-start-7">
                <h4 class="font-bold text-[#B2675E] mb-6 uppercase text-[10px] tracking-[0.2em]">Explorar</h4>
                <ul class="space-y-4 text-sm text-[#D6DBD2] opacity-80">
                    <li><a href="{{ route('patterns.search') }}" class="footer-link hover:text-white transition">Buscar Receitas</a></li>
                    @auth
                        @if(Auth::user()->is_seller)
                        <li><a href="{{ route('materials.index') }}" class="footer-link hover:text-white transition">Materiais</a></li>
                        <li><a href="{{ route('drafts.index') }}" class="footer-link hover:text-white transition">Rascunhos</a></li>
                        @endif
                    @endauth
                </ul>
            </div>

            <div class="md:col-span-3">
                <h4 class="font-bold text-[#6F7C12] mb-6 uppercase text-[10px] tracking-[0.2em]">Sua Conta</h4>
                <ul class="space-y-4 text-sm text-[#D6DBD2] opacity-80">
                    @auth
                    <li><a href="{{ route('orders.index') }}" class="footer-link hover:text-white transition">Meus Pedidos</a></li>
                    @if(Auth::user()->is_seller)
                    <li><a href="{{ route('patterns.index') }}" class="footer-link hover:text-white transition">Minhas Receitas</a></li>
                    @endif
                    <li><a href="{{ route('users.edit', Auth::user()) }}" class="footer-link hover:text-white transition">Meu Perfil</a></li>
                    @else
                    <li><a href="{{ route('login') }}" class="footer-link hover:text-white transition">Entrar</a></li>
                    <li><a href="{{ route('users.create') }}" class="footer-link hover:text-white transition">Criar Conta Grátis</a></li>
                    @endauth
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10 mt-16 pt-8 text-center text-[10px] uppercase tracking-wider text-[#D6DBD2] opacity-60">
            <p>&copy; {{ date('Y') }} FeitoAqui. Todos os direitos reservados. Feito com ❤️ e fio.</p>
        </div>
    </div>

    <style>
        .footer-link {
            position: relative;
            display: inline-block;
            text-decoration: none;
            color: inherit;
            transition: color 0.3s ease;
        }

        .footer-link:hover {
            color: #fff;
        }

        .footer-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 1px;
            bottom: -2px;
            left: 0;
            background-color: var(--terracotta, #B2675E);
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .footer-link:hover::after {
            width: 100%;
        }
    </style>
</footer>