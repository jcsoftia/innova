<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presentacion;
class PresentacionController extends Controller
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
             
            $presentaciones = Presentacion::orderBy('id','desc')->paginate(10);
        }else {
            $presentaciones = Presentacion::where($criterio, 'like', '%'.$buscar.'%')->orderBy('id','desc')->paginate(10);
            
        }

        return [
            'pagination' => [
                'total'        => $presentaciones->total(),
                'current_page' => $presentaciones->currentPage(),
                'per_page'     => $presentaciones->perPage(),
                'last_page'    => $presentaciones->lastPage(),
                'from'         => $presentaciones->firstItem(),
                'to'           => $presentaciones->lastItem(),
            ],
            'presentaciones' => $presentaciones
        ];
        // return $presentaciones;
    }

    

    public function store(Request $request)
    {
        $presentacion = new Presentacion();
        $presentacion->nombre = strtoupper($request->nombre);
        $presentacion->descripcion = strtoupper($request->descripcion);
        $presentacion->condicion = 1;
        $presentacion->save();
    }

    public function update(Request $request)
    {
        $presentacion = Presentacion::findOrFail($request->id);
        $presentacion->nombre = strtoupper($request->nombre);
        $presentacion->descripcion = strtoupper($request->descripcion);
        $presentacion->save();
    }

    public function desactivar(Request $request)
    {
        $presentacion = Presentacion::findOrFail($request->id);
        $presentacion->condicion = 0;
        $presentacion->save();
    }
    public function activar(Request $request)
    {
        $presentacion = Presentacion::findOrFail($request->id);
        $presentacion->condicion = 1;
        $presentacion->save();
    }
    public function getAll()
    {
        return Presentacion::all();
    }
    
}
