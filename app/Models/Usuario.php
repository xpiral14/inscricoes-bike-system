<?php

namespace App\Models;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Usuario extends Authenticatable implements FilamentUser, HasName
{
    protected $table = 'tb_usuarios';

    protected $casts = [
        'data_nascimento' => 'immutable_date',
    ];

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

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getFilamentName(): string
    {
        return $this->nome;
    }
}
