<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware'=>['guest']],function(){
    Route::get('/','Auth\LoginController@showLoginForm');
    Route::get('/login',function(){
        return redirect('/');
    });
    Route::post('/login', 'Auth\LoginController@login')->name('login');
});

Route::group(['middleware'=>['auth']],function(){
    Route::get('/main', function () {
        return view('contents.contenido');
    })->name('main');
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::group(['middleware'=>['Administrador']],function(){

        // Parte de PRODUCTOS
        Route::get('/producto',             'ProductoController@index');
        Route::post('/producto/registrar',  'ProductoController@store');
        Route::put('/producto/actualizar',  'ProductoController@update');
        Route::put('/producto/activar',     'ProductoController@activar');
        Route::put('/producto/desactivar',  'ProductoController@desactivar');
        Route::get('/producto/getAll',      'ProductoController@getAll');
        // Parte de MEDICAMENTOS
        Route::get('/medicamento',              'MedicamentoController@index');
        Route::post('/medicamento/registrar',   'MedicamentoController@store');
        Route::put('/medicamento/actualizar',   'MedicamentoController@update');
        Route::put('/medicamento/activar',      'MedicamentoController@activar');
        Route::put('/medicamento/desactivar',   'MedicamentoController@desactivar');
        Route::get('/medicamento/getAll',       'MedicamentoController@getAll');
        Route::get('/medicamento/indexStock',       'MedicamentoController@indexStock');
        // Parte de PRESENTACIONES
        Route::get('/presentacion',             'PresentacionController@index');
        Route::post('/presentacion/registrar',  'PresentacionController@store');
        Route::put('/presentacion/actualizar',  'PresentacionController@update');
        Route::put('/presentacion/activar',     'PresentacionController@activar');
        Route::put('/presentacion/desactivar',  'PresentacionController@desactivar');
        Route::get('/presentacion/getAll',      'PresentacionController@getAll');
        // Parte de PRESENTACIONES
        Route::get('/concentracion',            'ConcentracionController@index');
        Route::post('/concentracion/registrar', 'ConcentracionController@store');
        Route::put('/concentracion/actualizar', 'ConcentracionController@update');
        Route::put('/concentracion/activar',    'ConcentracionController@activar');
        Route::put('/concentracion/desactivar', 'ConcentracionController@desactivar');
        Route::get('/concentracion/getAll',     'ConcentracionController@getAll');
        // Parte de LABORATORIO
        Route::get('/laboratorio',              'LaboratorioController@index');
        Route::post('/laboratorio/registrar',   'LaboratorioController@store');
        Route::put('/laboratorio/actualizar',   'LaboratorioController@update');
        Route::put('/laboratorio/activar',      'LaboratorioController@activar');
        Route::put('/laboratorio/desactivar',   'LaboratorioController@desactivar');
        Route::get('/laboratorio/getAll',       'LaboratorioController@getAll');

        // Parte de ROL
        Route::get('/rol',                      'RolController@index');
        Route::get('/rol/selectRol',            'RolController@selectRol');

        // Parte de PROVEEDORES
        Route::get('/proveedor',                'ProveedorController@index');
        Route::get('/proveedor/selectProveedor','ProveedorController@selectProveedor');
        Route::post('/proveedor/registrar',     'ProveedorController@store');
        Route::put('/proveedor/actualizar',     'ProveedorController@update');
        Route::put('/proveedor/desactivar',     'ProveedorController@desactivar');
        Route::put('/proveedor/activar',        'ProveedorController@activar');

        // Parte de USUARIOS
        Route::get('/user',             'UserController@index');
        Route::post('/user/registrar',  'UserController@store');
        Route::put('/user/actualizar',  'UserController@update');
        Route::put('/user/activar',     'UserController@activar');
        Route::put('/user/desactivar',  'UserController@desactivar');

        // Parte de CLIENTES
        Route::get('/cliente',              'ClienteController@index');
        Route::get('/cliente/selectCliente',              'ClienteController@selectCliente');
        Route::post('/cliente/registrar',   'ClienteController@store');
        Route::put('/cliente/actualizar',   'ClienteController@update');
        Route::put('/cliente/desactivar',   'ClienteController@desactivar');
        Route::put('/cliente/activar',      'ClienteController@activar');

        // Parte de INGRESOS

        Route::get('/ingreso', 'IngresoController@index');
        Route::get('/get', 'IngresoController@getDate');
        Route::post('/ingreso/registrar', 'IngresoController@store');
        Route::put('/ingreso/desactivar', 'IngresoController@desactivar');
        Route::get('/ingreso/obtenerCabecera', 'IngresoController@obtenerCabecera');
        Route::get('/ingreso/obtenerDetalles', 'IngresoController@obtenerDetalles');
        Route::get('/ingreso/pdf/{id}','IngresoController@pdf')->name('ingreso_pdf');
        Route::get('/ingreso/listarPdf','IngresoController@listarPdf')->name('ingresos_pdf');
        // Parte de VENTAS

        Route::get('/venta', 'VentaController@index');
        Route::post('/venta/registrar', 'VentaController@store');
        Route::put('/venta/desactivar', 'VentaController@desactivar');
        Route::get('/venta/obtenerCabecera', 'VentaController@obtenerCabecera');
        Route::get('/venta/obtenerDetalles', 'VentaController@obtenerDetalles');
        Route::get('/venta/pdf/{id}','VentaController@pdf')->name('venta_pdf');
        Route::get('/venta/pdfTicket/{id}','VentaController@pdfTicket')->name('ventaticket_pdf');
        Route::get('/venta/listarPdf','VentaController@listarPdf')->name('ventas_pdf');


        Route::get('/reporte/ingresos','ReporteController@reporteIngreso');
        Route::get('/reporte/ingresos/cantidad','ReporteController@ingresoMount');
        Route::get('/reporte/ventas','ReporteController@reporteVenta');
        Route::get('/reporte/ventas/cantidad','ReporteController@ventaMount');

        Route::get('/reporte/vencimiento','ReporteController@vencimiento');


        Route::get('/excelIngreso','ReporteController@exportExcelIngreso');
        Route::get('/excelVenta','ReporteController@exportExcelVenta');
        Route::delete('/eliminarVenta','VentaController@eliminar');


        Route::get('/dashboard','DashboardController@mes');
        Route::get('/dashboardDay','DashboardController@day');
    });
    Route::group(['middleware'=>['Vendedor']],function(){

        // Parte de MEDICAMENTOS
        Route::get('/medicamento',              'MedicamentoController@index');
        Route::post('/medicamento/registrar',   'MedicamentoController@store');
        Route::put('/medicamento/actualizar',   'MedicamentoController@update');
        Route::put('/medicamento/activar',      'MedicamentoController@activar');
        Route::put('/medicamento/desactivar',   'MedicamentoController@desactivar');
        Route::get('/medicamento/getAll',       'MedicamentoController@getAll');
        Route::get('/medicamento/indexStock',       'MedicamentoController@indexStock');

        // Parte de CLIENTES
        Route::get('/cliente',              'ClienteController@index');
        Route::get('/cliente/selectCliente',              'ClienteController@selectCliente');
        Route::post('/cliente/registrar',   'ClienteController@store');
        Route::put('/cliente/actualizar',   'ClienteController@update');
        Route::put('/cliente/desactivar',   'ClienteController@desactivar');
        Route::put('/cliente/activar',      'ClienteController@activar');

        // Parte de INGRESOS

        Route::get('/ingreso', 'IngresoController@index');
        Route::get('/get', 'IngresoController@getDate');
        Route::post('/ingreso/registrar', 'IngresoController@store');
        Route::put('/ingreso/desactivar', 'IngresoController@desactivar');
        Route::get('/ingreso/obtenerCabecera', 'IngresoController@obtenerCabecera');
        Route::get('/ingreso/obtenerDetalles', 'IngresoController@obtenerDetalles');
        Route::get('/ingreso/pdf/{id}','IngresoController@pdf')->name('ingreso_pdf');
        Route::get('/ingreso/pdfTicket/{id}','IngresoController@pdfTicket')->name('ingresoticket_pdf');
        Route::get('/ingreso/listarPdf','IngresoController@listarPdf')->name('ingresos_pdf');
        // Parte de VENTAS

        Route::get('/venta', 'VentaController@index');
        Route::post('/venta/registrar', 'VentaController@store');
        Route::put('/venta/desactivar', 'VentaController@desactivar');
        Route::get('/venta/obtenerCabecera', 'VentaController@obtenerCabecera');
        Route::get('/venta/obtenerDetalles', 'VentaController@obtenerDetalles');
        Route::get('/venta/pdf/{id}','VentaController@pdf')->name('venta_pdf');
        Route::get('/venta/pdfTicket/{id}','VentaController@pdfTicket')->name('ventaticket_pdf');
        Route::get('/venta/listarPdf','VentaController@listarPdf')->name('ventas_pdf');


        Route::get('/reporte/ventas','ReporteController@reporteVenta');
        Route::get('/reporte/ventas/cantidad','ReporteController@ventaMount');
        Route::get('/reporte/vencimiento','ReporteController@vencimiento');
        Route::delete('/eliminarVenta','VentaController@eliminar');
        // Route::get('/dashboard','DashboardController');
        Route::get('/dashboardDay','DashboardController@day');
    });
    Route::group(['middleware'=>['Almacenero']],function(){

        // Parte de PRODUCTOS
        Route::get('/producto',             'ProductoController@index');
        Route::post('/producto/registrar',  'ProductoController@store');
        Route::put('/producto/actualizar',  'ProductoController@update');
        Route::put('/producto/activar',     'ProductoController@activar');
        Route::put('/producto/desactivar',  'ProductoController@desactivar');
        Route::get('/producto/getAll',      'ProductoController@getAll');
        // Parte de MEDICAMENTOS
        Route::get('/medicamento',              'MedicamentoController@index');
        Route::post('/medicamento/registrar',   'MedicamentoController@store');
        Route::put('/medicamento/actualizar',   'MedicamentoController@update');
        Route::put('/medicamento/activar',      'MedicamentoController@activar');
        Route::put('/medicamento/desactivar',   'MedicamentoController@desactivar');
        Route::get('/medicamento/getAll',       'MedicamentoController@getAll');
        Route::get('/medicamento/indexStock',       'MedicamentoController@indexStock');
        // Parte de PRESENTACIONES
        Route::get('/presentacion',             'PresentacionController@index');
        Route::post('/presentacion/registrar',  'PresentacionController@store');
        Route::put('/presentacion/actualizar',  'PresentacionController@update');
        Route::put('/presentacion/activar',     'PresentacionController@activar');
        Route::put('/presentacion/desactivar',  'PresentacionController@desactivar');
        Route::get('/presentacion/getAll',      'PresentacionController@getAll');
        // Parte de PRESENTACIONES
        Route::get('/concentracion',            'ConcentracionController@index');
        Route::post('/concentracion/registrar', 'ConcentracionController@store');
        Route::put('/concentracion/actualizar', 'ConcentracionController@update');
        Route::put('/concentracion/activar',    'ConcentracionController@activar');
        Route::put('/concentracion/desactivar', 'ConcentracionController@desactivar');
        Route::get('/concentracion/getAll',     'ConcentracionController@getAll');
        // Parte de LABORATORIO
        Route::get('/laboratorio',              'LaboratorioController@index');
        Route::post('/laboratorio/registrar',   'LaboratorioController@store');
        Route::put('/laboratorio/actualizar',   'LaboratorioController@update');
        Route::put('/laboratorio/activar',      'LaboratorioController@activar');
        Route::put('/laboratorio/desactivar',   'LaboratorioController@desactivar');
        Route::get('/laboratorio/getAll',       'LaboratorioController@getAll');

        // Parte de ROL
        Route::get('/rol',                      'RolController@index');
        Route::get('/rol/selectRol',            'RolController@selectRol');

        // Parte de PROVEEDORES
        Route::get('/proveedor',                'ProveedorController@index');
        Route::get('/proveedor/selectProveedor','ProveedorController@selectProveedor');
        Route::post('/proveedor/registrar',     'ProveedorController@store');
        Route::put('/proveedor/actualizar',     'ProveedorController@update');
        Route::put('/proveedor/desactivar',     'ProveedorController@desactivar');
        Route::put('/proveedor/activar',        'ProveedorController@activar');

        // Parte de USUARIOS
        Route::get('/user',             'UserController@index');
        Route::post('/user/registrar',  'UserController@store');
        Route::put('/user/actualizar',  'UserController@update');
        Route::put('/user/activar',     'UserController@activar');
        Route::put('/user/desactivar',  'UserController@desactivar');

        // Parte de CLIENTES
        Route::get('/cliente',              'ClienteController@index');
        Route::get('/cliente/selectCliente',              'ClienteController@selectCliente');
        Route::post('/cliente/registrar',   'ClienteController@store');
        Route::put('/cliente/actualizar',   'ClienteController@update');
        Route::put('/cliente/desactivar',   'ClienteController@desactivar');
        Route::put('/cliente/activar',      'ClienteController@activar');

        // Parte de INGRESOS

        Route::get('/ingreso', 'IngresoController@index');
        Route::get('/get', 'IngresoController@getDate');
        Route::post('/ingreso/registrar', 'IngresoController@store');
        Route::put('/ingreso/desactivar', 'IngresoController@desactivar');
        Route::get('/ingreso/obtenerCabecera', 'IngresoController@obtenerCabecera');
        Route::get('/ingreso/obtenerDetalles', 'IngresoController@obtenerDetalles');
        Route::get('/ingreso/pdf/{id}','IngresoController@pdf')->name('ingreso_pdf');
        Route::get('/ingreso/listarPdf','IngresoController@listarPdf')->name('ingresos_pdf');
        // Parte de VENTAS

        Route::get('/venta', 'VentaController@index');
        Route::post('/venta/registrar', 'VentaController@store');
        Route::put('/venta/desactivar', 'VentaController@desactivar');
        Route::get('/venta/obtenerCabecera', 'VentaController@obtenerCabecera');
        Route::get('/venta/obtenerDetalles', 'VentaController@obtenerDetalles');
        Route::get('/venta/pdf/{id}','VentaController@pdf')->name('venta_pdf');
        Route::get('/venta/pdfTicket/{id}','VentaController@pdfTicket')->name('ventaticket_pdf');
        Route::get('/venta/listarPdf','VentaController@listarPdf')->name('ventas_pdf');


        Route::get('/reporte/ingresos','ReporteController@reporteIngreso');
        Route::get('/reporte/ingresos/cantidad','ReporteController@ingresoMount');
        Route::get('/reporte/ventas','ReporteController@reporteVenta');
        Route::get('/reporte/ventas/cantidad','ReporteController@ventaMount');
        Route::get('/reporte/ventas/vendedor','ReporteController@obtenerDetallerVendedor');

        Route::get('/reporte/vencimiento','ReporteController@vencimiento');


        Route::get('/excelIngreso','ReporteController@exportExcelIngreso');
        Route::get('/excelVenta','ReporteController@exportExcelVenta');
        Route::delete('/eliminarVenta','VentaController@eliminar');


        Route::get('/dashboard', 'DashboardController@mes');
        Route::get('/dashboardDay','DashboardController@day');
    });
});
