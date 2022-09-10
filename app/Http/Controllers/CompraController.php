<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\DetalleCompraController;
use App\Http\Controllers\CajaController;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Compra;
use Exception;

class CompraController extends Controller
{
    public function listarCompras(Request $request){
        $compra = new Compra;

        if (JWTAuth::user()->Estado_Login == 1) $compra = $compra->listarComprasAdmin($request);
        else  $compra = $compra->listarComprasUser($request);

        return $compra;
    }

    public function listarDetalleCompra(Request $request){
        $detalleCompra = new DetalleCompraController;
        $detalleCompra = $detalleCompra->listarDetalleCompra($request->Compra);
        return $detalleCompra;
    }

    public function guardarCompra(Request $request){
        $this->validate($request, [
            'Total'     => 'required',
            'Proveedor' => 'required',
            'Productos' => 'required'
        ]);
        
        $datos['Total']     = $request->Total;
        $datos['Proveedor'] = $request->Proveedor["ID_Proveedor"];

        $compra = new Compra;
        $compra = $compra->guardarCompra($datos);

        $Tipo          = 'Ingreso';
        $detalleCompra = new DetalleCompraController;
        $detalleCompra = $detalleCompra->guardarDetalle($request->Productos, $compra->ID_Compra, $Tipo);

        $caja = new CajaController;
        $datos['Tipo']        = 'Salida';
        $datos['Monto']       = $request->Total;
        $datos['Movimiento']  = 'COMPRA';
        $datos['Observacion'] = 'COMPRA DE PRODUCTOS';
        $caja = $caja->actualizarCaja($datos);

        return $detalleCompra;
    }
}