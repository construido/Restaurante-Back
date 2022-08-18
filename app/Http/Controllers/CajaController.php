<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caja;

class CajaController extends Controller
{
    public function ListarCajas(){
        $caja = new Caja;
        $caja = $caja->listarCajas();
        return $caja;
    }

    public function buscarCaja(){
        $caja = new Caja;
        $caja = $caja->buscarCaja();
        return $caja;
    }

    public function AperturaCaja(Request $request){
        $caja = new Caja;
        $Inicio = $request->Inicio > 0 ? $request->Inicio : 0;
        $caja = $caja->AperturaCaja($Inicio);
        return $caja;
    }

    public function actualizarCaja($datos){
        $caja = new Caja;
        $Caja_ID = $this->buscarCaja();
        $datosCaja['Caja']  = $Caja_ID[0]->ID_Caja;
        $datosCaja['Tipo']  = trim($datos['Tipo']);
        $datosCaja['Monto'] = trim($datos['Monto']);
        $caja = $caja->actualizarCaja($datosCaja);
        return $caja;
    }
}
