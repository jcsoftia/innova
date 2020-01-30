<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{
    protected $table = 'detalle_ingresos';
    protected $fillable = [
        'idingreso', 
        'idmedicamento',
        'cantidad',
        'precio'
    ];
    public $timestamps = false;
}
