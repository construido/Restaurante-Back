<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caja;
use App\Http\Controllers\MovimientoController;

class CajaController extends Controller
{
    public function listarCajas(Request $request){
        $caja = new Caja;
        $caja = $caja->listarCajas($request);
        return $caja;
    }

    public function buscarCaja(){
        $caja = new Caja;
        $caja = $caja->buscarCaja();
        return $caja;
    }

    public function aperturaCaja(Request $request){
        $buscar = $this->buscarCaja();
        if (isset($buscar[0]->ID_Caja)) return 1;

        $caja = new Caja;
        $datos['Inicio']      = $request->Inicio > 0 ? $request->Inicio : 0;
        $datos['Observacion'] = isset($request->Observacion) ? $request->Observacion : '';
        $caja = $caja->aperturaCaja($datos);

        $movimiento = new MovimientoController;
        $datosMov['Caja']        = $caja->ID_Caja;
        $datosMov['Monto']       = $request->Inicio > 0 ? $request->Inicio : 0;
        $datosMov['Movimiento']  = 'APERTURA';
        $datosMov['Observacion'] = 'APERTURA DE CAJA';
        $movimiento = $movimiento->guardarMovimiento($datosMov);

        return $caja;
    }

    public function actualizarCaja($datos){
        $caja = new Caja;
        $Caja_ID = $this->buscarCaja();
        $datosCaja['Caja']  = $Caja_ID[0]->ID_Caja;
        $datosCaja['Tipo']  = trim($datos['Tipo']);
        $datosCaja['Monto'] = trim($datos['Monto']);
        $caja = $caja->actualizarCaja($datosCaja);

        $movimiento = new MovimientoController;
        $datosMov['Caja']        = $Caja_ID[0]->ID_Caja;
        $datosMov['Monto']       = trim($datos['Monto']);
        $datosMov['Movimiento']  = trim($datos['Movimiento']);
        $datosMov['Observacion'] = trim($datos['Observacion']);
        $movimiento = $movimiento->guardarMovimiento($datosMov);

        return $caja;
    }

    public function cierreCaja(Request $request){
        $caja = new Caja;
        $datos['ID']          = $request->ID;
        $datos['Observacion'] = isset($request->Observacion) ? $request->Observacion : '';
        $caja = $caja->cierreCaja($datos);

        $movimiento = new MovimientoController;
        $datosMov['Caja']        = $request->ID;
        $datosMov['Monto']       = 0;
        $datosMov['Movimiento']  = 'CIERRE';
        $datosMov['Observacion'] = 'CIERRE DE CAJA';
        $movimiento = $movimiento->guardarMovimiento($datosMov);

        return $caja;
    }
}
