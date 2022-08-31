<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function listarProductos(Request $request){
        $producto = new Producto;
        $producto = $producto->listarProductos($request);
        return $producto;
    }

    public function buscarProducto(Request $request){
        $producto = new Producto;
        $producto = $producto->buscarProducto($request->Nombre);
        return $producto;
    }

    public function guardarProducto(Request $request){
        $this->validate($request,[
            'Venta'     => 'required',
            'Nombre'    => 'required',
            'Compra'    => 'required',
            'Categoria' => 'required',
        ]);

        try {
            $datos['Venta']       = $request->Venta;
            $datos['Minimo']      = $request->Minimo;
            $datos['Nombre']      = $request->Nombre;
            $datos['Compra']      = $request->Compra;
            $datos['Ingreso']     = $request->Ingreso;
            $datos['Categoria']   = $request->Categoria;
            $datos['Descripcion'] = $request->Descripcion;

            $producto = new Producto;
            $producto = $producto->guardarProducto($datos);
            return $producto;
        } catch (Exception $err) {
            return $err->getMessage();
        }
    }

    public function actualizarProducto(Request $request){
        $this->validate($request,[
            'ID'        => 'required',
            'Venta'     => 'required',
            'Minimo'    => 'required',
            'Nombre'    => 'required',
            'Compra'    => 'required',
            'Ingreso'   => 'required',
            'Categoria' => 'required',
        ]);

        try {
            $datos['ID']          = $request->ID;
            $datos['Venta']       = $request->Venta;
            $datos['Minimo']      = $request->Minimo;
            $datos['Nombre']      = $request->Nombre;
            $datos['Compra']      = $request->Compra;
            $datos['Ingreso']     = $request->Ingreso;
            $datos['Categoria']   = $request->Categoria;
            $datos['Descripcion'] = $request->Descripcion;
    
            $producto = new Producto;
            $producto = $producto->actualizarProducto($datos);
            return $producto;
        } catch (Exception $err) {
            return $err->getMessage();
        }
    }

    public function actualizarEstadoProducto(Request $request){
        $datos['ID']     = isset($request->ID) ? $request->ID : '';
        $datos['Estado'] = $request->Estado == 1 ? 0 : 1;

        $producto = new Producto;
        $producto = $producto->actualizarEstadoProducto($datos);
        return $producto;
    }
}
