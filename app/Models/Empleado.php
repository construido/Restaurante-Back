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

    public function listarEmpleados($parametros){
        try {
            DB::beginTransaction();
            $empleados = Empleado::select('empleado.*', 'Estado_Login', 'Fecha_Creacion_Login', 'Usuario', 'ID_Login')
                ->join('login', 'empleado.ID_Empleado', 'login.ID_Empleado')
                ->where('Nombre_Empleado', 'like', '%'.$parametros->filters.'%')
                ->orWhere('Apellido_Empleado', 'like', '%'.$parametros->filters.'%')
                ->orderBy('ID_Empleado', 'DESC')
                ->paginate($parametros->rows);
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
            $empleado->CI_Empleado       = $datos['CI'];
            $empleado->Correo_Empleado   = mb_strtoupper(trim($datos['Correo']), 'UTF-8');
            $empleado->Nombre_Empleado   = mb_strtoupper(trim($datos['Nombre']), 'UTF-8');
            $empleado->Celular_Empleado  = $datos['Celular'];
            $empleado->Apellido_Empleado = mb_strtoupper(trim($datos['Apellido']), 'UTF-8');
            $empleado->save();
            DB::commit();

            $login = new Login;
            $login['Usuario']      = $datos['Usuario'];
            $login['Password']     = $datos['Password'];
            $login['Estado_Login'] = $datos['Rol'];
            $login['ID_Empleado']  = $empleado->ID_Empleado;
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
            $empleado->CI_Empleado       = $datos['CI'];
            $empleado->Correo_Empleado   = mb_strtoupper(trim($datos['Correo']), 'UTF-8');
            $empleado->Nombre_Empleado   = mb_strtoupper(trim($datos['Nombre']), 'UTF-8');
            $empleado->Celular_Empleado  = $datos['Celular'];
            $empleado->Apellido_Empleado = mb_strtoupper(trim($datos['Apellido']), 'UTF-8');
            $empleado->save();
            DB::commit();

            $login = new Login;
            $login['Usuario']     = $datos['Usuario'];
            $login['ID_Login']    = $datos['Login'];
            $login['Estado_Login'] = $datos['Rol'];
            $login['ID_Empleado'] = $datos['ID'];
            $login->editarUsuario($login);
            
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
            
            return $empleado;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
