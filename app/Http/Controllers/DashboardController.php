<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $anio=date('Y');
        $ingresos=DB::table('ingresos as i')
        ->select(
            // DB::raw('MONTH(i.fecha_hora) as mes'),
            DB::raw("(DATE_FORMAT(fecha_hora, 'MON')) as mes"),
            DB::raw("extract(year from  i.fecha_hora) as anio"),
        // DB::raw('YEAR(i.fecha_hora) as anio'),
            DB::raw('SUM(i.total) as total'))
        ->whereYear('i.fecha_hora',$anio)
        ->groupBy(DB::raw("(DATE_FORMAT(fecha_hora, 'MON'))"),
            DB::raw("extract(year from  i.fecha_hora)"))
        ->get();

        $ventas=DB::table('ventas as v')
        ->select(
            // DB::raw('MONTHNAME(v.fecha_hora) as mes'),
            DB::raw("(DATE_FORMAT(fecha_hora, 'MON')) as mes"),
            DB::raw("extract(year from  v.fecha_hora) as anio"),
            // DB::raw('YEAR(v.fecha_hora) as anio'),
            DB::raw('SUM(v.total) as total'))
        ->whereYear('v.fecha_hora',$anio)
        ->groupBy( DB::raw("(DATE_FORMAT(fecha_hora, 'MON'))"),
            DB::raw("extract(year from  v.fecha_hora)"))
        ->get();

        return ['ingresos'=>$ingresos,'ventas'=>$ventas,'anio'=>$anio];

    }
    public function day(Request $request)
    {
        $mes=date('m');
        $ingresos=DB::table('ingresos as i')
        ->select(
            // DB::raw('MONTH(i.fecha_hora) as mes'),
            DB::raw("extract(day from  i.fecha_hora) as dia"),
            DB::raw("extract(month from  i.fecha_hora) as mes"),
        // DB::raw('YEAR(i.fecha_hora) as mes'),
            DB::raw('SUM(i.total) as total'))
        ->whereMonth('i.fecha_hora',$mes)
        ->groupBy(DB::raw("extract(day from  i.fecha_hora)"),
            DB::raw("extract(month from  i.fecha_hora)"))
        ->get();

        $ventas=DB::table('ventas as v')
        ->select(
            // DB::raw('MONTHNAME(v.fecha_hora) as dia'),
            DB::raw("extract(day from  v.fecha_hora) as dia"),
            DB::raw("(DATE_FORMAT(fecha_hora, 'MON'))as mes"),
            // DB::raw('Month(v.fecha_hora) as mes'),
            DB::raw('SUM(v.total) as total'))
        ->whereMonth('v.fecha_hora',$mes)
        ->groupBy( DB::raw("extract(day from  v.fecha_hora)"),
            DB::raw("DATE_FORMAT(fecha_hora, 'MON')"))
        ->get();

        return ['ingresosD'=>$ingresos,'ventasD'=>$ventas,'mes'=>$mes];

    }
}
