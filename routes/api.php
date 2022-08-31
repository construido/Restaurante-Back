<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CajaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/login', [AuthController::class, 'authenticate']);

// Route::group(['prefix' => 'admin', 'middleware' => ['jwt.verify', 'admin.verify']], function(){
Route::group(['prefix' => 'verify', 'middleware' => ['jwt.verify']], function(){
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::group(['middleware' => ['admin.verify']], function(){
        Route::post('/crearLogin', [LoginController::class, 'guardarLogin']);

        Route::put('/actualizarEstadoEmpleado', [EmpleadoController::class, 'actualizarEstadoEmpleado']);
        Route::put('/actualizarEmpleado', [EmpleadoController::class, 'actualizarEmpleado']);
        Route::post('/guardarEmpleado', [EmpleadoController::class, 'guardarEmpleado']);
        Route::get('/listarEmpleados', [EmpleadoController::class, 'listarEmpleados']);
        Route::get('/buscarEmpleado', [EmpleadoController::class, 'buscarEmpleado']);

        Route::put('/actualizarEstadoCategoria', [CategoriaController::class, 'actualizarEstadoCategoria']);
        Route::get('/listarCategoriaSelect', [CategoriaController::class, 'listarCategoriaSelect']);
        Route::put('/actualizarCategoria', [CategoriaController::class, 'actualizarCategoria']);
        Route::post('/guardarCategoria', [CategoriaController::class, 'guardarCategoria']);
        Route::get('/listarCategorias', [CategoriaController::class, 'listarCategorias']);

        Route::put('/actualizarEstadoProducto', [ProductoController::class, 'actualizarEstadoProducto']);
        Route::put('/actualizarProducto', [ProductoController::class, 'actualizarProducto']);
        Route::post('/guardarProducto', [ProductoController::class, 'guardarProducto']);
        Route::get('/listarProductos', [ProductoController::class, 'listarProductos']);
        Route::get('/buscarProducto', [ProductoController::class, 'buscarProducto']);
        
        Route::put('/actualizarEstadoCliente', [ClienteController::class, 'actualizarEstadoCliente']);
        Route::get('/listarSelectCliente', [ClienteController::class, 'listarSelectCliente']);
        Route::put('/actualizarCliente', [ClienteController::class, 'actualizarCliente']);
        Route::post('/guardarCliente', [ClienteController::class, 'guardarCliente']);
        Route::get('/listarClientes', [ClienteController::class, 'listarClientes']);

        Route::put('/actualizarEstadoProveedor', [ProveedorController::class, 'actualizarEstadoProveedor']);
        Route::get('/listarSelectProveedor', [ProveedorController::class, 'listarSelectProveedor']);
        Route::put('/actualizarProveedor', [ProveedorController::class, 'actualizarProveedor']);
        Route::get('/listarProveedores', [ProveedorController::class, 'listarProveedores']);
        Route::post('/guardarProveedor', [ProveedorController::class, 'guardarProveedor']);

        Route::get('/listarDetalleCompra', [CompraController::class, 'listarDetalleCompra']);
        Route::post('/guardarCompra', [CompraController::class, 'guardarCompra']);
        Route::get('/listarCompras', [CompraController::class, 'listarCompras']);

        Route::get('/listarDetalleVenta', [VentaController::class, 'listarDetalleVenta']);
        Route::post('/guardarVenta', [VentaController::class, 'guardarVenta']);
        Route::get('/listarVentas', [VentaController::class, 'listarVentas']);

        Route::post('/aperturaCaja', [CajaController::class, 'aperturaCaja']);
        Route::get('/listarCajas', [CajaController::class, 'listarCajas']);
        Route::post('/cierreCaja', [CajaController::class, 'cierreCaja']);
        Route::post('/buscarCaja', [CajaController::class, 'buscarCaja']);

        Route::post('/ingresoSalidaCaja', [MovimientoController::class, 'ingresoSalidaCaja']);
        Route::get('/listarMovimientos', [MovimientoController::class, 'listarMovimientos']);

        /*Route::post('/cantidadProductos', [DashboardController::class, 'cantidadProductos']);
        Route::post('/cantidadClientes', [DashboardController::class, 'cantidadClientes']);
        Route::post('/cantidadCompras', [DashboardController::class, 'cantidadCompras']);
        Route::post('/cantidadVentas', [DashboardController::class, 'cantidadVentas']);*/
    });

    //Route::group(['middleware' => ['cajero.verify']], function(){
        Route::get('/listarCategorias', [CategoriaController::class, 'listarCategorias']);
        Route::get('/listarClientes', [ClienteController::class, 'listarClientes']);
        Route::get('/listarCajas', [CajaController::class, 'listarCajas']);

        Route::post('/cantidadProductos', [DashboardController::class, 'cantidadProductos']);
        Route::post('/cantidadClientes', [DashboardController::class, 'cantidadClientes']);
        Route::post('/cantidadCompras', [DashboardController::class, 'cantidadCompras']);
        Route::post('/cantidadVentas', [DashboardController::class, 'cantidadVentas']);
    //});
});