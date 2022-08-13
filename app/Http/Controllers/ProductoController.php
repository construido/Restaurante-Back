<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function listarProductos(){
        $producto = new Producto;
        $producto = $producto->listarProductos();
        return $producto;
    }

    public function buscarProducto(Request $request){
        $producto = new Producto;
        $producto = $producto->buscarProducto($request->Nombre);
        return $producto;
    }

    public function guardarProducto(Request $request){
        $datos['Venta']        = isset($request->Venta) ? $request->Venta : 0;
        $datos['Stock']        = isset($request->Stock) ? $request->Stock : 0;
        $datos['Minimo']       = isset($request->Minimo) ? $request->Minimo : 10;
        $datos['Nombre']       = isset($request->Nombre) ? $request->Nombre : '';
        $datos['Compra']       = isset($request->Compra) ? $request->Compra : 0;
        $datos['Salida']       = isset($request->Salida) ? $request->Salida : 0;
        $datos['Ingreso']      = isset($request->Ingreso) ? $request->Ingreso : 0;
        $datos['Categoria']    = isset($request->Categoria) ? $request->Categoria : 0;
        $datos['Descripcion']  = isset($request->Descripcion) ? $request->Descripcion : '';

        $producto = new Producto;
        $producto = $producto->guardarProducto($datos);
        return $producto;
    }

    public function actualizarProducto(Request $request){
        $datos['ID']           = isset($request->ID) ? $request->ID : '';
        $datos['Venta']        = isset($request->Venta) ? $request->Venta : 0;
        $datos['Stock']        = isset($request->Stock) ? $request->Stock : 0;
        $datos['Minimo']       = isset($request->Minimo) ? $request->Minimo : 10;
        $datos['Nombre']       = isset($request->Nombre) ? $request->Nombre : '';
        $datos['Compra']       = isset($request->Compra) ? $request->Compra : 0;
        $datos['Salida']       = isset($request->Salida) ? $request->Salida : 0;
        $datos['Ingreso']      = isset($request->Ingreso) ? $request->Ingreso : 0;
        $datos['Categoria']    = isset($request->Categoria) ? $request->Categoria : 0;
        $datos['Descripcion']  = isset($request->Descripcion) ? $request->Descripcion : '';

        $producto = new Producto;
        $producto = $producto->actualizarProducto($datos);
        return $producto;
    }

    public function actualizarEstadoProducto(Request $request){
        $datos['ID']     = isset($request->ID) ? $request->ID : '';
        $datos['Estado'] = $request->Estado == 1 ? 0 : 1;

        $producto = new Producto;
        $producto = $producto->actualizarEstadoProducto($datos);
        return $producto;
    }
}
