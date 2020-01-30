<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'detalle_ventas';
    protected $fillable = [
        'idventa', 
        'idmedicamento',
        'cantidad',
        'precio',
        'descuento'
    ];
    public $timestamps = false;
}
