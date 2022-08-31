<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimiento;
use App\Models\Caja;
use Exception;

class MovimientoController extends Controller
{
    public function listarMovimientos(Request $request){
        $movimiento = new Movimiento;
        $movimiento = $movimiento->listarMovimientos($request->Caja);
        return $movimiento;
    }

    public function guardarMovimiento($datos){
        $movimiento = new Movimiento;
        $datosMov['Caja']        = $datos['Caja'];
        $datosMov['Monto']       = $datos['Monto'];
        $datosMov['Movimiento']  = $datos['Movimiento'];
        $datosMov['Observacion'] = $datos['Observacion'];
        $movimiento = $movimiento->guardarMovimiento($datosMov);
        return $movimiento;
    }

    public function ingresoSalidaCaja(Request $request){
        $this->validate($request, [
            'Caja'  => 'required',
            'Tipo'  => 'required',
            'Monto' => 'required',
            'Observacion'=> 'required'
        ]);

        try {
            $datos['Caja']  = $request->Caja;
            $datos['Tipo']  = $request->Tipo;
            $datos['Monto'] = $request->Monto;
    
            $caja = new Caja;
            $caja->actualizarCaja($datos);
    
            $movimiento['Caja']        = $request->Caja;
            $movimiento['Monto']       = $request->Monto;
            $movimiento['Movimiento']  = $request->Tipo == 'Ingreso' ? 'INGRESO' : 'SALIDA';
            $movimiento['Observacion'] = $request->Observacion;
            $movimiento = $this->guardarMovimiento($movimiento);
    
            return $movimiento;
        } catch (Exception $err) {
            return $err->getMessage();
        }
    }
}
