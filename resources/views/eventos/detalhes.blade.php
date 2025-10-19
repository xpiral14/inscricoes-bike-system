@extends('app')

@section('title', "Inscrição {$evento->titulo} - {$evento->cidade}")

@section('content')
    {{-- Conteúdo principal do evento (mantido) --}}
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
@endsection

@section('modal')
    {{-- MODAL REESTRUTURADO --}}
    <div id="registration-modal" class="fixed inset-0 z-[100] hidden opacity-0" aria-labelledby="modal-title"
         role="dialog"
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

                {{-- PASSO 1: AUTENTICAÇÃO --}}
                <div id="step-1-auth">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Passo 1: Login ou Cadastro</h3>

                    {{-- FORMULÁRIO DE LOGIN (CPF / DATA NASC.) --}}
                    <div id="login-form-container"
                         class="bg-white p-4 rounded-lg shadow-md border border-gray-200 mb-6">
                        <h4 class="font-bold text-gray-900 mb-4">Já sou cliente</h4>
                        <form id="login-form">
                            <div class="mb-4">
                                <label for="login-cpf" class="block text-sm font-medium text-gray-700">CPF</label>
                                <input type="text" id="login-cpf" name="cpf" required
                                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                       placeholder="000.000.000-00">
                            </div>
                            <div class="mb-6">
                                <label for="login-nascimento" class="block text-sm font-medium text-gray-700">Data de
                                    Nascimento</label>
                                <input type="date" id="login-nascimento" name="nascimento" required
                                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <button type="submit" id="login-submit-button"
                                    class="w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-md transition-colors">
                                Fazer Login
                            </button>
                        </form>
                    </div>

                    {{-- CONTROLES DE REGISTRO/VOLTAR --}}
                    <div id="register-toggle-controls" class="text-center mb-4">
                        <p id="register-text" class="text-gray-600 mb-2">Não tem conta?</p>
                        <button id="toggle-register-button"
                                class="text-blue-600 hover:text-blue-800 font-semibold transition-colors">
                            Quero me Registrar
                        </button>
                    </div>

                    {{-- FORMULÁRIO DE REGISTRO RÁPIDO (ESCONDIDO) --}}
                    <div id="register-form-container"
                         class="bg-white p-4 rounded-lg shadow-md border border-gray-200 hidden">
                        <h4 class="font-bold text-gray-900 mb-4">Cadastro Rápido</h4>
                        <form id="register-form">
                            <div class="mb-4">
                                <label for="register-name" class="block text-sm font-medium text-gray-700">Nome
                                    Completo</label>
                                <input type="text" id="register-name" name="name" required
                                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                       placeholder="Nome completo">
                            </div>
                            <div class="mb-4">
                                <label for="register-email"
                                       class="block text-sm font-medium text-gray-700">E-mail</label>
                                <input type="email" id="register-email" name="email" required
                                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                       placeholder="seu.email@exemplo.com">
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="register-cpf"
                                           class="block text-sm font-medium text-gray-700">CPF</label>
                                    <input type="text" id="register-cpf" name="cpf" required
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                           placeholder="000.000.000-00">
                                </div>
                                <div>
                                    <label for="register-nascimento" class="block text-sm font-medium text-gray-700">Data
                                        de Nascimento</label>
                                    <input type="date" id="register-nascimento" name="nascimento" required
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                            </div>
                            <button type="submit" id="register-submit-button"
                                    class="w-full px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-md transition-colors">
                                Registrar e Continuar
                            </button>
                        </form>
                    </div>

                </div>

                {{-- PASSO 2: DETALHES DOS PARTICIPANTES (ANTIGO STEP 1) --}}
                <div id="step-2-forms" class="hidden">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Passo 2: Detalhes dos Participantes</h3>
                    <div id="participant-forms-container" class="space-y-6">
                        {{-- Formulários serão gerados aqui pelo JS --}}
                    </div>
                    <button id="add-participant-button"
                            class="mt-6 w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                        Adicionar Ingresso
                    </button>
                </div>

                {{-- PASSO 3: RESUMO DA COMPRA (ANTIGO STEP 2) --}}
                <div id="step-3-summary" class="hidden">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Passo 3: Resumo do Pedido</h3>
                    <div id="summary-container" class="space-y-4">
                        {{-- Resumo será gerado aqui pelo JS --}}
                    </div>
                </div>
            </div>

            <div class="p-4 bg-gray-50 border-t border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <p class="text-xl font-semibold text-gray-900">Valor Total:</p>
                    <p id="total-price-display" class="text-2xl font-bold text-blue-600">R$ 0,00</p>
                </div>

                {{-- FOOTERS DOS PASSOS --}}

                {{-- Footer para o Passo 1 (Autenticação) - Vazio --}}
                <div id="footer-step-1-buttons" class="hidden"></div>

                {{-- Footer para o Passo 2 (Formulários) --}}
                <div id="footer-step-2-buttons" class="hidden">
                    <button id="next-to-summary-button"
                            class="w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-md transition-colors">
                        Avançar para o Resumo
                    </button>
                </div>

                {{-- Footer para o Passo 3 (Resumo) --}}
                <div id="footer-step-3-buttons" class="hidden flex items-center gap-4">
                    <button id="back-to-forms-button"
                            class="w-1/3 px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold rounded-md transition-colors">
                        Voltar
                    </button>
                    <button id="finish-payment-button"
                            class="w-2/3 px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-md transition-colors">
                        Ir para o Pagamento
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Dados das categorias para facilitar o cálculo
        const eventCategories = {
            @foreach($evento->categorias as $categoria)
                {{$categoria->id}}: {
                name: "{{$categoria->name}}",
                price: {{number_format($categoria->price, 2, '.', '')}}
            },
            @endforeach
        };

        // VARIÁVEL DE AUTENTICAÇÃO INJETADA PELO BLADE
        let apiToken = @json(Auth::check());

        // Funções de Máscara (Mantidas)
        const applyMasks = (participantId) => {
            const cpfInput = document.getElementById(`cpf-${participantId}`);
            const celularInput = document.getElementById(`celular-${participantId}`);

            if (cpfInput) {
                IMask(cpfInput, {mask: '000.000.000-00'});
            }

            if (celularInput) {
                const phoneMask = {
                    mask: [
                        {mask: '(00) 0000-0000'},
                        {mask: '(00) 90000-0000'}
                    ]
                };
                IMask(celularInput, phoneMask);
            }
        };

        const applyAuthMasks = () => {
            const loginCpf = document.getElementById('login-cpf');
            const registerCpf = document.getElementById('register-cpf');

            if (loginCpf) IMask(loginCpf, {mask: '000.000.000-00'});
            if (registerCpf) IMask(registerCpf, {mask: '000.000.000-00'});
        };

        // NOVA FUNÇÃO para buscar e preencher as cidades
        const fetchCities = async (estadoSelect, cidadeSelect) => {
            const estado = estadoSelect.value;
            cidadeSelect.innerHTML = '<option value="">Carregando cidades...</option>';
            cidadeSelect.disabled = true;

            if (!estado) {
                cidadeSelect.innerHTML = '<option value="">Selecione a UF primeiro</option>';
                cidadeSelect.disabled = false;
                return;
            }

            try {
                // Rota da API para buscar cidades por estado
                const url = `/api/cidades/${estado}`;

                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                    }
                });

                if (!response.ok) {
                    throw new Error('Falha ao carregar as cidades.');
                }

                const cidades = await response.json();

                cidadeSelect.innerHTML = '<option value="">Selecione a cidade</option>'; // Limpa e adiciona o placeholder

                if (cidades.length > 0) {
                    cidades.forEach(cidade => {
                        const option = document.createElement('option');
                        option.value = cidade.nome; // Supondo que a coluna do nome da cidade seja 'nome'
                        option.textContent = cidade.nome;
                        cidadeSelect.appendChild(option);
                    });
                } else {
                    cidadeSelect.innerHTML = '<option value="">Nenhuma cidade encontrada</option>';
                }
                cidadeSelect.disabled = false;

            } catch (error) {
                console.error('Erro ao buscar cidades:', error);
                cidadeSelect.innerHTML = '<option value="">Erro ao carregar</option>';
                cidadeSelect.disabled = false;
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
            const summaryContainer = document.getElementById('summary-container');
            const totalPriceDisplay = document.getElementById('total-price-display');

            // Passos
            const step1Auth = document.getElementById('step-1-auth');
            const step2Forms = document.getElementById('step-2-forms');
            const step3Summary = document.getElementById('step-3-summary');

            // Botões de navegação
            const addParticipantButton = document.getElementById('add-participant-button');
            const nextToSummaryButton = document.getElementById('next-to-summary-button');
            const backToFormsButton = document.getElementById('back-to-forms-button');
            const finishPaymentButton = document.getElementById('finish-payment-button');

            const footerStep2Buttons = document.getElementById('footer-step-2-buttons');
            const footerStep3Buttons = document.getElementById('footer-step-3-buttons');

            // Elementos do Passo 1
            const loginFormContainer = document.getElementById('login-form-container');
            const showRegisterButton = document.getElementById('toggle-register-button'); // Renomeado no HTML
            const registerFormContainer = document.getElementById('register-form-container');
            const registerToggleControls = document.getElementById('register-toggle-controls');
            const registerText = document.getElementById('register-text');

            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            const loginSubmitButton = document.getElementById('login-submit-button');
            const registerSubmitButton = document.getElementById('register-submit-button');


            let participantCount = 0;
            let participantsData = [];
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


            const openModal = () => {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                    modalPanel.classList.remove('translate-x-full');
                }, 10);

                if (participantCount === 0) {
                    addParticipantForm();
                }

                applyAuthMasks();

                // Garante que o estado de Login/Registro esteja correto ao abrir
                loginFormContainer.classList.remove('hidden');
                registerFormContainer.classList.add('hidden');
                registerText.textContent = 'Não tem conta?';
                showRegisterButton.textContent = 'Quero me Registrar';


                showStep(apiToken ? 2 : 1);
                updateTotalPrice();
            };

            const closeModal = () => {
                modal.classList.add('opacity-0');
                modalPanel.classList.add('translate-x-full');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            };

            const showStep = (step) => {
                // Esconde todos os passos e footers
                step1Auth.classList.add('hidden');
                step2Forms.classList.add('hidden');
                step3Summary.classList.add('hidden');
                footerStep2Buttons.classList.add('hidden');
                footerStep3Buttons.classList.add('hidden');

                // Mostra o passo desejado
                if (step === 1) {
                    step1Auth.classList.remove('hidden');
                    document.getElementById('modal-title').textContent = `Inscrição para ${"{{$evento->titulo}}"} (Passo 1/3 - Autenticação)`;
                } else if (step === 2) {
                    step2Forms.classList.remove('hidden');
                    footerStep2Buttons.classList.remove('hidden');
                    document.getElementById('modal-title').textContent = `Inscrição para ${"{{$evento->titulo}}"} (Passo 2/3 - Ingressos)`;
                } else if (step === 3) {
                    step3Summary.classList.remove('hidden');
                    footerStep3Buttons.classList.remove('hidden');
                    document.getElementById('modal-title').textContent = `Inscrição para ${"{{$evento->titulo}}"} (Passo 3/3 - Resumo)`;
                }
            };

            // --- Funções de Ingresso e Resumo (Mantidas) ---

            const updateTotalPrice = () => {
                let total = 0.00;
                const categorySelectors = formsContainer.querySelectorAll('select[name="category[]"]');

                categorySelectors.forEach(select => {
                    const categoryId = select.value;
                    if (categoryId && eventCategories[categoryId]) {
                        total += eventCategories[categoryId].price;
                    }
                });

                totalPriceDisplay.textContent = `R$ ${total.toLocaleString('pt-BR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })}`;
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
                    formsContainer.querySelectorAll('[data-participant]').forEach((form, index) => {
                        const newIndex = index + 1;
                        const oldId = form.getAttribute('data-participant');
                        form.setAttribute('data-participant', newIndex);
                        form.querySelector('.participant-title').textContent = `Ingresso ${newIndex}`;
                        form.querySelectorAll('[id^="category-"], [id^="name-"], [id^="cpf-"], [id^="celular-"], [id^="nascimento-"], [id^="estado-"], [id^="cidade-"]').forEach(element => {
                            const newId = element.id.replace(`-${oldId}`, `-${newIndex}`);
                            element.id = newId;
                            const label = form.querySelector(`label[for="${element.id}"]`);
                            if (label) label.setAttribute('for', newId);
                        });
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
            <div class="participant-fields hidden">
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
                                <label for="celular-${i}" class="block text-sm font-medium text-gray-700">Celular</label>
                                <input type="text" id="celular-${i}" name="celular[]" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="(00) 9 0000-0000">
                            </div>
                            <div>
                                <label for="nascimento-${i}" class="block text-sm font-medium text-gray-700">Data de nascimento</label>
                                <input type="date" id="nascimento-${i}" name="nascimento[]" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div class="mt-2">
                                        <label for="estado-${i}" class="block text-sm font-medium text-gray-700">Estado</label>
                                        <select id="estado-${i}" name="estado[]" class="estado-select mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                            <option value="">Selecione a UF</option>
                                            @foreach($estados as $estado)
                <option value="{{$estado->nome}}">{{strtoupper($estado->nome)}}</option>
                                            @endforeach
                </select>
            </div>
            <div class="mt-2">
                        <label for="cidade-${i}" class="block text-sm font-medium text-gray-700">Cidade</label>
                                        <select id="cidade-${i}" name="cidade[]" class="cidade-select mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                            <option value="">Selecione a UF primeiro</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            `;
                formsContainer.insertAdjacentHTML('beforeend', formHtml);
                lucide.createIcons();
                applyMasks(i);

                // Referências aos novos selects de Estado e Cidade
                const estadoSelect = formsContainer.querySelector(`#estado-${i}`);
                const cidadeSelect = formsContainer.querySelector(`#cidade-${i}`);

                // Inicializa o campo de cidade (estado inicial desabilitado com mensagem)
                cidadeSelect.disabled = true;

                // Listener para o select de Estado
                estadoSelect.addEventListener('change', () => {
                    fetchCities(estadoSelect, cidadeSelect);
                });


                const newSelect = formsContainer.querySelector(`#category-${i}`);
                newSelect.addEventListener('change', (e) => {
                    const isCategorySelected = !!e.target.value;
                    toggleParticipantFields(i, isCategorySelected);
                    updateTotalPrice();
                });

                const removeButton = formsContainer.querySelector(`button[data-remove-id="${i}"]`);
                removeButton.addEventListener('click', (e) => {
                    if (participantCount > 1) {
                        removeParticipantForm(e.currentTarget.getAttribute('data-remove-id'));
                    } else {
                        alert('Pelo menos um ingresso é obrigatório.');
                    }
                });
            };

            const collectAndValidateParticipants = () => {
                const participantForms = formsContainer.querySelectorAll('[data-participant]');
                participantsData = [];
                let hasError = false;

                participantForms.forEach((pForm, index) => {
                    pForm.querySelectorAll('input, select').forEach(input => input.classList.remove('border-red-500'));

                    const categoryInput = pForm.querySelector('select[name="category[]"]');
                    const nameInput = pForm.querySelector('input[name="name[]"]');
                    const cpfInput = pForm.querySelector('input[name="cpf[]"]');
                    const celularInput = pForm.querySelector('input[name="celular[]"]');
                    const nascimentoInput = pForm.querySelector('input[name="nascimento[]"]');
                    const estadoInput = pForm.querySelector('select[name="estado[]"]');
                    const cidadeInput = pForm.querySelector('select[name="cidade[]"]');

                    const category = categoryInput.value;

                    if (category) {
                        const name = nameInput.value.trim();
                        const cpf = cpfInput.value.trim();
                        const celular = celularInput.value.trim();
                        const nascimento = nascimentoInput.value;
                        const estado = estadoInput.value;
                        const cidade = cidadeInput.value;


                        const cleanedCpf = cpf.replace(/\D/g, '');
                        const cleanedCelular = celular.replace(/\D/g, '');

                        // Validação: Verifique todos os campos obrigatórios
                        if (!name || !cpf || !celular || !nascimento || cleanedCpf.length !== 11 || cleanedCelular.length < 10 || !estado || !cidade) {
                            hasError = true;
                            if (!name) nameInput.classList.add('border-red-500');
                            if (!cpf || cleanedCpf.length !== 11) cpfInput.classList.add('border-red-500');
                            if (!celular || cleanedCelular.length < 10) celularInput.classList.add('border-red-500');
                            if (!nascimento) nascimentoInput.classList.add('border-red-500');
                            if (!estado) estadoInput.classList.add('border-red-500');
                            if (!cidade) cidadeInput.classList.add('border-red-500');
                        }

                        participantsData.push({
                            category,
                            name,
                            cpf: cleanedCpf,
                            celular: cleanedCelular,
                            nascimento,
                            estado, // Adicionado estado
                            cidade, // Adicionado cidade
                            price: eventCategories[category] ? eventCategories[category].price : 0,
                            category_name: eventCategories[category] ? eventCategories[category].name : 'N/A'
                        });
                    } else {
                        hasError = true;
                        categoryInput.classList.add('border-red-500');
                    }
                });

                return !hasError;
            };

            const generateSummary = () => {
                summaryContainer.innerHTML = '';

                participantsData.forEach((p, index) => {
                    const summaryItem = `
                    <div class="p-4 border rounded-md bg-white shadow-sm">
                        <h4 class="font-bold text-gray-900 mb-2">Ingresso ${index + 1}: ${p.category_name}</h4>
                        <div class="text-sm text-gray-700 space-y-1">
                            <p><strong>Nome:</strong> ${p.name}</p>
                            <p><strong>CPF:</strong> ${p.cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4')}</p>
                            <p><strong>Localidade:</strong> ${p.cidade} (${p.estado})</p>
                            <p><strong>Valor:</strong> R$ ${p.price.toLocaleString('pt-BR', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })}</p>
                        </div>
                    </div>
                `;
                    summaryContainer.insertAdjacentHTML('beforeend', summaryItem);
                });
            };

            // --- EVENT LISTENERS GERAIS ---

            openModalButtons.forEach(button => button.addEventListener('click', openModal));
            closeModalButton.addEventListener('click', closeModal);
            modalBackdrop.addEventListener('click', closeModal);
            addParticipantButton.addEventListener('click', addParticipantForm);

            // --- LÓGICA DO PASSO 1: AUTENTICAÇÃO E REGISTRO ---

            // Alterna a exibição do formulário de registro
            showRegisterButton.addEventListener('click', (e) => {
                e.preventDefault();
                const isShowingRegister = registerFormContainer.classList.contains('hidden');

                if (isShowingRegister) {
                    // Mudar para tela de Registro
                    loginFormContainer.classList.add('hidden');
                    registerFormContainer.classList.remove('hidden');
                    registerText.textContent = 'Já sou cliente?';
                    showRegisterButton.textContent = 'Voltar ao Login';
                } else {
                    // Voltar para tela de Login
                    registerFormContainer.classList.add('hidden');
                    loginFormContainer.classList.remove('hidden');
                    registerText.textContent = 'Não tem conta?';
                    showRegisterButton.textContent = 'Quero me Registrar';
                }
            });

            // Submissão do formulário de LOGIN
            loginForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const cpf = document.getElementById('login-cpf').value.replace(/\D/g, '');
                const nascimento = document.getElementById('login-nascimento').value;

                if (cpf.length !== 11 || !nascimento) {
                    alert('Por favor, preencha o CPF e a Data de Nascimento corretamente.');
                    return;
                }

                loginSubmitButton.disabled = true;
                loginSubmitButton.innerHTML = '<span class="animate-pulse">Autenticando...</span>';

                try {
                    // Usamos o X-CSRF-TOKEN da meta tag. O navegador envia o cookie de sessão automaticamente.
                    const response = await fetch("{{ route('api.login') }}", {
                        method: 'POST',
                        credentials: 'include',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({cpf: cpf, nascimento: nascimento})
                    });

                    if (response.ok) {
                        apiToken = true; // Atualiza o estado para "autenticado"
                        showStep(2); // Avança para a seleção de ingressos
                        alert('Login realizado com sucesso! Prossiga com sua inscrição.');
                    } else {
                        const result = await response.json(); // Tenta ler a mensagem de erro
                        alert(result.erro || result.message || 'Login falhou. Verifique suas credenciais.');
                    }
                } catch (error) {
                    alert('Erro de comunicação com o servidor.');
                } finally {
                    loginSubmitButton.disabled = false;
                    loginSubmitButton.textContent = 'Fazer Login';
                }
            });

            // Submissão do formulário de REGISTRO
            registerForm.addEventListener('submit', async (e) => {
                e.preventDefault();

                const name = document.getElementById('register-name').value.trim();
                const email = document.getElementById('register-email').value.trim();
                const cpf = document.getElementById('register-cpf').value.replace(/\D/g, '');
                const nascimento = document.getElementById('register-nascimento').value;

                if (!name || !email || cpf.length !== 11 || !nascimento) {
                    alert('Por favor, preencha todos os campos do cadastro corretamente.');
                    return;
                }

                registerSubmitButton.disabled = true;
                registerSubmitButton.innerHTML = '<span class="animate-pulse">Registrando...</span>';

                try {
                    // Usamos o X-CSRF-TOKEN da meta tag. O navegador envia o cookie de sessão automaticamente.
                    const response = await fetch("{{ route('api.register') }}", {
                        method: 'POST',
                        credentials: 'include',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({name: name, email: email, cpf: cpf, nascimento: nascimento})
                    });

                    if (response.ok) {
                        apiToken = true; // Atualiza o estado para "autenticado"
                        showStep(2); // Avança para a seleção de ingressos
                        alert('Cadastro e Login realizados com sucesso! Prossiga com sua inscrição.');
                    } else {
                        const result = await response.json();
                        alert(result.message || 'Falha no cadastro. Tente outro CPF ou E-mail.');
                    }
                } catch (error) {
                    alert('Erro de comunicação com o servidor durante o registro.');
                } finally {
                    registerSubmitButton.disabled = false;
                    registerSubmitButton.textContent = 'Registrar e Continuar';
                }
            });


            // --- Lógica de Passos (Mantida) ---

            nextToSummaryButton.addEventListener('click', () => {
                if (collectAndValidateParticipants()) {
                    generateSummary();
                    showStep(3);
                } else {
                    alert('Por favor, preencha todos os campos corretamente em todos os ingressos.');
                }
            });

            backToFormsButton.addEventListener('click', () => {
                showStep(2);
            });

            // --- LÓGICA DE SUBMISSÃO FINAL (MERCADO PAGO) ---
            finishPaymentButton.addEventListener('click', async () => {
                if (participantsData.length === 0) return;

                const submissionData = participantsData.map(p => ({
                    category: p.category,
                    name: p.name,
                    cpf: p.cpf,
                    celular: p.celular,
                    nascimento: p.nascimento,
                    estado: p.estado,
                    cidade: p.cidade,
                }));

                try {
                    finishPaymentButton.disabled = true;
                    finishPaymentButton.innerHTML = '<span class="animate-pulse">Redirecionando...</span>';

                    // Aqui, a requisição confia no cookie de sessão definido pelo login/registro
                    const response = await fetch("{{ route('inscricoes.store') }}", {
                        method: 'POST',
                        credentials: 'include', // Assegura que o cookie de sessão seja enviado
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken, // Usa o token da meta tag
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            evento_id: {{$evento->id}},
                            participants: submissionData
                        })
                    });

                    const result = await response.json();

                    if (response.ok) {
                        alert(result.id)
                        window.location.href = result.redirect_url;
                    } else {
                        const errorMessage = result.message || 'Ocorreu um erro ao processar a inscrição. Tente novamente.';
                        alert(`Erro: ${errorMessage}`);
                        finishPaymentButton.disabled = false;
                        finishPaymentButton.textContent = 'Ir para o Pagamento';
                    }

                } catch (error) {
                    console.error('Erro de comunicação:', error);
                    alert('Ocorreu um erro de comunicação com o servidor. Tente novamente mais tarde.');
                    finishPaymentButton.disabled = false;
                    finishPaymentButton.textContent = 'Ir para o Pagamento';
                }
            });

            // Inicializa o primeiro formulário e a exibição do passo
            if (participantCount === 0) {
                addParticipantForm();
            }
            applyAuthMasks();
            showStep(apiToken ? 2 : 1);
        });
    </script>
@endsection
