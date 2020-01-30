<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Concentracion extends Model
{
    protected $table = 'concentraciones';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];
    // public $timestamps = false;

    // protected $hidden = [
    //     'id'
    // ];
    public function medicamento()
    {
        return $this->belongsTo('App\Models\Medicamento');
    }
}
