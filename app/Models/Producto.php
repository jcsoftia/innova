<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public function medicamento()
    {
        return $this->hasOne('App\Models\Medicamento');
    }
}
