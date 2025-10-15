<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Inscrição {{$evento->titulo}} -{{ $evento->cidade}}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js"></script>

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
    </style>
</head>
<body class="antialiased">

<header class="bg-white/80 backdrop-blur-sm sticky top-0 z-50 shadow-sm">
    <nav class="container mx-auto px-4 lg:px-8 py-4 flex justify-between items-center">
        <a href="/" class="text-2xl font-bold text-blue-500">Inscrições<span class="text-gray-900">.bike</span></a>
        <div class="hidden md:flex items-center space-x-6 text-sm font-medium">
            <a href="#" class="text-gray-600 hover:text-blue-500 transition-colors">Início</a>
            <a href="#" class="text-gray-600 hover:text-blue-500 transition-colors">Eventos</a>
            <a href="#" class="text-gray-600 hover:text-blue-500 transition-colors">Organizadores</a>
            <a href="#" class="text-gray-600 hover:text-blue-500 transition-colors">Contato</a>
        </div>
        <a href="#"
           class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-md transition-colors">
            Login / Cadastro
        </a>
    </nav>
</header>

<main class="container mx-auto px-4 lg:px-8 py-8">

    <section class="mb-8">
        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900">{{$evento->titulo}}</h1>
        <div class="flex items-center mt-2 text-lg text-gray-600">
            <i data-lucide="map-pin" class="w-5 h-5 mr-2"></i>
            <span>{{$evento->cidade}}, {{$evento->uf}}</span>
        </div>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 space-y-8">

            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Detalhes do Evento</h2>
                <div class="flex flex-col md:flex-row gap-6">
                    <img src="{{$evento->banner}}"
                         alt="Banner do Evento {{$evento->titulo}}"
                         class="w-full md:w-1/3 rounded-md object-cover">
                    <p class="text-gray-600 leading-relaxed">{!! \Illuminate\Support\Str::replace('==', '<br />', $evento->descricao) !!}</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    <i data-lucide="route" class="w-5 h-5 mr-2 inline"></i>
                    Roteiro/Percurso</h2>
                <p class="text-gray-600 leading-relaxed">{{$evento->roteiro}}</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    <i data-lucide="medal" class="w-5 h-5 mr-3 inline"></i>
                    Premiação</h2>
                {!! \Illuminate\Support\Str::replace('==', '<br />', $evento->premiacao) !!}
            </div>
            @if($evento->seguro)
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200 relative"
                     style="background-color: #e8f0ff">
                    <img src="{{asset('images/porto-seguro-logo.svg')}}" alt="Logo Porto Seguro"
                         class="absolute top-[-60px] right-0 w-[200px] object-contain"/>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Seguro Atleta Porto Seguro</h2>
                    <p class="text-gray-600 mb-4">Os participantes deste evento possuem incluso no valor de participação
                        um
                        seguro-atleta da Porto Seguro.</p>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse stri">
                            <thead>
                            <tr>
                                <th class="p-3 font-semibold border-b border-gray-300">Cobertura - Acidentes Pessoais
                                </th>
                                <th class="p-3 font-semibold border-b border-gray-300">Capital Segurado</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="border-b border-gray-200 bg-white">
                                <td class="p-3">Morte Acidental (Titular)</td>
                                <td class="p-3">R$ 50.000,00</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="p-3">Invalidez Perm. Total ou Parcial por Acidente (Titular)</td>
                                <td class="p-3">R$ 50.000,00</td>
                            </tr>
                            <tr class="bg-white">
                                <td class="p-3">Despesas Médicas Hospitalares ou Odontológicas (Titular)</td>
                                <td class="p-3">R$ 5.000,00</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 text-sm text-gray-500 space-y-2">
                        <p>Idade Mínima do(a) segurado(a): 14 anos para seguro completo.</p>
                        <p>12 e 13 anos não inclui o seguro por morte acidental (regras da seguradora).</p>
                        <p>Limite de Idade: 74 anos.</p>
                    </div>
                </div>

            @endif


            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    <i data-lucide="newspaper" class="w-5 h-5 mr-3 inline"></i>
                    Regulamento e Termos</h2>
                <div class="text-gray-600 space-y-3 text-sm">
                    <p>- Declara que leu e está de acordo com o regulamento do evento, participa deste evento por
                        vontade própria.</p>
                    <p>- Está ciente de que <b>este evento é de um esporte de risco</b> e atesta que está <b>clinicamente
                            em condições de saúde</b> segundo avaliação médica e devidamente treinado.</p>
                    <p>- <b>Assume todos os riscos em participar do evento</b>, inclusive os relativos a quedas,
                        contatos com outros participantes, assalto, efeitos do clima, condições do circuito e do tráfego
                        e quebra de equipamento.</p>
                    <p>- Concede permissão à organização e seus representantes, <b>direito de uso de imagem</b>, para
                        que utilize fotos, filmes, gravações, etc.; para divulgação que mostre minha participação.</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    <i data-lucide="map-pin" class="w-5 h-5 mr-2 inline"></i>
                    Local da Largada</h2>
                <p class="text-gray-600 mb-4">Praça Antônio Bispo, Nossa Senhora Aparecida - SE</p>
                <div class="aspect-video rounded-md overflow-hidden border">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3921.29528659104!2d-37.4792683888998!3d-10.63841999951666!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x70fe008294208a7%3A0x1994b415f3a0558b!2sPra%C3%A7a%20Ant%C3%B4nio%20Bispo!5e0!3m2!1spt-BR!2sbr!4v1696816075589!5m2!1spt-BR!2sbr"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="sticky top-24 space-y-6">
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                    <div class="mb-4">

                        <table class="w-full text-left border-collapse">

                            <thead>
                            <tr>
                                <th>Nome da categoria</th>
                                <th>Valor</th>
                            </tr>
                            <tbody>
                            @foreach($evento->categorias as $categoria)
                                <tr>
                                    <td>{{$categoria->name}}</td>
                                    <td>R$ {{number_format($categoria->price, 2, ',', '.')}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            </thead>

                        </table>
                    </div>
                    <button
                        class="open-modal-button w-full block text-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-md transition-colors">
                        Inscreva-se Agora
                    </button>
                    <div class="text-center mt-4">
                        <p class="font-bold text-gray-800">
                            Faltam {{floor($evento->inicioEvento()->diffInDays(now(), true))}} dias!</p>
                        <p class="text-sm text-gray-500">Inscrições
                            para {{$evento->inicioEvento()->format('d/m/Y \à\s H:i')}}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Incluso neste evento</h3>
                    <ul class="space-y-3 text-gray-700">
                        @foreach($evento->estruturas as $estrutura)
                            <li class="flex items-center"><i data-lucide="{{$estrutura->iconkey}}"
                                                             class="w-5 h-5 mr-3 text-blue-500"></i>
                                {{$estrutura->name}}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200 text-center">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Organizado por</h3>
                    <img
                        src="{{$evento->organizadorModel->imagem}}"
                        alt="Logo {{$evento->organizadorModel->nome}}" class="w-24 h-24 rounded-full mx-auto mb-3">
                    <p class="font-semibold text-gray-800">{{$evento->organizadorModel->nome}}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Dúvidas?</h3>
                    <p class="text-gray-600 mb-3">Entre em contato com o organizador:</p>
                    <a href="https://api.whatsapp.com/send?phone=5579998708158" target="_blank"
                       class="flex items-center justify-center w-full px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-md transition-colors">
                        <i data-lucide="phone" class="w-5 h-5 mr-2"></i> (79) 9 9870-8158
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<footer class="bg-white border-t border-gray-200 mt-12">
    <div class="container mx-auto px-4 lg:px-8 py-8 text-center text-gray-500 text-sm">
        <p>© 2025 Inscrições.bike - Todos os direitos reservados.</p>
        <p class="mt-2">Desenvolvido e mantido por 2Gigantes Tecnologia Web.</p>
    </div>
</footer>

<div id="registration-modal" class="fixed inset-0 z-[100] hidden opacity-0" aria-labelledby="modal-title" role="dialog"
     aria-modal="true">
    <div id="modal-backdrop" class="fixed inset-0 bg-black/60"></div>

    <div id="modal-panel"
         class="fixed top-0 right-0 h-full w-full max-w-lg bg-white shadow-xl transform translate-x-full flex flex-col">
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <h2 id="modal-title" class="text-xl font-bold text-gray-900">Inscrição</h2>
            <button id="close-modal-button" class="p-1 rounded-full hover:bg-gray-200">
                <i data-lucide="x" class="w-6 h-6 text-gray-600"></i>
            </button>
        </div>

        <div class="flex-grow p-6 overflow-y-auto">
            <div id="step-1">
                <h3 class="text-lg font-semibold text-gray-800">Passo 1: Quantos ingressos?</h3>
                <div class="mt-4 p-4 border rounded-md bg-gray-50">
                    <p class="font-semibold">2° Trilhão Brutas da Maniçoba - 2026</p>
                    <p class="text-gray-600">Valor por ingresso: R$ 45,90</p>
                </div>
                <div class="mt-6 flex items-center justify-center gap-4">
                    <button id="quantity-minus"
                            class="p-2 border rounded-full bg-gray-200 hover:bg-gray-300 disabled:opacity-50">
                        <i data-lucide="minus" class="w-5 h-5"></i>
                    </button>
                    <span id="quantity-display" class="text-2xl font-bold w-12 text-center">1</span>
                    <button id="quantity-plus" class="p-2 border rounded-full bg-gray-200 hover:bg-gray-300">
                        <i data-lucide="plus" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            <div id="step-2" class="hidden">
                <h3 class="text-lg font-semibold text-gray-800">Passo 2: Detalhes dos Participantes</h3>
                <div id="participant-forms-container" class="mt-4 space-y-6">
                </div>
            </div>
        </div>

        <div class="p-4 bg-gray-50 border-t border-gray-200">
            <div id="footer-step-1">
                <button id="continue-button"
                        class="w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-md transition-colors">
                    Continuar
                </button>
            </div>
            <div id="footer-step-2" class="hidden flex items-center gap-4">
                <button id="back-button"
                        class="w-1/3 px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold rounded-md transition-colors">
                    Voltar
                </button>
                <button id="finish-button"
                        class="w-2/3 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-md transition-colors">
                    Finalizar Inscrição
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    // Inicializa os ícones da biblioteca Lucide
    lucide.createIcons();

    // Garante que o script rode após o carregamento do DOM
    document.addEventListener('DOMContentLoaded', () => {
        // Seleção dos elementos do DOM
        const modal = document.getElementById('registration-modal');
        const modalPanel = document.getElementById('modal-panel');
        const modalBackdrop = document.getElementById('modal-backdrop');
        const openModalButtons = document.querySelectorAll('.open-modal-button');
        const closeModalButton = document.getElementById('close-modal-button');

        const step1 = document.getElementById('step-1');
        const step2 = document.getElementById('step-2');
        const footerStep1 = document.getElementById('footer-step-1');
        const footerStep2 = document.getElementById('footer-step-2');

        const continueButton = document.getElementById('continue-button');
        const backButton = document.getElementById('back-button');
        const finishButton = document.getElementById('finish-button');

        const quantityDisplay = document.getElementById('quantity-display');
        const quantityPlus = document.getElementById('quantity-plus');
        const quantityMinus = document.getElementById('quantity-minus');

        const formsContainer = document.getElementById('participant-forms-container');

        let ticketQuantity = 1;

        const openModal = () => {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalPanel.classList.remove('translate-x-full');
            }, 10);
        };

        const closeModal = () => {
            modal.classList.add('opacity-0');
            modalPanel.classList.add('translate-x-full');
            setTimeout(() => {
                modal.classList.add('hidden');
                showStep(1);
            }, 300);
        };

        const updateQuantityDisplay = () => {
            quantityDisplay.textContent = ticketQuantity;
            quantityMinus.disabled = ticketQuantity <= 1;
        };

        const showStep = (step) => {
            if (step === 1) {
                step1.classList.remove('hidden');
                footerStep1.classList.remove('hidden');
                step2.classList.add('hidden');
                footerStep2.classList.add('hidden');
            } else if (step === 2) {
                step1.classList.add('hidden');
                footerStep1.classList.add('hidden');
                step2.classList.remove('hidden');
                footerStep2.classList.remove('hidden');
            }
        };

        const generateParticipantForms = () => {
            formsContainer.innerHTML = '';
            for (let i = 1; i <= ticketQuantity; i++) {
                const formHtml = `
                        <div class="p-4 border rounded-md bg-gray-50" data-participant="${i}">
                            <h4 class="font-semibold text-gray-800">Ingresso ${i}</h4>
                                <div>
                                    <label for="category-${i}" class="block text-sm font-medium text-gray-700">Categoria</label>
                                    <select id="category-${i}" name="category[]" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option value="">Selecione a categoria</option>
                                        <option value="cicloturismo">Cicloturismo - Diversão - R$ 45,90</option>
                                    </select>
                                </div>
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="name-${i}" class="block text-sm font-medium text-gray-700">Nome Completo</label>
                                    <input type="text" id="name-${i}" name="name[]" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Digite o nome completo">
                                </div>
                                <div>
                                    <label for="cpf-${i}" class="block text-sm font-medium text-gray-700">CPF</label>
                                    <input type="text" id="cpf-${i}" name="cpf[]" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="000.000.000-00">
                                </div>
                                <div>
                                    <label for="cpf-${i}" class="block text-sm font-medium text-gray-700">Celular</label>
                                    <input type="text" id="cpf-${i}" name="celular[]" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="000.000.000-00">
                                </div>
                                <div>
                                    <label for="cpf-${i}" class="block text-sm font-medium text-gray-700">Data de nascimento</label>
                                    <input type="date" id="cpf-${i}" name="nascimento[]" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="000.000.000-00">
                                </div>

                            </div>
                        </div>
                    `;
                formsContainer.insertAdjacentHTML('beforeend', formHtml);
            }
        };

        // --- Event Listeners ---

        openModalButtons.forEach(button => button.addEventListener('click', openModal));
        closeModalButton.addEventListener('click', closeModal);
        modalBackdrop.addEventListener('click', closeModal);

        quantityPlus.addEventListener('click', () => {
            ticketQuantity++;
            updateQuantityDisplay();
        });

        quantityMinus.addEventListener('click', () => {
            if (ticketQuantity > 1) {
                ticketQuantity--;
                updateQuantityDisplay();
            }
        });

        continueButton.addEventListener('click', () => {
            generateParticipantForms();
            showStep(2);
        });

        backButton.addEventListener('click', () => {
            showStep(1);
        });

        // --- LÓGICA DE SUBMISSÃO PARA O BACKEND LARAVEL ---
        finishButton.addEventListener('click', async () => {
            const participantForms = formsContainer.querySelectorAll('[data-participant]');
            const participants = [];
            let hasError = false;

            // 1. Coleta e validação dos dados de cada formulário
            participantForms.forEach((pForm, index) => {
                const i = index + 1;
                const nameInput = pForm.querySelector(`#name-${i}`);
                const cpfInput = pForm.querySelector(`#cpf-${i}`);
                const categoryInput = pForm.querySelector(`#category-${i}`);

                // Remove estilos de erro antigos
                [nameInput, cpfInput, categoryInput].forEach(input => input.classList.remove('border-red-500'));

                const name = nameInput.value.trim();
                const cpf = cpfInput.value.trim();
                const category = categoryInput.value;

                if (!name || !cpf || !category) {
                    hasError = true;
                    // Adiciona borda vermelha aos campos vazios
                    if (!name) nameInput.classList.add('border-red-500');
                    if (!cpf) cpfInput.classList.add('border-red-500');
                    if (!category) categoryInput.classList.add('border');
                }

                participants.push({name, cpf, category});
            });

            if (hasError) {
                alert('Por favor, preencha todos os campos destacados em todos os ingressos.');
                return; // Interrompe a execução se houver erro
            }

            // Pega o token CSRF da meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // 2. Envio dos dados para o backend via fetch API
            try {
                finishButton.disabled = true;
                finishButton.innerHTML = '<span class="animate-pulse">Processando...</span>';

                const response = await fetch("{{ route('inscricoes.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        // Você pode passar o ID do evento aqui se necessário
                        evento_id: {{$evento->id}},
                        participants: participants
                    })
                });

                const result = await response.json();

                if (response.ok) {
                    // 3. Redirecionamento para o checkout do Mercado Pago
                    alert("Você será redirecionado para a página de pagamento.");
                    window.location.href = result.redirect_url;
                } else {
                    // Trata erros de validação ou outros erros do servidor
                    const errorMessage = result.message || 'Ocorreu um erro. Verifique os dados e tente novamente.';
                    alert(`Erro: ${errorMessage}`);
                    finishButton.disabled = false;
                    finishButton.textContent = 'Finalizar Inscrição';
                }

            } catch (error) {
                console.error('Erro de comunicação:', error);
                alert('Ocorreu um erro de comunicação com o servidor. Por favor, tente novamente mais tarde.');
                finishButton.disabled = false;
                finishButton.textContent = 'Finalizar Inscrição';
            }
        });

        // Inicializa a exibição da quantidade
        updateQuantityDisplay();
    });
</script>
</body>
</html>
