<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
class ProductoController extends Controller
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
             
            $productos = Producto::orderBy('id','desc')->paginate(10);
        }else {
            $productos = Producto::where($criterio, 'like', '%'.$buscar.'%')->orderBy('id','desc')->paginate(10);
            
        }

        return [
            'pagination' => [
                'total'        => $productos->total(),
                'current_page' => $productos->currentPage(),
                'per_page'     => $productos->perPage(),
                'last_page'    => $productos->lastPage(),
                'from'         => $productos->firstItem(),
                'to'           => $productos->lastItem(),
            ],
            'productos' => $productos
        ];
        // return $productos;
    }

    

    public function store(Request $request)
    {
        $producto = new Producto();
        $producto->nombre = strtoupper($request->nombre);
        $producto->descripcion = strtoupper($request->descripcion);
        $producto->condicion = 1;
        $producto->save();
    }

    public function update(Request $request)
    {
        $producto = Producto::findOrFail($request->id);
        $producto->nombre = strtoupper($request->nombre);
        $producto->descripcion = strtoupper($request->descripcion);
        $producto->save();
    }

    public function desactivar(Request $request)
    {
        $producto = Producto::findOrFail($request->id);
        $producto->condicion = 0;
        $producto->save();
    }
    public function activar(Request $request)
    {
        $producto = Producto::findOrFail($request->id);
        $producto->condicion = 1;
        $producto->save();
    }
    public function getAll()
    {
        return Producto::all();
    }
}
