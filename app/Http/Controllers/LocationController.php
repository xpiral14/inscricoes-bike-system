<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{

    public function listaDeCidades($estado)
    {
        return DB::query()->from('tb_cidades')
            ->where('uf', $estado)
            ->orderBy('nome')
            ->get();
    }

    public function listaDeEstados(){
        return DB::query()->from('tb_estados')->orderBy('nome')->get();
    }
}
