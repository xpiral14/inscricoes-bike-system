<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Inscrição {{$evento->titulo}} -{{ $evento->cidade}}</title>

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
                    <div class="mb-4 max-h-[300px] overflow-y-auto">

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

{{-- MODAL REESTRUTURADO --}}
<div id="registration-modal" class="fixed inset-0 z-[100] hidden opacity-0" aria-labelledby="modal-title" role="dialog"
     aria-modal="true">
    <div id="modal-backdrop" class="fixed inset-0 bg-black/60"></div>

    <div id="modal-panel"
         class="fixed top-0 right-0 h-full w-full max-w-lg bg-white shadow-xl transform translate-x-full flex flex-col">
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <h2 id="modal-title" class="text-xl font-bold text-gray-900">Inscrição para {{$evento->titulo}}</h2>
            <button id="close-modal-button" class="p-1 rounded-full hover:bg-gray-200">
                <i data-lucide="x" class="w-6 h-6 text-gray-600"></i>
            </button>
        </div>

        <div class="flex-grow p-6 overflow-y-auto">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Detalhes dos Participantes</h3>
            <div id="participant-forms-container" class="space-y-6">
                {{-- Formulários serão gerados aqui pelo JS --}}
            </div>
            <button id="add-participant-button"
                    class="mt-6 w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                Adicionar Ingresso
            </button>
        </div>

        <div class="p-4 bg-gray-50 border-t border-gray-200">
            <div class="flex justify-between items-center mb-4">
                <p class="text-xl font-semibold text-gray-900">Valor Total:</p>
                <p id="total-price-display" class="text-2xl font-bold text-blue-600">R$ 0,00</p>
            </div>
            <button id="finish-button"
                    class="w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-md transition-colors">
                Finalizar Inscrição
            </button>
        </div>
    </div>
</div>


<script>
    // Inicializa os ícones da biblioteca Lucide
    lucide.createIcons();

    // Dados das categorias para facilitar o cálculo
    const eventCategories = {
        @foreach($evento->categorias as $categoria)
            {{$categoria->id}}: {
            name: "{{$categoria->name}}",
            price: {{number_format($categoria->price, 2, '.', '')}}
        },
        @endforeach
    };

    // Função para aplicar as máscaras
    const applyMasks = (participantId) => {
        const cpfInput = document.getElementById(`cpf-${participantId}`);
        const celularInput = document.getElementById(`celular-${participantId}`);

        if (cpfInput) {
            IMask(cpfInput, {
                mask: '000.000.000-00'
            });
        }

        if (celularInput) {
            // Máscara flexível para (00) 9000-0000 e (00) 9 0000-0000
            const phoneMask = {
                mask: [
                    {
                        mask: '(00) 0000-0000'
                    },
                    {
                        mask: '(00) 90000-0000'
                    }
                ]
            };
            IMask(celularInput, phoneMask);
        }
    };


    // Garante que o script rode após o carregamento do DOM
    document.addEventListener('DOMContentLoaded', () => {
        // Seleção dos elementos do DOM
        const modal = document.getElementById('registration-modal');
        const modalPanel = document.getElementById('modal-panel');
        const modalBackdrop = document.getElementById('modal-backdrop');
        const openModalButtons = document.querySelectorAll('.open-modal-button');
        const closeModalButton = document.getElementById('close-modal-button');
        const formsContainer = document.getElementById('participant-forms-container');
        const finishButton = document.getElementById('finish-button');
        const addParticipantButton = document.getElementById('add-participant-button');
        const totalPriceDisplay = document.getElementById('total-price-display');

        let participantCount = 0; // Contador para rastrear os participantes

        const openModal = () => {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalPanel.classList.remove('translate-x-full');
            }, 10);
            // Garante que haja pelo menos 1 formulário ao abrir
            if (participantCount === 0) {
                addParticipantForm();
            }
            updateTotalPrice();
        };

        const closeModal = () => {
            modal.classList.add('opacity-0');
            modalPanel.classList.add('translate-x-full');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        };

        const updateTotalPrice = () => {
            let total = 0.00;
            const categorySelectors = formsContainer.querySelectorAll('select[name="category[]"]');

            categorySelectors.forEach(select => {
                const categoryId = select.value;
                if (categoryId && eventCategories[categoryId]) {
                    total += eventCategories[categoryId].price;
                }
            });

            // Formata o valor total para R$ X.XXX,XX
            totalPriceDisplay.textContent = `R$ ${total.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
        };

        const toggleParticipantFields = (participantId, isVisible) => {
            const participantForm = document.querySelector(`[data-participant="${participantId}"]`);
            if (participantForm) {
                const fieldsDiv = participantForm.querySelector('.participant-fields');
                if (isVisible) {
                    fieldsDiv.classList.remove('hidden');
                } else {
                    fieldsDiv.classList.add('hidden');
                }
            }
        };

        const removeParticipantForm = (participantId) => {
            const formToRemove = document.querySelector(`[data-participant="${participantId}"]`);
            if (formToRemove) {
                formToRemove.remove();
                participantCount--;
                // Renumera os títulos e IDs dos formulários restantes
                formsContainer.querySelectorAll('[data-participant]').forEach((form, index) => {
                    const newIndex = index + 1;
                    const oldId = form.getAttribute('data-participant');
                    form.setAttribute('data-participant', newIndex);
                    form.querySelector('.participant-title').textContent = `Ingresso ${newIndex}`;

                    // Atualiza IDs e 'for' de labels para evitar conflitos
                    form.querySelectorAll('[id^="category-"], [id^="name-"], [id^="cpf-"], [id^="celular-"], [id^="nascimento-"]').forEach(element => {
                        const newId = element.id.replace(`-${oldId}`, `-${newIndex}`); // Usa o índice como parte do ID
                        element.id = newId;
                        const label = form.querySelector(`label[for="${element.id}"]`);
                        if(label) label.setAttribute('for', newId);
                    });

                    // Atualiza o data-remove-id
                    form.querySelector('.remove-participant-button').setAttribute('data-remove-id', newIndex);
                });
                updateTotalPrice();
            }
        };

        const addParticipantForm = () => {
            participantCount++;
            const i = participantCount;

            const formHtml = `
                <div class="p-4 border rounded-md bg-gray-50 relative" data-participant="${i}">
                    <button type="button" class="remove-participant-button absolute top-3 right-3 p-1 rounded-full text-gray-400 hover:text-red-600 transition-colors" data-remove-id="${i}" aria-label="Remover ingresso ${i}">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                    <h4 class="font-semibold text-gray-800 participant-title">Ingresso ${i}</h4>
                    <div class="mt-2">
                        <label for="category-${i}" class="block text-sm font-medium text-gray-700">Categoria</label>
                        <select id="category-${i}" name="category[]" class="category-select mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">Selecione a categoria</option>
                            @foreach($evento->categorias as $categoria)
            <option value="{{$categoria->id}}" data-price="{{number_format($categoria->price, 2, '.', '')}}">{{$categoria->name}} (R$ {{number_format($categoria->price, 2, ',', '.')}})</option>
                            @endforeach
            </select>
        </div>
        <div class="participant-fields hidden"> <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="name-${i}" class="block text-sm font-medium text-gray-700">Nome Completo</label>
                                <input type="text" id="name-${i}" name="name[]" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Digite o nome completo">
                            </div>
                            <div>
                                <label for="cpf-${i}" class="block text-sm font-medium text-gray-700">CPF</label>
                                <input type="text" id="cpf-${i}" name="cpf[]" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="000.000.000-00">
                            </div>
                            <div>
                                <label for="celular-${i}" class="block text-sm font-medium text-gray-700">Celular</label>
                                <input type="text" id="celular-${i}" name="celular[]" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="(00) 9 0000-0000">
                            </div>
                            <div>
                                <label for="nascimento-${i}" class="block text-sm font-medium text-gray-700">Data de nascimento</label>
                                <input type="date" id="nascimento-${i}" name="nascimento[]" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                        </div>
                    </div>
                </div>
            `;
            formsContainer.insertAdjacentHTML('beforeend', formHtml);
            // Re-inicializa os ícones Lucide para o novo elemento
            lucide.createIcons();

            // *** Aplica as máscaras aos novos campos ***
            applyMasks(i);

            // Adiciona listeners para o select da categoria e o botão de remover
            const newSelect = formsContainer.querySelector(`#category-${i}`);

            // Listener para alternar os campos e atualizar o preço
            newSelect.addEventListener('change', (e) => {
                const isCategorySelected = !!e.target.value;
                toggleParticipantFields(i, isCategorySelected);
                updateTotalPrice();
            });

            const removeButton = formsContainer.querySelector(`button[data-remove-id="${i}"]`);
            removeButton.addEventListener('click', (e) => {
                // A remoção só é permitida se houver mais de um participante
                if (participantCount > 1) {
                    removeParticipantForm(e.currentTarget.getAttribute('data-remove-id'));
                } else {
                    alert('Pelo menos um ingresso é obrigatório.');
                }
            });
        };

        // --- Event Listeners de Abertura/Fechamento e Adicionar Ingresso ---

        openModalButtons.forEach(button => button.addEventListener('click', openModal));
        closeModalButton.addEventListener('click', closeModal);
        modalBackdrop.addEventListener('click', closeModal);
        addParticipantButton.addEventListener('click', addParticipantForm);

        // --- LÓGICA DE SUBMISSÃO PARA O BACKEND LARAVEL ---
        finishButton.addEventListener('click', async () => {
            const participantForms = formsContainer.querySelectorAll('[data-participant]');
            const participants = [];
            let hasError = false;

            // 1. Coleta e validação dos dados de cada formulário
            participantForms.forEach((pForm, index) => {
                // Limpa estilos de erro antigos
                pForm.querySelectorAll('input, select').forEach(input => input.classList.remove('border-red-500'));

                const categoryInput = pForm.querySelector('select[name="category[]"]');
                const category = categoryInput.value;

                // Só tenta pegar os dados dos campos se a categoria estiver selecionada
                if (category) {
                    const nameInput = pForm.querySelector('input[name="name[]"]');
                    const cpfInput = pForm.querySelector('input[name="cpf[]"]');
                    const celularInput = pForm.querySelector('input[name="celular[]"]');
                    const nascimentoInput = pForm.querySelector('input[name="nascimento[]"]');

                    const name = nameInput.value.trim();
                    const cpf = cpfInput.value.trim();
                    const celular = celularInput.value.trim();
                    const nascimento = nascimentoInput.value;

                    // Validação de campos obrigatórios
                    if (!name || !cpf || !celular || !nascimento) {
                        hasError = true;
                        // Adiciona borda vermelha aos campos vazios
                        if (!name) nameInput.classList.add('border-red-500');
                        if (!cpf) cpfInput.classList.add('border-red-500');
                        if (!celular) celularInput.classList.add('border-red-500');
                        if (!nascimento) nascimentoInput.classList.add('border-red-500');
                    }

                    // Validação de formato (opcional, mas bom para garantir)
                    if (cpf.length !== 14) { // Verifica se a máscara de 000.000.000-00 foi preenchida
                        hasError = true;
                        cpfInput.classList.add('border-red-500');
                    }
                    if (celular.length < 14) { // Verifica se pelo menos o formato (00) 0000-0000 foi preenchido
                        hasError = true;
                        celularInput.classList.add('border-red-500');
                    }


                    participants.push({
                        category,
                        name,
                        // Envia os valores sem formatação para o backend
                        cpf: cpf.replace(/\D/g, ''),
                        celular: celular.replace(/\D/g, ''),
                        nascimento
                    });
                } else {
                    hasError = true;
                    categoryInput.classList.add('border-red-500');
                }
            });

            if (hasError) {
                alert('Por favor, selecione a categoria e preencha todos os campos corretamente em todos os ingressos.');
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

        // Inicializa o primeiro formulário (ele estará no DOM mas escondido)
        if (participantCount === 0) {
            addParticipantForm();
        }
    });
</script>
</body>
</html>
