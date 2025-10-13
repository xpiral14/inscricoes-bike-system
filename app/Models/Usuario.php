<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Usuario extends Model
{

    protected $table = 'tb_usuarios';

    public function configuracao(): HasOne
    {
        return $this->hasOne(UsuarioConfig::class, 'usuario');
    }
}
