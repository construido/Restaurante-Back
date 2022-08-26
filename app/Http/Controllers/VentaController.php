<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Http\Controllers\DetalleVentaController;

class VentaController extends Controller
{
    public function listarVentas(){
        $venta = new Venta;
        $venta = $venta->listarVentas();
        return $venta;
    }

    public function listarDetalleVenta(Request $request){
        $detalleVenta = new DetalleVentaController;
        $detalleVenta = $detalleVenta->listarDetalleVenta($request->Venta);
        return $detalleVenta;
    }

    public function guardarVenta(Request $request){
        $datos['Cliente'] = isset($request->Cliente) ? $request->Cliente : 0;
        $datos['Total']   = isset($request->Total) ? $request->Total : 0;

        $venta = new Venta;
        $venta = $venta->guardarVenta($datos);

        $Tipo         = 'Salida';
        $detalleVenta = new DetalleVentaController;
        $detalleVenta = $detalleVenta->guardarDetalle($request->Productos, $venta->ID_Venta, $Tipo);

        $caja = new CajaController;
        $datos['Tipo']        = 'Ingreso';
        $datos['Monto']       = isset($request->Total) ? $request->Total : 0;
        $datos['Movimiento']  = 'VENTA';
        $datos['Observacion'] = 'VENTA DE PRODUCTOS';
        $caja = $caja->actualizarCaja($datos);

        return $detalleVenta;
    }
}
