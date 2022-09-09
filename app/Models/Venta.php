<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Facades\JWTAuth;

use Exception;
use DB;

class Venta extends Model
{
    use HasFactory;

    protected $table      = 'venta';
    protected $primaryKey = 'ID_Venta';
    protected $fillable   = ['Fecha_Venta', 'Monto_Total_Venta', 'Estado_Venta', 'ID_Empleado', 'ID_Cliente'];
    public $timestamps = false;

    public function cantidadVentasAdmin(){
        try {
            DB::beginTransaction();
            $venta = Venta::select(DB::raw('COUNT(ID_Venta) as Venta'), DB::raw('SUM(Monto_Total_Venta) as Total'))
                ->where('Fecha_Venta', '=', date('Y-m-d'))
                ->where('Estado_Venta', '=', 1)
                ->get();
            DB::commit();

            return $venta;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function cantidadVentasUser(){
        try {
            DB::beginTransaction();
            $venta = Venta::select(DB::raw('COUNT(ID_Venta) as Venta'), DB::raw('SUM(Monto_Total_Venta) as Total'))
                ->where('venta.ID_Empleado', '=', JWTAuth::user()->ID_Empleado)
                ->where('Fecha_Venta', '=', date('Y-m-d'))
                ->where('Estado_Venta', '=', 1)
                ->get();
            DB::commit();

            return $venta;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function listarVentasAdmin($parametros){
        try {
            DB::beginTransaction();
            $venta = Venta::select('venta.*', 'cliente.Nombre_Razon_Social_cliente as Cliente',
                (DB::raw('CONCAT(empleado.Nombre_Empleado, " " ,empleado.Apellido_Empleado) as Empleado')))
                ->join('empleado', 'venta.ID_Empleado', 'empleado.ID_Empleado')
                ->join('cliente', 'venta.ID_cliente', 'cliente.ID_cliente')
                ->where('Estado_Venta', '=', 1)
                ->OrderBy('venta.ID_Venta', 'DESC')
                ->paginate($parametros->rows);
            DB::commit();

            return $venta;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function listarVentasUser($parametros){
        try {
            DB::beginTransaction();
            $venta = Venta::select('venta.*', 'cliente.Nombre_Razon_Social_cliente as Cliente',
                (DB::raw('CONCAT(empleado.Nombre_Empleado, " " ,empleado.Apellido_Empleado) as Empleado')))
                ->join('empleado', 'venta.ID_Empleado', 'empleado.ID_Empleado')
                ->join('cliente', 'venta.ID_cliente', 'cliente.ID_cliente')
                ->where('venta.ID_Empleado', '=', JWTAuth::user()->ID_Empleado)
                ->where('Estado_Venta', '=', 1)
                ->OrderBy('venta.ID_Venta', 'DESC')
                ->paginate($parametros->rows);
            DB::commit();

            return $venta;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function guardarVenta($datos){
        try {
            DB::beginTransaction();
            $venta = new Venta;
            $venta->ID_Empleado       = JWTAuth::user()->ID_Empleado;
            $venta->ID_Cliente        = trim($datos['Cliente']);
            $venta->Fecha_Venta       = date('Y-m-d');
            $venta->Monto_Total_Venta = trim($datos['Total']);
            $venta->save();
            DB::commit();
            
            return $venta;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function eliminarVenta($datos){
        try {
            DB::beginTransaction();
            $venta = Venta::findOrFail(trim($datos['ID']));
            $venta->Estado_Venta = 0;
            $venta->save();
            DB::commit();
            
            return $venta;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
