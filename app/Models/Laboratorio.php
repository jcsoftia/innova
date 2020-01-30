<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laboratorio extends Model
{
    public function medicamento()
    {
        return $this->belongsTo('App\Models\Medicamento');
    }
}
