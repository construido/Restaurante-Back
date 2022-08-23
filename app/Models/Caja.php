<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Facades\JWTAuth;

use Exception;
use DB;

/**
 * Estado_Caja
 * 0. Inactivo
 * 1. Apertura
 * 2. Cierre
*/

class Caja extends Model
{
    use HasFactory;

    protected $table      = 'caja';
    protected $primaryKey = 'ID_Caja';
    protected $fillable   = [
        'Fecha_Apertura', 'Fecha_Cierre', 'Saldo_Inicial', 'Ingreso_Caja', 'Salida_Caja',
        'Saldo_Caja', 'Observacion', 'Estado_Caja', 'ID_Empleado'];
    public $timestamps = false;

    public function ListarCajas(){
        try {
            DB::beginTransaction();
            $caja = Caja::select('caja.*', (DB::raw('CONCAT(empleado.Nombre_Empleado, " " ,empleado.Apellido_Empleado) as Empleado')))
                ->join('empleado', 'caja.ID_Empleado', 'empleado.ID_Empleado')
                ->orderBy('ID_Caja', 'DESC')
                ->get();
            DB::commit();

            return $caja;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function buscarCaja(){
        try {
            DB::beginTransaction();
            $caja = Caja::select('caja.ID_Caja')
                ->join('empleado', 'caja.ID_Empleado', 'empleado.ID_Empleado')
                ->where('caja.ID_Empleado', '=', JWTAuth::user()->ID_Empleado)
                ->where('caja.Estado_Caja', '=', 1)
                ->get();
            DB::commit();

            return $caja;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function AperturaCaja($Inicio){
        try {
            DB::beginTransaction();
            $caja = new Caja;
            $caja->Fecha_Apertura = date('Y-m-d');
            $caja->Saldo_Inicial  = $Inicio;
            $caja->Observacion    = 'APERTURA DE CAJA';
            $caja->Estado_Caja    = 1;
            $caja->ID_Empleado    = JWTAuth::user()->ID_Empleado;
            $caja->save();
            DB::commit();
            
            return $caja;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function actualizarCaja($datos){
        $salida   = 0;
        $ingreso  = 0;
        $monto    = 0;

        if ($datos['Tipo'] == 'Salida'){
            $monto  = - $datos['Monto'];
            $salida = $datos['Monto'];
        }else{
            $monto   = $datos['Monto'];
            $ingreso = $datos['Monto'];
        }
        try {
            DB::beginTransaction();
            $caja = Caja::findOrFail(trim($datos['Caja']));
            $caja->Ingreso_Caja = $caja->Ingreso_Caja + $ingreso;
            $caja->Salida_Caja  = $caja->Salida_Caja + $salida;
            $caja->Saldo_Caja   = $caja->Saldo_Caja + ($monto);
            $caja->save();
            DB::commit();
            
            return $caja;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function CierreCaja($datos){
        try {
            DB::beginTransaction();
            $caja = Caja::findOrFail(trim($datos['ID']));
            $caja->Fecha_Cierre = date('Y-m-d');
            $caja->Observacion  = 'CIERRE DE CAJA';
            $caja->save();
            DB::commit();
            
            return $caja;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
