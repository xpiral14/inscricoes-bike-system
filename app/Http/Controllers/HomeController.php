<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Busca os próximos eventos que tenham um banner definido para o slider principal
        $featuredEvents = Evento::whereNotNull('banner')
            ->where('banner', '!=', '')
            ->where('dataevento', '>=', now())
            ->orderBy('dataevento', 'asc')
            ->take(3)
            ->get();

        // Busca todos os próximos eventos para a grade interativa com JavaScript
        // Selecionamos apenas os campos necessários para otimizar a query
        $allUpcomingEvents = Evento::where('dataevento', '>=', now())
            ->select('titulo as name', 'dataevento as date', 'uf as state', 'banner as image', 'cidade', 'url')
            ->orderBy('dataevento', 'asc')
            ->get()
            ->map(function ($event) {
                // Adiciona um status padrão e formata a data para o JS
                $event->status = 'open';
                $event->date = $event->date->toDateString(); // Formato YYYY-MM-DD
                // Gera um URL para a imagem (assumindo que estão em storage/app/public/banners)
                $event->image = $event->image ? $event->image : 'https://images.unsplash.com/photo-1541625221341-03c748c941d4?q=80&w=1974&auto=format&fit=crop';
                $event->url = route('eventos.show', $event->url);
                return $event;
            });


        // Busca os estados (UF) únicos que possuem eventos futuros
        $states = Evento::where('dataevento', '>=', now())
            ->whereNotNull('uf')
            ->where('uf', '!=', '')
            ->select('uf')
            ->distinct()
            ->orderBy('uf', 'asc')
            ->pluck('uf');

        // Busca os 4 próximos eventos para a lista no final da página
        $listEvents = Evento::where('dataevento', '>=', now())
            ->orderBy('dataevento', 'asc')
            ->take(4)
            ->get();

        return view('home', [
            'featuredEvents' => $featuredEvents,
            'allUpcomingEvents' => $allUpcomingEvents,
            'states' => $states,
            'listEvents' => $listEvents,
        ]);
    }
}
