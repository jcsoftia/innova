<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laboratorio;
class LaboratorioController extends Controller
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
             
            $laboratorios = Laboratorio::orderBy('id','desc')->paginate(10);
        }else {
            $laboratorios = Laboratorio::where($criterio, 'like', '%'.$buscar.'%')->orderBy('id','desc')->paginate(10);
            
        }

        return [
            'pagination' => [
                'total'        => $laboratorios->total(),
                'current_page' => $laboratorios->currentPage(),
                'per_page'     => $laboratorios->perPage(),
                'last_page'    => $laboratorios->lastPage(),
                'from'         => $laboratorios->firstItem(),
                'to'           => $laboratorios->lastItem(),
            ],
            'laboratorios' => $laboratorios
        ];
        // return $laboratorios;
    }

    

    public function store(Request $request)
    {
        $laboratorio = new Laboratorio();
        $laboratorio->nombre = strtoupper($request->nombre);
        $laboratorio->descripcion = strtoupper($request->descripcion);
        $laboratorio->condicion = 1;
        $laboratorio->save();
    }

    public function update(Request $request)
    {
        $laboratorio = Laboratorio::findOrFail($request->id);
        $laboratorio->nombre = strtoupper($request->nombre);
        $laboratorio->descripcion = strtoupper($request->descripcion);
        $laboratorio->save();
    }

    public function desactivar(Request $request)
    {
        $laboratorio = Laboratorio::findOrFail($request->id);
        $laboratorio->condicion = 0;
        $laboratorio->save();
    }
    public function activar(Request $request)
    {
        $laboratorio = Laboratorio::findOrFail($request->id);
        $laboratorio->condicion = 1;
        $laboratorio->save();
    }
    public function getAll()
    {
        return Laboratorio::all();
    }
    
}
