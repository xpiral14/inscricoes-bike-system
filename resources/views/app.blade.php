<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Inscrições.bike')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js"></script>
    {{-- CDN para a biblioteca IMask.js para aplicar máscaras de input --}}
    <script src="https://unpkg.com/imask@6.0.7/dist/imask.js"></script>

    <style>
        body {
            background-color: #F9FAFB; /* bg-gray-50 */
            color: #1F2937; /* text-gray-800 */
        }

        /* Estilos para a transição suave do modal */
        #registration-modal {
            transition: opacity 0.3s ease-in-out;
        }

        #modal-panel {
            transition: transform 0.3s ease-in-out;
        }

        /* Estilo para a borda de erro */
        .border-red-500 {
            border-color: #EF4444;
        }
        .required::after{
            content: '*';
        }
    </style>

    @yield('styles')
</head>
<body class="antialiased">

{{-- Cabeçalho Fixo --}}
<header class="bg-white/80 backdrop-blur-sm sticky top-0 z-50 shadow-sm">
    <nav class="container mx-auto px-4 lg:px-8 py-4 flex justify-between items-center">
        <a href="/" class="text-2xl font-bold text-blue-500">Inscrições<span class="text-gray-900">.bike</span></a>
        <div class="hidden md:flex items-center space-x-6 text-sm font-medium">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-500 transition-colors">Início</a>
            <a href="#" class="text-gray-600 hover:text-blue-500 transition-colors">Eventos</a>
            <a href="#" class="text-gray-600 hover:text-blue-500 transition-colors">Organizadores</a>
            <a href="#" class="text-gray-600 hover:text-blue-500 transition-colors">Contato</a>
        </div>

        {{-- Lógica de exibição condicional --}}
        <div class="flex items-center space-x-4">
            @auth
                {{-- Se o usuário ESTIVER logado --}}
                <span class="text-gray-800 font-medium">Olá, {{ Auth::user()->nome }}</span>

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
{{-- Conteúdo Principal da Página (o que muda) --}}
<main class="container mx-auto px-4 lg:px-8 py-8">
    @yield('content')
</main>

{{-- Rodapé Fixo --}}
<footer class="bg-white border-t border-gray-200 mt-12">
    <div class="container mx-auto px-4 lg:px-8 py-8 text-center text-gray-500 text-sm">
        <p>© 2025 Inscrições.bike - Todos os direitos reservados.</p>
        <p class="mt-2">Desenvolvido e mantido por 2Gigantes Tecnologia Web.</p>
    </div>
</footer>

{{-- O MODAL DE INSCRIÇÃO: Fica no template principal pois é global --}}
@yield('modal')

@yield('scripts')

<script>
    // Inicializa os ícones da biblioteca Lucide globalmente
    lucide.createIcons();
</script>

</body>
</html>
