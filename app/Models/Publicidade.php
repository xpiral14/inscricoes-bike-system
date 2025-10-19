<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publicidade extends Model
{

    protected $table = 'tb_publicidade';
    public $timestamps = false;

    public function area()
    {
        return $this->belongsTo(AreaPublicidade::class, 'cd_area');
    }
}
