<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscrições.bike - Eventos de Ciclismo</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js"></script>

    <style>
        body { background-color: #F9FAFB; color: #1F2937; }
        .swiper-pagination-bullet { background-color: rgba(0, 0, 0, 0.3); opacity: 1; }
        .swiper-pagination-bullet-active { background-color: #3B82F6; }
        .event-grid::-webkit-scrollbar { width: 8px; }
        .event-grid::-webkit-scrollbar-track { background: #F3F4F6; }
        .event-grid::-webkit-scrollbar-thumb { background: #9CA3AF; border-radius: 4px; }
    </style>
</head>
<body class="antialiased">

<header class="bg-white/80 backdrop-blur-sm sticky top-0 z-50 shadow-sm">
    <nav class="container mx-auto px-4 lg:px-8 py-4 flex justify-between items-center">
        <a href="#" class="text-2xl font-bold text-blue-500">Inscrições<span class="text-gray-900">.bike</span></a>
        <div class="hidden md:flex items-center space-x-6 text-sm font-medium">
            <a href="#" class="text-gray-600 hover:text-blue-500 transition-colors">Início</a>
            <a href="#" class="text-gray-600 hover:text-blue-500 transition-colors">Eventos</a>
            <a href="#" class="text-gray-600 hover:text-blue-500 transition-colors">Organizadores</a>
            <a href="#" class="text-gray-600 hover:text-blue-500 transition-colors">Contato</a>
        </div>
        <a href="#" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-md transition-colors">
            Login / Cadastro
        </a>
    </nav>
</header>

<main>
    {{-- Seção do Slider Principal --}}
    <section class="relative w-full container mx-auto mt-4 px-4 lg:px-8">
        <div class="swiper hero-swiper aspect-[210/297] md:aspect-video lg:aspect-[21/9] rounded-lg overflow-hidden">
            <div class="swiper-wrapper">
                @forelse($featuredEvents as $event)
                    <div class="swiper-slide relative">
                        {{-- Assumindo que os banners estão em public/storage/banners --}}
                        <img src="{{ asset($event->banner) }}" alt="Banner do evento {{ $event->titulo }}" class="h-full mx-auto">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-8 text-white">
                            <h2 class="text-3xl lg:text-5xl font-bold mb-2">{{ $event->titulo }}</h2>
                            <p class="text-lg mb-4">{{ $event->dataevento->translatedFormat('d \d\e F, Y') }} - {{ $event->cidade }} / {{ $event->uf }}</p>
                            <a href="#" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-md transition-colors">Inscreva-se Já</a>
                        </div>
                    </div>
                @empty
                    <div class="swiper-slide relative flex items-center justify-center bg-gray-200">
                        <p class="text-gray-600">Nenhum evento em destaque no momento.</p>
                    </div>
                @endforelse
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev text-gray-800"></div>
            <div class="swiper-button-next text-gray-800"></div>
        </div>
    </section>

    {{-- Seção da Grade de Eventos --}}
    <section class="container mx-auto px-4 lg:px-8 py-12 lg:py-16">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <h2 class="text-3xl font-bold text-gray-900">Próximos Eventos</h2>
            <div class="relative w-full md:w-1/3">
                <input type="text" id="searchInput" placeholder="Pesquisar por nome do evento..." class="w-full pl-10 pr-4 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="search" class="w-5 h-5 text-gray-500"></i>
                </div>
            </div>
        </div>

        <div class="border-b border-gray-200 mb-8">
            <nav id="stateTabs" class="-mb-px flex space-x-6 overflow-x-auto" aria-label="Tabs"></nav>
        </div>

        <div id="eventGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"></div>
        <div id="noResults" class="hidden text-center py-16">
            <i data-lucide="search-x" class="w-16 h-16 mx-auto text-gray-400 mb-4"></i>
            <p class="text-xl text-gray-600">Nenhum evento encontrado.</p>
            <p class="text-gray-500">Tente ajustar sua busca ou filtro de estado.</p>
        </div>
    </section>

    {{-- ... (Restante do conteúdo estático: "Nosso melhor para você", etc.) ... --}}
    <section class="bg-white py-16 lg:py-24">
        <div class="container mx-auto px-4 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900">Nosso melhor para você</h2>
            <p class="mt-2 text-lg text-gray-600">Nós nos preocupamos com cada detalhe</p>
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="flex flex-col items-center">
                    <div class="bg-blue-100 p-4 rounded-full">
                        <i data-lucide="award" class="w-8 h-8 text-blue-600"></i>
                    </div>
                    <h3 class="mt-4 text-xl font-semibold text-gray-900">Plataforma especializada</h3>
                    <p class="mt-2 text-gray-600 leading-relaxed">Somos especializados em eventos de ciclismo. Todos os nossos esforços são voltados para garantir alta qualidade em todos os aspectos.</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="bg-blue-100 p-4 rounded-full">
                        <i data-lucide="mouse-pointer-click" class="w-8 h-8 text-blue-600"></i>
                    </div>
                    <h3 class="mt-4 text-xl font-semibold text-gray-900">Simplicidade</h3>
                    <p class="mt-2 text-gray-600 leading-relaxed">Poucos cliques e muita tecnologia. Cada passo, do cadastro à inscrição, é pensado de modo a minimizar o tempo gasto pelo participante.</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="bg-blue-100 p-4 rounded-full">
                        <i data-lucide="shield-check" class="w-8 h-8 text-blue-600"></i>
                    </div>
                    <h3 class="mt-4 text-xl font-semibold text-gray-900">Segurança</h3>
                    <p class="mt-2 text-gray-600 leading-relaxed">Somente organizadores verificados. Para ser um organizador de eventos no site é necessário confirmar a documentação e titularidade.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="container mx-auto px-4 lg:px-8 py-16 lg:py-24 text-center">
        <h2 class="text-4xl font-bold text-gray-900 leading-tight">As melhores pedaladas<br>da sua região estão aqui</h2>
        <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">Eventos pagos e gratuitos em poucos cliques. Simplicidade e rapidez para o organizador e participantes.</p>
        <div class="mt-8">
            <a href="#" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-md transition-colors text-lg">
                Veja os eventos perto de você
            </a>
        </div>
    </section>

    {{-- Seção da Lista de Eventos --}}
    <section class="container mx-auto px-4 lg:px-8 py-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Próximos Eventos</h2>
        <div class="space-y-4">
            @forelse($listEvents as $event)
                <div class="bg-white border border-gray-200 p-4 rounded-lg flex flex-col sm:flex-row items-center justify-between gap-4 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="text-center font-bold bg-gray-100 p-2 rounded-md w-16">
                            <span class="block text-xl text-gray-800">{{ $event->dataevento->format('d') }}</span>
                            <span class="block text-sm text-blue-600">{{ $event->mes_abreviado }}</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $event->titulo }}</h3>
                            <p class="text-sm text-gray-500">{{ $event->cidade }}/{{ $event->uf }}</p>
                        </div>
                    </div>
                    <a href="#" class="w-full sm:w-auto text-center block bg-gray-200 text-gray-800 font-semibold py-2 px-6 rounded-md text-sm transition-colors hover:bg-gray-300">Ver Detalhes</a>
                </div>
            @empty
                <div class="bg-white border border-gray-200 p-4 rounded-lg text-center">
                    <p class="text-gray-500">Nenhum evento programado encontrado.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- ... (Restante do conteúdo estático: "Crie eventos", etc.) ... --}}
    <section class="bg-gray-100 my-16 lg:my-24">
        <div class="container mx-auto px-4 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Crie eventos de todos os portes de forma simples e eficaz</h2>
                    <p class="mt-4 text-gray-600 leading-relaxed">
                        As melhores taxas do mercado aliadas a maior transparência. O organizador do evento é integrado e recebe diretamente através de Gateways de pagamento famosos do mercado.
                    </p>
                    <p class="mt-4 text-gray-600 leading-relaxed">
                        Entre em contato conosco e saiba como podemos lhe ajudar na produção do seu evento.
                    </p>
                    <a href="#" class="mt-8 inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-md transition-colors">
                        Entre em contato
                    </a>
                </div>
                <div>
                    <img src="https://images.unsplash.com/photo-1541625221341-03c748c941d4?q=80&w=1974&auto=format&fit=crop" alt="Organizador de evento de ciclismo usando um tablet" class="rounded-lg shadow-xl">
                </div>
            </div>
        </div>
    </section>

</main>

<footer class="bg-white border-t border-gray-200">
    <div class="container mx-auto px-4 lg:px-8 py-8 text-center text-gray-500 text-sm">
        <p>&copy; {{ date('Y') }} Inscrições.bike - Todos os direitos reservados.</p>
        <p class="mt-2">Desenvolvido e mantido por 2Gigantes Tecnologia Web.</p>
    </div>
</footer>

<script>
    // --- DATA SOURCE (Injetado pelo Laravel) ---
    const eventsData = @json($allUpcomingEvents);

    // --- DOM ELEMENTS ---
    const searchInput = document.getElementById('searchInput');
    const stateTabsContainer = document.getElementById('stateTabs');
    const eventGrid = document.getElementById('eventGrid');
    const noResultsMessage = document.getElementById('noResults');

    // --- STATE MANAGEMENT ---
    let activeState = 'ALL';
    const tabs = ['ALL', ...@json($states)];

    // --- RENDER FUNCTIONS ---
    function renderEvents(eventsToRender) {
        eventGrid.innerHTML = '';
        if (eventsToRender.length === 0) {
            eventGrid.classList.add('hidden');
            noResultsMessage.classList.remove('hidden');
        } else {
            eventGrid.classList.remove('hidden');
            noResultsMessage.classList.add('hidden');
            eventsToRender.forEach(event => {
                const statusConfig = {
                    open: { text: 'Inscrições Abertas', color: 'bg-blue-600' },
                    closed: { text: 'Inscrições Encerradas', color: 'bg-red-600' }
                };
                const eventStatus = statusConfig[event.status] || { text: 'Status Indefinido', color: 'bg-gray-600' };

                const card = `
                        <div class="bg-white rounded-lg overflow-hidden transition-shadow duration-300 ease-in-out shadow-md hover:shadow-xl border border-gray-200">
                            <img src="${event.image}" alt="Foto do evento ${event.name}" class="w-full h-40 object-cover">
                            <div class="p-4">
                                <h3 class="font-bold text-lg text-gray-900 mb-2 truncate">${event.name}</h3>
                                <div class="flex items-center text-sm text-gray-500 mb-2">
                                    <i data-lucide="calendar" class="w-4 h-4 mr-2"></i>
                                    <span>${new Date(event.date).toLocaleDateString('pt-BR', {timeZone: 'UTC'})}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-500 mb-4">
                                    <i data-lucide="map-pin" class="w-4 h-4 mr-2"></i>
                                    <span>${event.cidade}, ${event.state}</span>
                                </div>
                                <a href="${event.url}" class="w-full text-center block ${eventStatus.color} text-white font-semibold py-2 rounded-md text-sm transition-opacity hover:opacity-90">
                                    ${eventStatus.text}
                                </a>
                            </div>
                        </div>
                    `;
                eventGrid.innerHTML += card;
            });
        }
        lucide.createIcons();
    }

    function renderTabs() {
        stateTabsContainer.innerHTML = '';
        tabs.forEach(state => {
            const isActive = state === activeState;
            const tabClasses = isActive
                ? 'border-blue-500 text-blue-600'
                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300';

            const tab = `
                    <a href="#" data-state="${state}" class="tab-link whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors ${tabClasses}">
                        ${state === 'ALL' ? 'Todos' : state}
                    </a>
                `;
            stateTabsContainer.innerHTML += tab;
        });
    }

    // --- FILTERING LOGIC ---
    function filterAndDisplayEvents() {
        const searchQuery = searchInput.value.toLowerCase();

        let filteredByState = eventsData;
        if (activeState !== 'ALL') {
            filteredByState = eventsData.filter(event => event.state === activeState);
        }

        let finalFilteredEvents = filteredByState;
        if (searchQuery) {
            finalFilteredEvents = filteredByState.filter(event => {
                    return event.name.toLowerCase().includes(searchQuery) || event.state.toLowerCase().includes(searchQuery) || event.cidade.toLowerCase().includes(searchQuery);
                }
            );
        }

        finalFilteredEvents.sort((a, b) => new Date(a.date) - new Date(b.date));

        // Limit to 8 events only on the initial "ALL" load without search
        if (activeState === 'ALL' && !searchQuery) {
            finalFilteredEvents = finalFilteredEvents.slice(0, 8);
        }

        renderEvents(finalFilteredEvents);
    }

    // --- EVENT LISTENERS ---
    stateTabsContainer.addEventListener('click', (e) => {
        e.preventDefault();
        const target = e.target.closest('.tab-link');
        if (target) {
            activeState = target.dataset.state;
            searchInput.value = '';
            renderTabs();
            filterAndDisplayEvents();
        }
    });

    searchInput.addEventListener('input', () => {
        filterAndDisplayEvents();
    });

    // --- INITIALIZATION ---
    document.addEventListener('DOMContentLoaded', () => {
        const swiper = new Swiper('.hero-swiper', {
            loop: true,
            autoplay: { delay: 5000, disableOnInteraction: false },
            effect: 'fade',
            fadeEffect: { crossFade: true },
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
        });

        renderTabs();
        filterAndDisplayEvents();
        lucide.createIcons();
    });
</script>
</body>
</html>
