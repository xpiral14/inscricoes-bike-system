<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Inscrições.bike')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js"></script>
    <script src="https://unpkg.com/imask@6.0.7/dist/imask.js"></script>

    <style>
        body { background-color: #F9FAFB; color: #1F2937; }
        .accordion-content { transition: max-height 0.3s ease-out, padding 0.3s ease-out; max-height: 0; overflow: hidden; }
        .accordion-button[aria-expanded="true"] .accordion-icon { transform: rotate(180deg); }
        .accordion-icon { transition: transform 0.3s ease-out; }
        .modal-transition { transition: opacity 0.3s ease-in-out; }
        .modal-panel-transition { transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out; }
    </style>

    @yield('styles')
</head>
<body class="antialiased">

<header class="bg-white/80 backdrop-blur-sm sticky top-0 z-50 shadow-sm">
    <nav class="container mx-auto px-4 lg:px-8 py-4 flex justify-between items-center">
        <a href="/" class="text-2xl font-bold text-blue-500 flex-shrink-0">
            <img src="{{asset('/images/logo.jpeg')}}" alt="Logomarca do inscrições.com.br" class="h-[50px]"/>
        </a>

        {{-- MENU PARA DESKTOP --}}
        <div class="hidden md:flex items-center space-x-6 text-sm font-medium">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-500 transition-colors">Início</a>
            <a href="#" class="text-gray-600 hover:text-blue-500 transition-colors">Eventos</a>
            <a href="#" class="text-gray-600 hover:text-blue-500 transition-colors">Organizadores</a>
            <a href="#" class="text-gray-600 hover:text-blue-500 transition-colors">Contato</a>
        </div>

        {{-- BOTÕES DE AÇÃO PARA DESKTOP --}}
        <div class="hidden md:flex items-center space-x-4">
            @auth
                <span class="text-gray-800 font-medium">Olá, {{ Auth::user()->nome }}</span>
                <a href="{{ route('minha-conta.compras') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-semibold rounded-md transition-colors">
                    Minhas Compras
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-md transition-colors">
                        Sair
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-md transition-colors">
                    Login / Cadastro
                </a>
            @endauth
        </div>

        {{-- BOTÃO HAMBÚRGUER PARA MOBILE --}}
        <div class="md:hidden">
            <button id="mobile-menu-button" class="p-2 rounded-md text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
        </div>
    </nav>

    {{-- MENU EXPANSÍVEL PARA MOBILE --}}
    <div id="mobile-menu" class="md:hidden hidden bg-white border-t border-gray-200">
        <div class="px-4 pt-4 pb-6 space-y-4">
            <a href="{{ route('home') }}" class="block px-2 py-1 text-base font-medium text-gray-700 rounded-md hover:bg-gray-100">Início</a>
            <a href="#" class="block px-2 py-1 text-base font-medium text-gray-700 rounded-md hover:bg-gray-100">Eventos</a>
            <a href="#" class="block px-2 py-1 text-base font-medium text-gray-700 rounded-md hover:bg-gray-100">Organizadores</a>
            <a href="#" class="block px-2 py-1 text-base font-medium text-gray-700 rounded-md hover:bg-gray-100">Contato</a>

            <div class="border-t border-gray-200 pt-4 space-y-4">
                @auth
                    <a href="{{ route('minha-conta.compras') }}" class="flex items-center px-2 py-1 text-base font-medium text-gray-800 rounded-md hover:bg-gray-100">
                        <i data-lucide="shopping-cart" class="w-5 h-5 mr-3 text-blue-600"></i>
                        Minhas Compras
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left flex items-center px-2 py-1 text-base font-medium text-red-600 rounded-md hover:bg-gray-100">
                            <i data-lucide="log-out" class="w-5 h-5 mr-3"></i>
                            Sair
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="w-full text-center block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md transition-colors">
                        Login / Cadastro
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>

<main class="container mx-auto px-4 lg:px-8 py-8">
    @yield('content')
</main>

<footer class="bg-white border-t border-gray-200 mt-12">
    <div class="container mx-auto px-4 lg:px-8 py-8 text-center text-gray-500 text-sm">
        <p>© {{ date('Y') }} Inscrições.bike - Todos os direitos reservados.</p>
        <p class="mt-2">Desenvolvido e mantido por 2Gigantes Tecnologia Web.</p>
    </div>
</footer>

@yield('modal')

@yield('scripts')

<script>
    // É crucial chamar lucide.createIcons() DEPOIS que o DOM estiver pronto.
    lucide.createIcons();

    // Lógica para controlar o menu mobile
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }
</script>

</body>
</html>
