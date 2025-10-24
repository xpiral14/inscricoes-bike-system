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

    @yield('styles')
</head>
<body class="antialiased">

<header class="bg-white/80 backdrop-blur-sm sticky top-0 z-50 shadow-sm">
    <nav class="container mx-auto px-4 lg:px-8 py-4 flex justify-between items-center">
        <a href="/" class="text-2xl font-bold text-blue-500">
            <img src="{{asset('/images/logo.jpeg')}}" alt="Logomarca do inscrições.com.br"  class="h-[50px]"/>
        </a>
        <div class="hidden md:flex items-center space-x-6 text-sm font-medium">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-500 transition-colors">Início</a>
            <a href="#" class="text-gray-600 hover:text-blue-500 transition-colors">Eventos</a>
            <a href="#" class="text-gray-600 hover:text-blue-500 transition-colors">Organizadores</a>
            <a href="#" class="text-gray-600 hover:text-blue-500 transition-colors">Contato</a>
        </div>

        <div class="flex items-center space-x-4">
            @auth
                {{-- Se o usuário ESTIVER logado --}}
                <div class="hidden sm:flex items-center space-x-4">
                    <span class="text-gray-800 font-medium">Olá, {{ Auth::user()->nome }}</span>
                    {{-- NOVO LINK ADICIONADO AQUI --}}
                    <a href="{{ route('minha-conta.compras') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-semibold rounded-md transition-colors">
                        Minhas Compras
                    </a>
                </div>

                {{-- Formulário de Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-md transition-colors">
                        Sair
                    </button>
                </form>

            @else
                {{-- Se o usuário NÃO ESTIVER logado --}}
                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-md transition-colors">
                    Login / Cadastro
                </a>
            @endauth
        </div>
    </nav>
</header>

<main class="container mx-auto px-4 lg:px-8 py-8">
    @yield('content')
</main>

<footer class="bg-white border-t border-gray-200 mt-12">
    <div class="container mx-auto px-4 lg:px-8 py-8 text-center text-gray-500 text-sm">
        <p>© 2025 Inscrições.bike - Todos os direitos reservados.</p>
        <p class="mt-2">Desenvolvido e mantido por 2Gigantes Tecnologia Web.</p>
    </div>
</footer>

@yield('modal')

@yield('scripts')

<script>
    lucide.createIcons();
</script>

</body>
</html>
