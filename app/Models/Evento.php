<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Evento extends Model
{

    /**
     * A tabela associada ao model.
     *
     * @var string
     */
    protected $table = 'tb_eventos';
    public $timestamps = false;
    /**
     * Os atributos que devem ser convertidos para tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'dataevento' => 'datetime',
        'active' => 'integer',
        'escolhercamisas' => 'boolean',
        'permitirinscricao' => 'boolean',
        'date' => 'datetime'
    ];

    /**
     * Relação: Um evento pertence a um organizador (usuário).
     */
    public function organizadorModel(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'organizador');
    }

    /**
     * Relação: Um evento tem muitas inscrições.
     */
    public function inscritos(): HasMany
    {
        return $this->hasMany(EventoInscrito::class, 'evento');
    }

    public function inscricoes(): HasMany
    {
        // O segundo argumento 'evento' é a chave estrangeira na tabela tb_eventos_inscritos
        return $this->hasMany(EventoInscrito::class, 'evento');
    }

    public function pagamentos()
    {
        return $this->hasMany(Log::class, 'cod_transacao');
    }

    public function categorias()
    {
        return $this->hasMany(EventoCategoria::class, 'event');
    }

    public function inicioEvento()
    {
        return $this->dataevento->setTimeFromTimeString($this->horaevento . ':00');
    }

    public function estruturas()
    {
        return $this->belongsToMany(Estrutura::class, EventoEstrutura::class, 'event', 'structure');
    }
}
