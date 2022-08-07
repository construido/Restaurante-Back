<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Login;

use Exception;
use DB;

/*
    Estado Empleado
    1 Activo
    2 En Espera
    3 Inactivo
    4 Inactivo definitivamente
*/

class Empleado extends Model
{
    use HasFactory;

    protected $table      = 'empleado';
    protected $primaryKey = 'ID_Empleado';
    protected $fillable   = [
        'Nombre_Empleado', 'Apellido_Empleado', 'Correo_Empleado',
        'CI_Empleado', 'Celular_Empleado', 'Foto_Empleado', 'Estado_Empleado'
    ];

    public $timestamps = false;

    public function listarEmpleados(){
        try {
            DB::beginTransaction();
            $empleados = Empleado::get();
            DB::commit();

            return $empleados;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function buscarEmpleado($datos){
        try {
            DB::beginTransaction();
            $empleados = Empleado::where('ID_Empleado', '=', $datos)->get(); // devuelve un arrelgo de empleados            
            //$empleados = Empleado::findOrFail($datos); // devuelve un objeto de empleado
            DB::commit();

            return $empleados;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function guardarEmpleado($datos){
        try {
            DB::beginTransaction();
            $empleado = new Empleado;
            $empleado->CI_Empleado       = trim($datos['CI']);
            $empleado->Foto_Empleado     = trim($datos['Foto']);
            $empleado->Correo_Empleado   = trim($datos['Correo']);
            $empleado->Nombre_Empleado   = trim($datos['Nombre']);
            $empleado->Celular_Empleado  = trim($datos['Celular']);
            $empleado->Apellido_Empleado = trim($datos['Apellido']);
            $empleado->save();
            DB::commit();

            $login = new Login;
            $login['Usuario']     = $datos['Usuario'];
            $login['Contrasena']  = $datos['Contrasena'];
            $login['ID_Empleado'] = $empleado->ID_Empleado;
            $login->guardarLogin($login);
            
            return $empleado;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function actualizarEmpleado($datos){
        try {
            DB::beginTransaction();
            $empleado = Empleado::findOrFail(trim($datos['ID']));
            $empleado->CI_Empleado       = trim($datos['CI']);
            $empleado->Foto_Empleado     = trim($datos['Foto']);
            $empleado->Correo_Empleado   = trim($datos['Correo']);
            $empleado->Nombre_Empleado   = trim($datos['Nombre']);
            $empleado->Celular_Empleado  = trim($datos['Celular']);
            $empleado->Apellido_Empleado = trim($datos['Apellido']);
            $empleado->save();
            DB::commit();
            
            return $empleado;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function actualizarEstadoEmpleado($datos){
        try {
            DB::beginTransaction();
            $empleado = Empleado::findOrFail(trim($datos['ID']));
            $empleado->Estado_Empleado = trim($datos['Estado']);
            $empleado->save();
            DB::commit();

            $login = new Login;
            if($datos['Estado'] > 2){
                $login['Estado']      = $datos['Estado'];
            }elseif($datos['Estado'] == 1){
                $login['Estado']      = 2;
                $login['ID_Empleado'] = $datos['ID'];
            }
            $login['ID_Empleado'] = $datos['ID'];
            $login->actualizarEstadoLogin($login);
            
            return $empleado;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
