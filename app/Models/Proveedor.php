<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Exception;
use DB;

class Proveedor extends Model
{
    use HasFactory;

    protected $table      = 'proveedor';
    protected $primaryKey = 'ID_Proveedor';
    protected $fillable   = ['Nombre_Razon_Social_Proveedor', 'CI_NIT_Proveedor', 'Telefono_Proveedor', 'Correo_Proveedor', 'Estado_Proveedor'];
    public $timestamps = false;

    public function listarProveedores(){
        try {
            DB::beginTransaction();
            $proveedor = Proveedor::get();
            DB::commit();

            return $proveedor;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function listarSelectProveedor(){
        try {
            DB::beginTransaction();
            $proveedor = Proveedor::select('ID_Proveedor', 'Nombre_Razon_Social_Proveedor')
                ->where('Estado_Proveedor', '=', 1)
                ->get();
            DB::commit();

            return $proveedor;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function guardarProveedor($datos){
        try {
            DB::beginTransaction();
            $proveedor = new Proveedor;
            $proveedor->CI_NIT_Proveedor              = trim($datos['CI_NIT']);
            $proveedor->Correo_Proveedor              = trim($datos['Correo']);
            $proveedor->Telefono_Proveedor            = trim($datos['Telefono']);
            $proveedor->Nombre_Razon_Social_Proveedor = trim($datos['Nombre']);
            $proveedor->save();
            DB::commit();
            
            return $proveedor;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function actualizarProveedor($datos){
        try {
            DB::beginTransaction();
            $proveedor = Proveedor::findOrFail(trim($datos['ID']));
            $proveedor->CI_NIT_Proveedor              = trim($datos['CI_NIT']);
            $proveedor->Correo_Proveedor              = trim($datos['Correo']);
            $proveedor->Telefono_Proveedor            = trim($datos['Telefono']);
            $proveedor->Nombre_Razon_Social_Proveedor = trim($datos['Nombre']);
            $proveedor->save();
            DB::commit();
            
            return $proveedor;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function actualizarEstadoProveedor($datos){
        try {
            DB::beginTransaction();
            $proveedor = Proveedor::findOrFail(trim($datos['ID']));
            $proveedor->Estado_Proveedor = trim($datos['Estado']);
            $proveedor->save();
            DB::commit();
            
            return $proveedor;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
