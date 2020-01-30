<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    public function presentaciones()
    {
        return $this->hasMany('App\Models\Presentaciones');
    }
    public function concentrecion()
    {
        return $this->hasMany('App\Models\Concentrecion');
    }
    public function laboratorio()
    {
        return $this->hasMany('App\Models\Laboratorio');
    }
    public function propucto()
    {
        return $this->hasOne('App\Models\Propucto');
    }
}
