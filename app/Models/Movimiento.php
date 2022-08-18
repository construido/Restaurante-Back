<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Exception;
use DB;

class Movimiento extends Model
{
    use HasFactory;

    protected $table      = 'movimiento';
    protected $primaryKey = 'ID_Movimiento';
    protected $fillable   = ['Tipo_Movimiento', 'Monto_Movimiento', 'Observacion_Movimiento','Estado_Movimiento', 'ID_Caja'];
    public $timestamps = false;

    public function ListarMovimientos($Caja){
        try {
            DB::beginTransaction();
            $movimiento = Movimiento::select('movimiento.*')
                ->join('caja', 'movimiento.ID_Caja', 'caja.ID_Caja')
                ->where('movimiento.ID_Caja', '=', $Caja)
                ->get();
            DB::commit();

            return $movimiento;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function guardarMovimiento($datos){
        try {
            DB::beginTransaction();
            $movimiento = new Movimiento;
            $movimiento->ID_Caja                = trim($datos['Caja']);
            $movimiento->Tipo_Movimiento        = trim($datos['Tipo']); // 'APERTURA';
            $movimiento->Monto_Movimiento       = trim($datos['Monto']);
            $movimiento->Observacion_Movimiento = trim($datos['Observacion']); //'APERTURA DE CAJA';
            $movimiento->save();
            DB::commit();
            
            return $movimiento;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
