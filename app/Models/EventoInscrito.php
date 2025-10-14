<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoInscrito extends Model
{
    protected $table = 'tb_eventos_inscritos';

    public $timestamps = false;

    public function usuarioModel()
    {
        return $this->belongsTo(Usuario::class, 'usuario');
    }

    public function situacaoModel()
    {
        return $this->belongsTo(EventoInscritoSituacao::class, 'situacao');
    }

    public function categoria()
    {
        return $this->belongsTo(EventoCategoria::class, 'categoryID');
    }

    public function eventoModel()
    {
        return $this->belongsTo(Evento::class, 'evento');
    }
}
