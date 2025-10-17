<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth; // <-- NOVO: Importe o Facade Auth

class SessionController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
                               'cpf'        => 'required|min:11|max:11',
                               'nascimento' => 'required|date_format:Y-m-d|max:20',
                           ]);

        $usuario = Usuario::where('data_nascimento', $request->date('nascimento')->startOfDay()->toDateTimeString())
            ->whereRaw("regexp_replace(cpf, '[^0-9]', '') = ?", $request->cpf)
            ->first();

        if (!$usuario) {
            return response()->json([
                                        'erro' => 'Usuário não existe no sistema'
                                    ], Response::HTTP_NOT_FOUND);
        }

        // 1. Autentica o usuário no sistema. O Laravel Sanctum irá definir
        // automaticamente o cookie de sessão para o SPA.
        Auth::login($usuario);

        // 2. Retorna a resposta de sucesso. O cookie será anexado automaticamente.
        return response()->json([
                                    'usuario' => $usuario,
                                    // Removido o envio do token: ele agora está no cookie HTTP-only (sessão)
                                ], Response::HTTP_OK);
    }

    public function register(Request $request)
    {
        $request->validate([
                               'cpf'        => 'required|min:11|max:11|unique:tb_usuarios',
                               'nascimento' => 'required|date_format:Y-m-d|max:20',
                               'email'      => 'required|email|unique:tb_usuarios|max:100',
                               'nome'       => 'required|max:100',
                           ]);

        $usuario                  = new Usuario();
        $usuario->cpf             = $request->cpf;
        $usuario->data_nascimento = $request->date('nascimento')->startOfDay()->toDateTimeString();
        $usuario->email           = $request->email;
        $usuario->nome            = $request->nome;
        $usuario->save();

        // 3. Loga o usuário automaticamente após o registro.
        Auth::login($usuario);

        // 4. Retorna a resposta de sucesso. O cookie de sessão será anexado.
        return response()->json([
                                    'usuario' => $usuario
                                ], Response::HTTP_CREATED); // Use HTTP_CREATED para registro bem-sucedido
    }
}
