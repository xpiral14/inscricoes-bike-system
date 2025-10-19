<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Publicidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Supondo que você tenha um Model chamado Evento
// use App\Models\Evento;

class EventoController extends Controller
{
    /**
     * Exibe a página de detalhes de um evento específico.
     */
    public function show($eventoUrl)
    {
        // Lógica para buscar o evento no banco de dados pelo slug ou ID
         $evento = Evento::where('url', $eventoUrl)->firstOrFail();

        // Por enquanto, vamos apenas carregar a view
        // return view('eventos.detalhes', ['evento' => $evento]);

        // Como ainda não temos o model, apenas retornamos a view:
        $publicidades = Publicidade::query()->where('cd_area', 9)->get();

        if ($publicidades->isNotEmpty()) {
            $publicidade = $publicidades->random();
        } else {
            $publicidade = null;
        }

        return view('eventos.detalhes', [
            'evento'      => $evento,
            'estados'     => new LocationController()->listaDeEstados(),
            'publicidade' => $publicidade
        ]);
    }

    // Deixe o outro método pronto para a Parte 3
    public function processarInscricao(Request $request)
    {
        return response()->json([['id' => Auth::id()]]);
    }
}
