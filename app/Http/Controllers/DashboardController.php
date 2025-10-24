<?php

namespace App\Http\Controllers;

use App\Models\EventoInscricao;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Exibe a página "Minhas Compras" do usuário.
     *
     * @return \Illuminate\View\View
     */
    public function compras()
    {
        // Pega o ID do usuário autenticado
        $userId = Auth::id();

        // Busca as compras (EventoInscricao) do usuário.
        // Usamos 'with' para carregar os relacionamentos e evitar o problema N+1.
        // Isso carrega o evento de cada compra, e para cada compra, carrega os inscritos,
        // e para cada inscrito, carrega o usuário e a categoria.
        $compras = EventoInscricao::where('usuario_id', $userId)
            ->with([
                       'evento', // Carrega o evento relacionado à compra
                       'inscritos.usuarioModel', // Carrega o usuário de cada ingresso
                       'inscritos.categoria' // Carrega a categoria de cada ingresso
                   ])
            ->orderBy('datacad', 'desc') // Ordena pelas compras mais recentes
            ->get();

        // Retorna a view, passando a coleção de compras
        return view('minha-conta.compras', ['compras' => $compras]);
    }
}
