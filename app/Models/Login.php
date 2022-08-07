<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

use Exception;
use Hash;
use DB;

/*
    Estado_Login
    1 Administrator
    2 Cajero
    3 Inactivo
    4 Inactivo definitivamente
*/

class Login extends Authenticatable implements JWTSubject //Model
{
    use HasFactory;

    protected $table      = 'login';
    protected $primaryKey = 'ID_Login';
    protected $fillable   = [
        'Usuario', 'Contrasena', 'Fecha_Creacion_Login','Estado_Login', 'ID_Empleado'
    ];

    public $timestamps = false;

    public function guardarLogin($datos){
        try {
            DB::beginTransaction();
            $login = new Login;
            $login->Usuario              = trim($datos['Usuario']);
            $login->Contrasena           = Hash::make(trim($datos['Contrasena']));
            $login->ID_Empleado          = trim($datos['ID_Empleado']);
            $login->Fecha_Creacion_Login = date('Y-m-d');
            $login->save();
            DB::commit();

            return $login;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }


    public function actualizarEstadoLogin($datos){
        try {
            DB::beginTransaction();
            $login = Login::findOrFail(trim($datos['ID_Empleado']));
            $login->Estado_Login = trim($datos['Estado']);
            $login->save();
            DB::commit();
            
            return $login;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

    public function getAuthPassword()
    {
        return $this->Contrasena;
    }
}
