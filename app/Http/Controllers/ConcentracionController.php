<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concentracion;
class ConcentracionController extends Controller
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
        
        if ($buscar == '') {
             
            $concentraciones = Concentracion::orderBy('id','desc')->paginate(10);
        }else {
            $concentraciones = Concentracion::where($criterio, 'like', '%'.$buscar.'%')->orderBy('id','desc')->paginate(10);
            
        }

        return [
            'pagination' => [
                'total'        => $concentraciones->total(),
                'current_page' => $concentraciones->currentPage(),
                'per_page'     => $concentraciones->perPage(),
                'last_page'    => $concentraciones->lastPage(),
                'from'         => $concentraciones->firstItem(),
                'to'           => $concentraciones->lastItem(),
            ],
            'concentraciones' => $concentraciones
        ];
        // return $concentraciones;
    }

    

    public function store(Request $request)
    {
        $concentracion = new Concentracion();
        $concentracion->nombre = strtoupper($request->nombre);
        $concentracion->descripcion = strtoupper($request->descripcion);
        $concentracion->condicion = 1;
        $concentracion->save();
    }

    public function update(Request $request)
    {
        $concentracion = Concentracion::findOrFail($request->id);
        $concentracion->nombre = strtoupper($request->nombre);
        $concentracion->descripcion = strtoupper($request->descripcion);
        $concentracion->save();
    }

    public function desactivar(Request $request)
    {
        $concentracion = Concentracion::findOrFail($request->id);
        $concentracion->condicion = 0;
        $concentracion->save();
    }
    public function activar(Request $request)
    {
        $concentracion = Concentracion::findOrFail($request->id);
        $concentracion->condicion = 1;
        $concentracion->save();
    }
    public function getAll()
    {
        return Concentracion::all();
    }
    
}
