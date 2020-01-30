<?php

namespace App\Exports;

use App\Models\DetalleVenta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Concerns\WithHeadings;
class VentaExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    //  use Exportable;
    public function headings(): array
    {
        return [
            0 => [
                'NUM_COMPROBANTE',
                'MEDICAMENTO',
                // 'id',
                // 'FECHA INGRESO',
                // 'LOTE',
                'CANTIDAD',
                'COSTO UNITARIO',
                'DESCUENTO',
                'TOTAL',
                // 'VENCIMENTO',
            ]
        ];
        $sheet->setAllBorders('thin');
    }
    public function collection()
    {
         $venta = DetalleVenta::join('ventas','detalle_ventas.idventa','=','ventas.id')
        ->join('medicamentos','detalle_ventas.idmedicamento','=','medicamentos.id')
        ->join('productos','productos.id','=','medicamentos.producto_id')
        ->join('presentaciones','presentaciones.id','=','medicamentos.presentacion_id')
        ->join('concentraciones','concentraciones.id','=','medicamentos.concentracion_id')
        // ->join('ventas','ventas.id','=','detalle_ventas.idingreso')
        ->select(
            'ventas.num_comprobante as num_com',
            DB::raw("CONCAT(productos.nombre,' ', concentraciones.nombre ,' ',presentaciones.nombre) as medicamento"),
            'detalle_ventas.cantidad',
            'detalle_ventas.precio',
            'detalle_ventas.descuento',
            DB::raw("cantidad * precio as total")

            )
        ->orderBy('detalle_ventas.id','desc')
        ->get();
        return $venta;
    }
}
