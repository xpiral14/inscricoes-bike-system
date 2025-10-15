<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EventoEstrutura extends Pivot
{

    protected $table = 'tb_event_structures';

    public function evento()
    {

        return $this->belongsTo(Evento::class, 'event');
    }

    public function estrutura()
    {

        return $this->belongsTo(Estrutura::class, 'structure');
    }
}
