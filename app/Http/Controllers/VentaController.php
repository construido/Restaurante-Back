<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\DetalleVentaController;
use App\Http\Controllers\CajaController;
use App\Models\Venta;
use Exception;

class VentaController extends Controller
{
    public function listarVentas(Request $request){
        $venta = new Venta;
        $venta = $venta->listarVentas($request);
        return $venta;
    }

    public function listarDetalleVenta(Request $request){
        $detalleVenta = new DetalleVentaController;
        $detalleVenta = $detalleVenta->listarDetalleVenta($request->Venta);
        return $detalleVenta;
    }

    public function validarDatos(Request $request){
        $this->validate($request, [
            'Total'     => 'required',
            'Cliente'   => 'required',
            'Productos' => 'required'
        ]);
    }

    public function guardarVenta(Request $request){
        $this->validarDatos($request);

        try {
            $datos['Total']   = $request->Total;
            $datos['Cliente'] = $request->Cliente["ID_Cliente"];

            $venta = new Venta;
            $venta = $venta->guardarVenta($datos);

            $Tipo         = 'Salida';
            $detalleVenta = new DetalleVentaController;
            $detalleVenta = $detalleVenta->guardarDetalle($request->Productos, $venta->ID_Venta, $Tipo);

            $caja = new CajaController;
            $datos['Tipo']        = 'Ingreso';
            $datos['Monto']       = $request->Total;
            $datos['Movimiento']  = 'VENTA';
            $datos['Observacion'] = 'VENTA DE PRODUCTOS';
            $caja = $caja->actualizarCaja($datos);

            return $venta;
        } catch (Exception $err) {
            return $err->getMessage();
        }
    }
}
