@extends('app')

@section('title', 'Minhas Compras')

@section('styles')
    <style>
        body {
            background-color: #F9FAFB; /* bg-gray-50 */
            color: #1F2937; /* text-gray-800 */
        }

        .accordion-content {
            transition: max-height 0.3s ease-out, padding 0.3s ease-out;
            max-height: 0;
            overflow: hidden;
        }

        .accordion-button[aria-expanded="true"] .accordion-icon {
            transform: rotate(180deg);
        }

        .accordion-icon {
            transition: transform 0.3s ease-out;
        }

        .modal-transition {
            transition: opacity 0.3s ease-in-out;
        }

        .modal-panel-transition {
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }

    </style>

@endsection
@section('content')
    <main class="flex-grow container mx-auto px-4 py-8 md:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            <aside class="lg:col-span-1">
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Minha Conta</h2>
                    <nav class="space-y-2">
                        <a href="{{ route('minha-conta.compras') }}"
                           class="flex items-center px-4 py-2 text-sm font-semibold bg-blue-100 text-blue-700 rounded-md">
                            <i data-lucide="shopping-cart" class="w-5 h-5 mr-3"></i>
                            Minhas Compras
                        </a>
                        <a href="#"
                           class="flex items-center px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-md">
                            <i data-lucide="user-circle" class="w-5 h-5 mr-3"></i>
                            Perfil Pessoal
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-md">
                                <i data-lucide="log-out" class="w-5 h-5 mr-3"></i>
                                Sair
                            </button>
                        </form>
                    </nav>
                </div>
            </aside>

            <section class="lg:col-span-3">
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">Minhas Compras</h1>

                    @if($compras->isEmpty())
                        <div class="text-center py-12 px-6 bg-gray-50 rounded-lg">
                            <i data-lucide="inbox" class="w-16 h-16 mx-auto text-gray-400"></i>
                            <h3 class="mt-4 text-xl font-semibold text-gray-700">Nenhuma compra encontrada</h3>
                            <p class="mt-2 text-gray-500">Você ainda não realizou nenhuma inscrição em eventos. Que tal
                                encontrar um agora?</p>
                            <a href="{{route('home')}}"
                               class="mt-6 inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition-colors">
                                Ver Eventos
                            </a>
                        </div>
                    @else
                        <div class="space-y-4" id="purchases-accordion-group">
                            @foreach($compras as $compra)
                                @php
                                    $statusList = [
                                        94 => ['text' => 'Aguardando Pagamento', 'classes' => 'bg-yellow-100 text-yellow-800'],
                                        1  => ['text' => 'Aguardando Pagamento', 'classes' => 'bg-yellow-100 text-yellow-800'],
                                        7  => ['text' => 'Cancelado', 'classes' => 'bg-red-100 text-red-800'],
                                        5  => ['text' => 'Valor Solicitado', 'classes' => 'bg-orange-100 text-orange-800'],
                                        93 => ['text' => 'Cortesia', 'classes' => 'bg-blue-100 text-blue-800'],
                                        9  => ['text' => 'Inscrito(a)', 'classes' => 'bg-green-100 text-green-800'],
                                        85 => ['text' => 'Marcado como Pago', 'classes' => 'bg-green-100 text-green-800'],
                                        3  => ['text' => 'Pago', 'classes' => 'bg-green-100 text-green-800'],
                                        2  => ['text' => 'Pagto em Análise', 'classes' => 'bg-yellow-100 text-yellow-800'],
                                        18 => ['text' => 'Prazo Esgotado', 'classes' => 'bg-gray-100 text-gray-800'],
                                        70 => ['text' => 'Reembolsado', 'classes' => 'bg-gray-100 text-gray-800'],
                                        75 => ['text' => 'Transferido', 'classes' => 'bg-purple-100 text-purple-800'],
                                        6  => ['text' => 'Valor Devolvido', 'classes' => 'bg-gray-100 text-gray-800'],
                                    ];
                                    $currentStatus = $statusList[$compra->situacao] ?? ['text' => 'Indefinido', 'classes' => 'bg-gray-100 text-gray-800'];
                                @endphp
                                <div class="border border-gray-200 rounded-lg">
                                    <h2>
                                        <button type="button"
                                                class="accordion-button flex items-center justify-between w-full p-4 font-semibold text-left text-gray-800 bg-gray-50 hover:bg-gray-100 rounded-t-lg"
                                                aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                                            <div class="flex items-center gap-4">
                                                @if($compra->evento && $compra->evento->banner)
                                                    <img
                                                        src="{{ $compra->evento->banner }}"
                                                        alt="Banner do Evento"
                                                        class="w-24 h-16 object-cover rounded-md hidden sm:block">
                                                @else
                                                    <img src="https://placehold.co/96x64/e2e8f0/adb5bd?text=Evento"
                                                         alt="Banner do Evento"
                                                         class="w-24 h-16 object-cover rounded-md hidden sm:block">
                                                @endif

                                                <div class="flex flex-col items-start text-left">
                                                    <span
                                                        class="text-lg">{{ $compra->evento->titulo ?? 'Nome do Evento Indisponível' }}</span>
                                                    <span
                                                        class="text-sm font-normal text-gray-500">Compra realizada em {{ \Carbon\Carbon::parse($compra->datacad)->format('d/m/Y') }}</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-4 ml-4 flex-shrink-0">
                                                <span
                                                    class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $currentStatus['classes'] }}">
                                                    {{ $currentStatus['text'] }}
                                                </span>
                                                <i data-lucide="chevron-down" class="w-6 h-6 accordion-icon"></i>
                                            </div>
                                        </button>
                                    </h2>
                                    <div class="accordion-content" @if($loop->first) style="max-height: 1000px;" @endif>
                                        <div class="p-4 border-t border-gray-200">
                                            <p class="font-semibold mb-3 text-gray-700">Ingressos desta compra:</p>
                                            <ul class="space-y-3">
                                                @forelse($compra->inscritos as $inscrito)
                                                    <li class="ticket-item flex items-center justify-between p-3 bg-gray-50 rounded-md hover:bg-gray-100 cursor-pointer transition-colors"
                                                        data-name="{{ $inscrito->usuarioModel->nome ?? 'Não informado' }}"
                                                        data-cpf="{{ $inscrito->usuarioModel->cpf ?? 'Não informado' }}"
                                                        data-dob="{{ $inscrito->usuarioModel->data_nascimento ? \Carbon\Carbon::parse($inscrito->usuarioModel->data_nascimento)->format('d/m/Y') : 'Não informado' }}"
                                                        data-category="{{ $inscrito->categoria->name ?? 'Não informada' }}">

                                                        <div class="flex items-center">
                                                            <i data-lucide="ticket"
                                                               class="w-5 h-5 mr-3 text-blue-600"></i>
                                                            <span
                                                                class="text-gray-800">Ingresso atribuído a: <strong>{{ $inscrito->usuarioModel->nome ?? 'Participante' }}</strong></span>
                                                        </div>

                                                        <span class="font-semibold text-gray-800">
                                                            R$ {{ number_format($inscrito->price, 2, ',', '.') }}
                                                        </span>
                                                    </li>
                                                @empty
                                                    <li class="text-gray-500">Nenhum ingresso encontrado para esta
                                                        compra.
                                                    </li>
                                                @endforelse
                                            </ul>

                                            <div
                                                class="mt-6 pt-4 border-t border-gray-200 flex flex-col sm:flex-row justify-end items-center gap-4">
                                                @if(in_array($compra->situacao, [1, 94]) && !empty($compra->paymentLink))
                                                    <a href="{{ $compra->paymentLink }}" target="_blank"
                                                       class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-4 py-2 bg-[#009EE3] text-white font-semibold rounded-md shadow-sm hover:bg-[#008fcf] transition-colors">
                                                        <img src="{{asset('/images/mp_logo.svg')}}" class="w-[100px]"/>
                                                        <span>Pagar com Mercado Pago</span>
                                                    </a>
                                                @endif
                                                <span class="text-lg font-bold text-gray-900 text-right">
                                                    Total da Compra: R$ {{ number_format($compra->inscritos->sum('price'), 2, ',', '.') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </main>
@endsection

@section('modal')
    <div id="ticket-modal"
         class="fixed inset-0 z-[100] hidden items-center justify-center p-4 modal-transition opacity-0">
        <div id="ticket-modal-backdrop" class="fixed inset-0 bg-black/60"></div>
        <div id="ticket-modal-panel"
             class="relative w-full max-w-lg bg-white rounded-lg shadow-xl modal-panel-transition transform scale-95 opacity-0">
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900">Detalhes do Ingresso</h3>
                <button id="ticket-modal-close" class="p-1 rounded-full hover:bg-gray-200">
                    <i data-lucide="x" class="w-6 h-6 text-gray-600"></i>
                </button>
            </div>
            <div class="p-6">
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nome do Participante</dt>
                        <dd id="modal-ticket-name" class="mt-1 text-lg font-semibold text-gray-900"></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">CPF</dt>
                        <dd id="modal-ticket-cpf" class="mt-1 text-lg font-semibold text-gray-900"></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Data de Nascimento</dt>
                        <dd id="modal-ticket-dob" class="mt-1 text-lg font-semibold text-gray-900"></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Categoria</dt>
                        <dd id="modal-ticket-category" class="mt-1 text-lg font-semibold text-gray-900"></dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const accordionGroup = document.getElementById('purchases-accordion-group');
            if (accordionGroup) {
                const buttons = accordionGroup.querySelectorAll('.accordion-button');
                buttons.forEach(button => {
                    button.addEventListener('click', () => {
                        const isExpanded = button.getAttribute('aria-expanded') === 'true';
                        button.setAttribute('aria-expanded', !isExpanded);
                        const content = button.parentElement.nextElementSibling;
                        if (!isExpanded) {
                            content.style.maxHeight = content.scrollHeight + 'px';
                        } else {
                            content.style.maxHeight = null;
                        }
                    });
                });
            }

            const ticketModal = document.getElementById('ticket-modal');
            const ticketModalPanel = document.getElementById('ticket-modal-panel');
            const ticketModalBackdrop = document.getElementById('ticket-modal-backdrop');
            const ticketModalCloseButton = document.getElementById('ticket-modal-close');
            const modalName = document.getElementById('modal-ticket-name');
            const modalCpf = document.getElementById('modal-ticket-cpf');
            const modalDob = document.getElementById('modal-ticket-dob');
            const modalCategory = document.getElementById('modal-ticket-category');

            const openTicketModal = (data) => {
                modalName.textContent = data.name || 'Não informado';
                modalCpf.textContent = data.cpf || 'Não informado';
                modalDob.textContent = data.dob || 'Não informado';
                modalCategory.textContent = data.category || 'Não informado';
                ticketModal.classList.remove('hidden');
                ticketModal.classList.add('flex');
                setTimeout(() => {
                    ticketModal.classList.remove('opacity-0');
                    ticketModalPanel.classList.remove('scale-95', 'opacity-0');
                }, 10);
            };

            const closeTicketModal = () => {
                ticketModal.classList.add('opacity-0');
                ticketModalPanel.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    ticketModal.classList.add('hidden');
                    ticketModal.classList.remove('flex');
                }, 300);
            };

            if (accordionGroup) {
                accordionGroup.addEventListener('click', (event) => {
                    const ticketItem = event.target.closest('.ticket-item');
                    if (ticketItem) {
                        openTicketModal(ticketItem.dataset);
                    }
                });
            }

            if (ticketModal) {
                ticketModalCloseButton.addEventListener('click', closeTicketModal);
                ticketModalBackdrop.addEventListener('click', closeTicketModal);
            }
        });
    </script>
@endsection
