<?php

namespace App\Exports;

use App\Models\DetalleIngreso;
use App\Models\DetalleVenta;

// use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Support\Facades\DB;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IngresoExport implements FromCollection, WithHeadings
{
     use Exportable;
    public function headings(): array
    {
        return [
            0 => [
                'id',
                'FECHA INGRESO',
                'LOTE',
                'CANTIDAD',
                'COSTO UNITARIO',
                'TOTAL',
                'VENCIMENTO',
                'MEDICAMENTO'
            ]
        ];
        $sheet->setAllBorders('thin');
    }
    // public function __construct(int $month)
    // {
    //     $this->month = $month;
    // }
    public function collection()
    {

        $venta = DetalleVenta::join('ventas','detalle_ventas.idventa','=','ventas.id')
        ->join('medicamentos','detalle_ventas.idmedicamento','=','medicamentos.id')
        ->join('productos','productos.id','=','medicamentos.producto_id')
        ->join('presentaciones','presentaciones.id','=','medicamentos.presentacion_id')
        ->join('concentraciones','concentraciones.id','=','medicamentos.concentracion_id')
        // ->join('ventas','ventas.id','=','detalle_ventas.idingreso')
        ->select(
            'detalle_ventas.id as miIdVenta',
            'detalle_ventas.idventa as lote',
            'detalle_ventas.cantidad',
            'detalle_ventas.precio',
            'detalle_ventas.descuento',
            DB::raw("CONCAT(productos.nombre,' ', concentraciones.nombre ,' ',presentaciones.nombre) as medicamento")

            )
        ->orderBy('detalle_ventas.id','asc')
        ->get();

        $ingreso = DetalleIngreso::join('medicamentos','detalle_ingresos.idmedicamento','=','medicamentos.id')
        ->join('productos','productos.id','=','medicamentos.producto_id')
        ->join('presentaciones','presentaciones.id','=','medicamentos.presentacion_id')
        ->join('concentraciones','concentraciones.id','=','medicamentos.concentracion_id')
        ->join('ingresos','ingresos.id','=','detalle_ingresos.idingreso')
        ->select(
            'detalle_ingresos.id as miIdIngreso',
            'ingresos.fecha_hora as fecha',
            'detalle_ingresos.idingreso as lote',
            'detalle_ingresos.cantidad',
            DB::raw("CONCAT('S/ ', detalle_ingresos.precio)"),
            DB::raw("CONCAT('S/ ', (detalle_ingresos.precio * detalle_ingresos.cantidad)) as total"),
            'detalle_ingresos.fecha_vencimiento',
            DB::raw("CONCAT(productos.nombre,' ', concentraciones.nombre ,' ',presentaciones.nombre) as medicamento")

            )
        ->orderBy('detalle_ingresos.id','asc')
        ->get();
        // $resultado  = array_merge($ingreso, $venta);
        // foreach ($venta as $key=>$value){
        //     $ingreso[$key]->$ingreso = $value;
        // }
        // $ingreso->array_merge($venta);
        return $ingreso;
    }

}
