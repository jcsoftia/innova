<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presentacion extends Model
{
    protected $table = 'presentaciones';
    public function medicamento()
    {
        return $this->belongsTo('App\Models\Medicamento');
    }
}
