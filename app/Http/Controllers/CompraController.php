<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
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

        $Productos = [];
        $Productos = $request->Productos[0]["Precio"];

        $compra = new Compra;
        $compra = $compra->guardarCompra($datos);

        $Tipo          = 'Ingreso';
        $detalleCompra = new DetalleCompraController;
        $detalleCompra = $detalleCompra->guardarDetalle($request->Productos, $compra->ID_Compra, $Tipo);

        return $detalleCompra;
    }
}
