<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventoInscricao extends Model
{

    protected $table = 'tb_evento_inscricoes';
    public $timestamps = false;

    public function evento()
    {

        return $this->belongsTo(Evento::class, 'evento_id');
    }

    public function inscritos(): HasMany
    {
        return $this->hasMany(EventoInscrito::class, 'inscricao_id');
    }
}
