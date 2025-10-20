<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoCategoria extends Model
{
    protected $table = 'tb_event_categories';
    public $timestamps = false;
    protected $casts = [
        'price' => 'float',
        'ativo' => 'boolean',
        'anoInicial' => 'integer',
        'anoFinal' => 'integer',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'event'); // Assumindo que seu modelo de Evento se chama Evento
    }
}
