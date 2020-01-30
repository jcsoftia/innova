<?php

namespace App\Http\Controllers;

use App\Models\DetalleIngreso;
use App\Models\DetalleVenta;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Exports\IngresoExport;
use App\Exports\VentaExport;
use Maatwebsite\Excel\Facades\Excel; // as QExcel;
// use Maatwebsite\Excel\Excel;


class ReporteController extends Controller
{
    public function reporteIngreso(){
        $ingreso = DetalleIngreso::join('medicamentos','detalle_ingresos.idmedicamento','=','medicamentos.id')
        ->join('productos','productos.id','=','medicamentos.producto_id')
        ->join('presentaciones','presentaciones.id','=','medicamentos.presentacion_id')
        ->join('concentraciones','concentraciones.id','=','medicamentos.concentracion_id')
        ->join('ingresos','ingresos.id','=','detalle_ingresos.idingreso')
        ->select(
            'detalle_ingresos.id as id',
            'detalle_ingresos.lote as lote',
            'detalle_ingresos.cantidad',
            'detalle_ingresos.costo as precio',
            'ingresos.fecha_hora',
            'detalle_ingresos.fecha_vencimiento',
            DB::raw("cantidad * costo as total"),
             DB::raw("CONCAT(productos.nombre,' ', concentraciones.nombre ,' ',presentaciones.nombre) as descripcion")
            )
        ->whereMonth('ingresos.fecha_hora',Carbon::now()->isoFormat('M'))

        ->orderBy('detalle_ingresos.id','desc')
        ->get();
        return $ingreso;
    }
    public function ingresoMount(){
        $ingreso = DetalleIngreso::select(
            DB::raw("SUM(detalle_ingresos.precio * detalle_ingresos.cantidad) as suma")
            )
        ->get();
        return $ingreso;
    }
    public function reporteVenta(){
        $venta = DetalleVenta::join('ventas','detalle_ventas.idventa','=','ventas.id')
        ->join('medicamentos','detalle_ventas.idmedicamento','=','medicamentos.id')
        ->join('productos','productos.id','=','medicamentos.producto_id')
        ->join('presentaciones','presentaciones.id','=','medicamentos.presentacion_id')
        ->join('concentraciones','concentraciones.id','=','medicamentos.concentracion_id')
        // ->join('ventas','ventas.id','=','detalle_ventas.idingreso')
        ->select(
            'detalle_ventas.id as id',
            'ventas.num_comprobante as num_com',
            'detalle_ventas.cantidad',
            'detalle_ventas.precio',
            'ventas.fecha_hora',
            'detalle_ventas.descuento',
            DB::raw("CONCAT(productos.nombre,' ', concentraciones.nombre ,' ',presentaciones.nombre) as descripcion"),
            DB::raw("cantidad * precio as total")

            )
        ->whereMonth('ventas.fecha_hora',Carbon::now()->isoFormat('M'))
        ->orderBy('detalle_ventas.id','desc')
        ->get();
        return $venta;
    }
    public function ventaMount(){
        $venta = DetalleVenta::join('ventas','detalle_ventas.idventa','=','ventas.id')
        ->join('medicamentos','detalle_ventas.idmedicamento','=','medicamentos.id')
        ->join('productos','productos.id','=','medicamentos.producto_id')
        ->join('presentaciones','presentaciones.id','=','medicamentos.presentacion_id')
        ->join('concentraciones','concentraciones.id','=','medicamentos.concentracion_id')
        // ->join('ventas','ventas.id','=','detalle_ventas.idingreso')
        ->select(
            DB::raw("SUM(detalle_ventas.precio * detalle_ventas.cantidad) as suma")

            )
        // ->orderBy('detalle_ventas.id','asc')
        ->get();
        return $venta;
    }
    public function exportExcelIngreso()
    {
        // return (new IngresoExport);
        // return new IngresoExport;
        return Excel::download(new IngresoExport, 'INGRESOS.xlsx');

        // ((new IngresoExport)->queue('reporte.xlsx'));
    }
    public function exportExcelVenta()
    {
        // return (new VentaExport);
        // return new VentaExport;
        return Excel::download(new VentaExport, 'Ventas.xlsx');

        // ((new IngresoExport)->queue('reporte.xlsx'));
    }
    public function vencimiento(){

        $ingresos = DetalleIngreso::join('medicamentos','detalle_ingresos.idmedicamento','=','medicamentos.id')
        ->join('productos','productos.id','=','medicamentos.producto_id')
        ->join('presentaciones','presentaciones.id','=','medicamentos.presentacion_id')
        ->join('concentraciones','concentraciones.id','=','medicamentos.concentracion_id')
        // ->join('ingresos','ingresos.id','=','detalle_ingresos.idingreso')
        ->select(
            'detalle_ingresos.id as miIdIngreso',
            'detalle_ingresos.lote as lote',
            'detalle_ingresos.cantidad',
            'detalle_ingresos.precio as precio_venta',
            'detalle_ingresos.costo as precio',
            DB::raw("DATE_FORMAT(fecha_vencimiento,'%d / %M / %Y') as fecha_vencimiento"),
            DB::raw("cantidad * costo as total"),
             DB::raw("CONCAT(productos.nombre,' ', concentraciones.nombre ,' ',presentaciones.nombre) as medicamento")
            )
        ->whereDate('fecha_vencimiento','<', Carbon::now()->addDays(60))
        ->orderBy(DB::raw("DATE_FORMAT(fecha_vencimiento,'%d %m %Y')"),'asc')
        ->paginate(10);

        return [
            'pagination' => [
                'total'        => $ingresos->total(),
                'current_page' => $ingresos->currentPage(),
                'per_page'     => $ingresos->perPage(),
                'last_page'    => $ingresos->lastPage(),
                'from'         => $ingresos->firstItem(),
                'to'           => $ingresos->lastItem(),
            ],
            'ingresos' => $ingresos
        ];
    }
    public function obtenerDetallerVendedor(Request $request){
        $fecha = $request->fecha;

        if ($fecha=='') {
            $detalle = DB::select("SELECT
                                        users.usuario,
                                        personas.nombre,
                                        ventas.idusuario,
                                        ventas.fecha_hora,
                                        sum(total) as total,
                                        ventas.estado
                                    from ventas
                                    INNER JOIN users ON users.id = ventas.idusuario
                                    INNER JOIN personas ON users.id = personas.id
                                    WHERE ventas.estado = 'Registrado'
                                    GROUP BY idusuario, usuario, nombre, fecha_hora, estado
                                    ORDER BY fecha_hora
            ");
            // $detalle = Venta::select(
            //     'idusuario',
            //     'fecha_hora',
            //     DB::raw('sum(total) as total'))
            //     ->groupBY('ventas.idusuario','ventas.fecha_hora')
            //     ->orderBy('ventas.idusuario');
            return $detalle;
        } else {
            $date = Carbon::createFromIsoFormat('DD MMM YYYY', $fecha);

            $fecha_format = $date->isoFormat('YYYY-MM-D');
            // echo $fecha_format;
            // $detalle = Venta::select(
            //     'idusuario',
            //     'fecha_hora',
            //     DB::raw('sum(total) as total'))
            //     ->whereDate('fecha_hora','=', $fecha_format)
            //     ->groupBY('idusuario','fecha_hora')
            //     ->orderBy('idusuario');
            $detalle = DB::select("SELECT
                                        users.usuario,
                                        personas.nombre,
                                        ventas.idusuario,
                                        ventas.fecha_hora,
                                        sum(total) as total,
                                        ventas.estado
                                    from ventas
                                    INNER JOIN users ON users.id = ventas.idusuario
                                    INNER JOIN personas ON users.id = personas.id
                                    WHERE
                                        ventas.estado = 'Registrado' and DATE(fecha_hora) = '$fecha_format'
                                    GROUP BY idusuario, usuario, nombre, fecha_hora, estado
                                    ORDER BY fecha_hora

                                    ");
            return $detalle;
        }

    }

}
