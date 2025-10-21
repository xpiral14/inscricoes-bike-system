{{-- resources/views/login.blade.php --}}
@extends('app')

@section('title', 'Login / Cadastro')

@section('content')
    <section class="min-h-[calc(100vh-200px)] flex"> {{-- Ajustei o min-h para considerar header/footer --}}
        <div class="flex-1 grid grid-cols-1 lg:grid-cols-2">
            <div class="hidden lg:block relative">
                <img src="https://images.unsplash.com/photo-1541625602330-2277a4c46182?q=80&w=1974&auto=format=fit=crop" alt="Ciclista em uma estrada de montanha" class="absolute h-full w-full object-cover">
            </div>

            <div class="bg-gray-50 flex items-center justify-center p-4 sm:p-8">
                <div class="w-full max-w-md">
                    <div class="bg-white p-8 rounded-lg shadow-md border border-gray-200">

                        {{-- Tabs (removi a funcionalidade de abas, focando apenas no login) --}}
                        <div class="border-b border-gray-200">
                            <h2 class="py-3 text-center font-semibold text-blue-600 border-b-2 border-blue-600">
                                Acessar sua conta
                            </h2>
                        </div>

                        <div id="login-form" class="mt-8">

                            {{-- Formulário de Login --}}
                            <form method="POST" action="{{ route('login.store') }}" class="mt-6 space-y-6">
                                @csrf  {{-- Token de segurança do Laravel --}}

                                <div>
                                    <label for="email_or_cpf" class="block text-sm font-medium text-gray-700">E-mail ou CPF</label>
                                    <div class="mt-1 relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i data-lucide="user" class="w-5 h-5 text-gray-400"></i>
                                    </span>
                                        <input type="text" name="email_or_cpf" id="email_or_cpf" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="seu@email.com ou 123.456.789-00" value="{{ old('email_or_cpf') }}" required autofocus>
                                    </div>
                                </div>

                                <div>
                                    <label for="data_nascimento" class="block text-sm font-medium text-gray-700">Data de Nascimento</label>
                                    <div class="mt-1 relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i data-lucide="calendar" class="w-5 h-5 text-gray-400"></i>
                                    </span>
                                        {{-- CAMPO DE SENHA ALTERADO PARA DATA DE NASCIMENTO --}}
                                        <input type="date" name="data_nascimento" id="data_nascimento" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                                    </div>
                                </div>

                                {{-- Exibe erro de autenticação, se houver --}}
                                @error('email_or_cpf')
                                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                                @enderror

                                <div>
                                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Entrar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
