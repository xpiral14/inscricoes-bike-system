<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Usuario;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Exibe o formulário de login.
     */
    public function create()
    {
        if(Auth::id()){
            return redirect(route('home'));

        }
        return view('login');
    }

    /**
     * Lida com a tentativa de autenticação.
     */
    public function store(Request $request)
    {
        // 1. Validação dos dados de entrada
        $credentials = $request->validate([
                                              'email_or_cpf' => ['required', 'string'],
                                              'data_nascimento' => ['required', 'date_format:Y-m-d'],
                                          ]);

        // 2. Busca o usuário pelo email OU pelo CPF
        $user = Usuario::where('email', $credentials['email_or_cpf'])
            ->orWhere('cpf', $credentials['email_or_cpf'])
            ->first();

        // 3. Verifica se o usuário existe e se a data de nascimento confere
        // Usamos whereDate para comparar apenas a parte da data, ignorando a hora.
        if ($user && $user->data_nascimento->format('Y-m-d') === $credentials['data_nascimento']) {

            // 4. Autentica o usuário no sistema
            Auth::login($user);

            // 5. Regenera a sessão para segurança
            $request->session()->regenerate();

            // 6. Redireciona para a página inicial
            return redirect()->intended('/');
        }

        // 7. Se a autenticação falhar, retorna com um erro
        throw ValidationException::withMessages([
                                                    'email_or_cpf' => 'As credenciais fornecidas não correspondem aos nossos registros.',
                                                ]);
    }

    /**
     * Faz o logout do usuário.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
