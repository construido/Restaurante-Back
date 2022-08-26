<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimiento;

class MovimientoController extends Controller
{
    
    public function listarMovimientos(Request $request){
            $movimiento = new Movimiento;
            $movimiento = $movimiento->listarMovimientos($request->Caja);
            return $movimiento;
    }

    public function guardarMovimiento($datos){
        $movimiento = new Movimiento;
        $movimiento['Caja']        = $datos['Caja'];
        $movimiento['Monto']       = $datos['Monto'];
        $movimiento['Movimiento']  = $datos['Movimiento'];
        $movimiento['Observacion'] = $datos['Observacion'];
        $movimiento = $movimiento->guardarMovimiento($movimiento);
        return $movimiento;
    }
}
