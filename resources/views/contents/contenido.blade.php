@extends('templates.index')

@section('contenido')
    <template v-if="menu==0">

        <escritorio-v :ruta="ruta"></escritorio-v>
    </template>
    <template v-if="menu==1">
        <producto-component :ruta="ruta"></producto-component>
    </template>
    <template v-if="menu==2">
        <medicamento-component :ruta="ruta"></medicamento-component>
    </template>
    <template v-if="menu==3">
        <presentacion-component :ruta="ruta"></presentacion-component>
    </template>
    <template v-if="menu==4">
        <marca-component :ruta="ruta"></marca-component>
    </template>
    <template v-if="menu==5">
        <laboratorio-component :ruta="ruta"></laboratorio-component>
    </template>
    <template v-if="menu==6">
        <user-component :ruta="ruta"></user-component>
    </template>
    <template v-if="menu==7">
        <reporte-c :ruta="ruta"></reporte-c>
    </template>
    <template v-if="menu==17">
        <reporte-v :ruta="ruta"></reporte-v>
    </template>
    <template v-if="menu==18">
        <reporte-vendedor :ruta="ruta"></reporte-vendedor>
    </template>
    <template v-if="menu==8">
        <venta-component :ruta="ruta"></venta-component>
    </template>
    <template v-if="menu==9">
            <cliente-component :ruta="ruta"></cliente-component>

    </template>
    <template v-if="menu==10">
        <ingresos-component :ruta="ruta"></ingresos-component>
    </template>
    <template v-if="menu==11">
         <proveedor-component :ruta="ruta"></proveedor-component>
    </template>

            {{-- <example-component :ruta="ruta"></example-component> --}}


@endsection
