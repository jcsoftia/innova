<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicamento;
class MedicamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            // return redirect('/');
        }
        $buscar = strtoupper($request->buscar);
        $criterio = $request->criterio;
        if ($criterio=='nombre') {
            $criterio = 'productos.nombre';
        }elseif ($criterio=='descripcion') {
            $criterio = 'medicamentos.descripcion';
        }elseif ($criterio=='codigo') {
            $criterio = 'medicamentos.codigo';
        }
        if ($buscar == '') {

            $medicamentos = Medicamento::join('productos','productos.id','=','medicamentos.producto_id')
            ->join('presentaciones','presentaciones.id','=','medicamentos.presentacion_id')
            ->join('concentraciones','concentraciones.id','=','medicamentos.concentracion_id')
            ->join('laboratorios','laboratorios.id','=','medicamentos.laboratorio_id')
            ->select(
                'medicamentos.id',
                'medicamentos.codigo',
                'medicamentos.precio_venta',
                'medicamentos.stock',
                'medicamentos.descripcion',
                'medicamentos.condicion',
                'medicamentos.producto_id',
                'productos.nombre as nombre',
                'medicamentos.presentacion_id',
                'presentaciones.nombre as presentacion',
                'medicamentos.concentracion_id',
                'concentraciones.nombre as marca',
                'medicamentos.laboratorio_id',
                'laboratorios.nombre as laboratorio'
                )
            ->orderBy('nombre','asc')->paginate(10);
        }else {
            $medicamentos = Medicamento::join('productos','productos.id','=','medicamentos.producto_id')
            ->join('presentaciones','presentaciones.id','=','medicamentos.presentacion_id')
            ->join('concentraciones','concentraciones.id','=','medicamentos.concentracion_id')
            ->join('laboratorios','laboratorios.id','=','medicamentos.laboratorio_id')
            ->select(
                'medicamentos.id',
                'medicamentos.codigo',
                'medicamentos.precio_venta',
                'medicamentos.stock',
                'medicamentos.descripcion',
                'medicamentos.condicion',
                'medicamentos.producto_id',
                'productos.nombre as nombre',
                'medicamentos.presentacion_id',
                'presentaciones.nombre as presentacion',
                'medicamentos.concentracion_id',
                'concentraciones.nombre as marca',
                'medicamentos.laboratorio_id',
                'laboratorios.nombre as laboratorio'
                )
            ->where($criterio, 'like', '%'.$buscar.'%')->orderBy('nombre','asc')->paginate(10);

        }

        return [
            'pagination' => [
                'total'        => $medicamentos->total(),
                'current_page' => $medicamentos->currentPage(),
                'per_page'     => $medicamentos->perPage(),
                'last_page'    => $medicamentos->lastPage(),
                'from'         => $medicamentos->firstItem(),
                'to'           => $medicamentos->lastItem(),
            ],
            'medicamentos' => $medicamentos
        ];
        // return $medicamentos;
    }
    public function indexStock(Request $request)
    {
        if (!$request->ajax()) {
            // return redirect('/');
        }
        $buscar = strtoupper($request->buscar);
        $criterio = $request->criterio;
        if ($criterio=='nombre') {
            $criterio = 'productos.nombre';
        }elseif ($criterio=='descripcion') {
            $criterio = 'medicamentos.descripcion';
        }elseif ($criterio=='codigo') {
            $criterio = 'medicamentos.codigo';
            # code...
        }
        if ($buscar == '') {

            $medicamentos = Medicamento::join('productos','productos.id','=','medicamentos.producto_id')
            ->join('presentaciones','presentaciones.id','=','medicamentos.presentacion_id')
            ->join('concentraciones','concentraciones.id','=','medicamentos.concentracion_id')
            ->join('laboratorios','laboratorios.id','=','medicamentos.laboratorio_id')
            ->join('detalle_ingresos','medicamentos.id','=','detalle_ingresos.idmedicamento')
            ->select(
                'detalle_ingresos.id as miID',
                'medicamentos.id',
                'medicamentos.codigo',
                'medicamentos.precio_venta',
                'medicamentos.stock',
                'medicamentos.descripcion',
                'medicamentos.condicion',
                'medicamentos.producto_id',
                'productos.nombre as nombre',
                'medicamentos.presentacion_id',
                'presentaciones.nombre as presentacion',
                'medicamentos.concentracion_id',
                'concentraciones.nombre as marca',
                'medicamentos.laboratorio_id',
                'detalle_ingresos.fecha_vencimiento',
                'detalle_ingresos.precio',
                'laboratorios.nombre as laboratorio'
                )
            ->orderBy('medicamentos.id','desc')->paginate(10);
        }else {
            $medicamentos = Medicamento::join('productos','productos.id','=','medicamentos.producto_id')
            ->join('presentaciones','presentaciones.id','=','medicamentos.presentacion_id')
            ->join('concentraciones','concentraciones.id','=','medicamentos.concentracion_id')
            ->join('laboratorios','laboratorios.id','=','medicamentos.laboratorio_id')
            ->join('detalle_ingresos','medicamentos.id','=','detalle_ingresos.idmedicamento')
            ->select(
                'detalle_ingresos.id as miID',
                'medicamentos.id',
                'medicamentos.codigo',
                'medicamentos.precio_venta',
                'medicamentos.stock',
                'medicamentos.descripcion',
                'medicamentos.condicion',
                'medicamentos.producto_id',
                'productos.nombre as nombre',
                'medicamentos.presentacion_id',
                'presentaciones.nombre as presentacion',
                'medicamentos.concentracion_id',
                'concentraciones.nombre as marca',
                'medicamentos.laboratorio_id',
                'detalle_ingresos.fecha_vencimiento',
                'detalle_ingresos.precio',
                'detalle_ingresos.cantidad',
                'laboratorios.nombre as laboratorio'
                )
            ->where($criterio, 'like', '%'.$buscar.'%')->orderBy('medicamentos.id','desc')->paginate(10);

        }

        return [
            'pagination' => [
                'total'        => $medicamentos->total(),
                'current_page' => $medicamentos->currentPage(),
                'per_page'     => $medicamentos->perPage(),
                'last_page'    => $medicamentos->lastPage(),
                'from'         => $medicamentos->firstItem(),
                'to'           => $medicamentos->lastItem(),
            ],
            'medicamentos' => $medicamentos
        ];
        // return $medicamentos;
    }


    public function store(Request $request)
    {
        $medicamento = new Medicamento();
        $medicamento->codigo = strtoupper($request->codigo);
        $medicamento->precio_venta = $request->precio;
        $medicamento->descripcion = strtoupper($request->descripcion);
        $medicamento->condicion = 1;
        $medicamento->stock = 0;
        $medicamento->producto_id = $request->producto_id;
        $medicamento->presentacion_id = $request->presentacion_id;
        $medicamento->concentracion_id = $request->concentracion_id;
        $medicamento->laboratorio_id = $request->laboratorio_id;
        $medicamento->save();
    }

    public function update(Request $request)
    {
        $medicamento = Medicamento::findOrFail($request->id);
        $medicamento->codigo = strtoupper($request->codigo);
        $medicamento->precio_venta = $request->precio;
        $medicamento->descripcion = strtoupper($request->descripcion);
        $medicamento->condicion = 1;
        $medicamento->producto_id = $request->producto_id;
        $medicamento->presentacion_id = $request->presentacion_id;
        $medicamento->concentracion_id = $request->concentracion_id;
        $medicamento->laboratorio_id = $request->laboratorio_id;
        $medicamento->save();
    }

    public function desactivar(Request $request)
    {
        $medicamento = Medicamento::findOrFail($request->id);
        $medicamento->condicion = 0;
        $medicamento->save();
    }
    public function activar(Request $request)
    {
        $medicamento = Medicamento::findOrFail($request->id);
        $medicamento->condicion = 1;
        $medicamento->save();
    }
    public function getAll()
    {
        return Medicamento::all();
    }

}
