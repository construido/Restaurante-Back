<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimiento;

class MovimientoController extends Controller
{
    
    public function ListarMovimientos(Request $request){
            $movimiento = new Movimiento;
            $movimiento = $movimiento->ListarMovimientos($request->Caja);
            return $movimiento;
    }

    public function guardarMovimiento($datos){
        $movimiento = new Movimiento;
        $movimiento['Caja']        = trim($datos['Caja']);
        $movimiento['Movimiento']  = trim($datos['Tipo']); // 'APERTURA';
        $movimiento['Movimiento']  = trim($datos['Monto']);
        $movimiento['Observacion'] = trim($datos['Observacion']); //'APERTURA DE CAJA';
        $movimiento = $movimiento->guardarMovimiento($movimiento);
        return $movimiento;
}
}
