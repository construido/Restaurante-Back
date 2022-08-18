<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\DetalleCompraController;

class CompraController extends Controller
{
    public function listarCompras(){
        $compra = new Compra;
        $compra = $compra->listarCompras();
        return $compra;
    }

    public function listarDetalleCompra(Request $request){
        $detalleCompra = new DetalleCompraController;
        $detalleCompra = $detalleCompra->listarDetalleCompra($request->Compra);
        return $detalleCompra;
    }

    public function guardarCompra(Request $request){
        $datos['Proveedor'] = isset($request->Proveedor) ? $request->Proveedor : 0;
        $datos['Total']     = isset($request->Total) ? $request->Total : 0;

        $compra = new Compra;
        $compra = $compra->guardarCompra($datos);

        $Tipo          = 'Ingreso';
        $detalleCompra = new DetalleCompraController;
        $detalleCompra = $detalleCompra->guardarDetalle($request->Productos, $compra->ID_Compra, $Tipo);

        $caja = new CajaController;
        $datos['Tipo'] = 'Salida';
        $datos['Monto'] = isset($request->Total) ? $request->Total : 0;
        $caja = $caja->actualizarCaja($request->Productos);

        return $detalleCompra;
    }
}