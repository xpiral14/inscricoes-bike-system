<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Usuario extends Authenticatable
{
    use HasApiTokens;
    protected $table = 'tb_usuarios';

    public $timestamps = false;
    public function configuracao(): HasOne
    {
        return $this->hasOne(UsuarioConfig::class, 'usuario');
    }

    public function inscricoes()
    {
        return $this->hasMany(EventoInscrito::class, 'usuario');
    }


    public function eventos()
    {
        return $this->belongsToMany(Evento::class, EventoInscrito::class, 'usuario', 'evento');
    }
}
