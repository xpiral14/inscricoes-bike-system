<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoCupom extends Model
{
    protected $table = 'tb_eventos_cupons';

    public $timestamps = false;
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento');
    }

    public function criador()
    {

        return $this->belongsTo(Usuario::class, 'criadopor');
    }

    public function usuario()
    {

        return $this->belongsTo(Usuario::class, 'usadoPor');
    }
}
