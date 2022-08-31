<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Proveedor;
use App\Models\Empleado;

use Exception;
use DB;

class Compra extends Model
{
    use HasFactory;

    protected $table      = 'compra';
    protected $primaryKey = 'ID_Compra';
    protected $fillable   = ['Fecha_Compra', 'Monto_Total_Compra', 'Estado_Compra', 'ID_Empleado', 'ID_Proveedor'];
    public $timestamps = false;

    public function cantidadCompras(){
        try {
            DB::beginTransaction();
            $compra = Compra::select(DB::raw('COUNT(ID_Compra) as Compra'), DB::raw('SUM(Monto_Total_Compra) as Total'))
                ->where('Fecha_Compra', '=', date('Y-m-d'))
                ->where('Estado_Compra', '=', 1)
                ->get();
            DB::commit();

            return $compra;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function listarCompras($parametros){
        try {
            DB::beginTransaction();
            $compra = Compra::select('compra.*', 'proveedor.Nombre_Razon_Social_Proveedor as Proveedor',
                (DB::raw('CONCAT(empleado.Nombre_Empleado, " " ,empleado.Apellido_Empleado) as Empleado')))
                ->join('empleado', 'compra.ID_Empleado', 'empleado.ID_Empleado')
                ->join('proveedor', 'compra.ID_Proveedor', 'proveedor.ID_Proveedor')
                ->where('Estado_Compra', '=', 1)
                ->OrderBy('compra.ID_Compra', 'DESC')
                ->paginate($parametros->rows);
            DB::commit();

            return $compra;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function guardarCompra($datos){
        try {
            DB::beginTransaction();
            $compra = new Compra;
            $compra->ID_Empleado        = JWTAuth::user()->ID_Empleado;
            $compra->ID_Proveedor       = trim($datos['Proveedor']);
            $compra->Fecha_Compra       = date('Y-m-d');
            $compra->Monto_Total_Compra = trim($datos['Total']);
            $compra->save();
            DB::commit();
            
            return $compra;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function eliminarCompra($datos){
        try {
            DB::beginTransaction();
            $compra = Compra::findOrFail(trim($datos['ID']));
            $compra->Estado_Compra = 0;
            $compra->save();
            DB::commit();
            
            return $compra;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
