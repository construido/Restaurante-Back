<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;

class EmpleadoController extends Controller
{
    public function listarEmpleados(){
        $empleado = new Empleado;
        $empleado = $empleado->listarEmpleados();
        return $empleado;
    }

    public function buscarEmpleado(Request $request){
        $empleado = new Empleado;
        $empleado = $empleado->buscarEmpleado($request->idEmpleado);
        return $empleado;
    }

    public function guardarEmpleado(Request $request){
        // tabla empleado
        $datos['CI']       = isset($request->CI) ? $request->CI : '';
        $datos['Foto']     = isset($request->Foto) ? $request->Foto : '';
        $datos['Correo']   = isset($request->Correo) ? $request->Correo : '';
        $datos['Nombre']   = isset($request->Nombre) ? $request->Nombre : '';
        $datos['Celular']  = isset($request->Celular) ? $request->Celular : '';
        $datos['Apellido'] = isset($request->Apellido) ? $request->Apellido : '';

        // tabla login
        $datos['Usuario']    = isset($request->Usuario) ? $request->Usuario : '';
        $datos['Contrasena'] = isset($request->Contrasena) ? $request->Contrasena : '';

        $empleado = new Empleado;
        $empleado = $empleado->guardarEmpleado($datos);
        return $empleado;
    }

    public function actualizarEmpleado(Request $request){
        $datos['ID']       = isset($request->ID) ? $request->ID : '';
        $datos['CI']       = isset($request->CI) ? $request->CI : '';
        $datos['Foto']     = isset($request->Foto) ? $request->Foto : '';
        $datos['Correo']   = isset($request->Correo) ? $request->Correo : '';
        $datos['Nombre']   = isset($request->Nombre) ? $request->Nombre : '';
        $datos['Celular']  = isset($request->Celular) ? $request->Celular : '';
        $datos['Apellido'] = isset($request->Apellido) ? $request->Apellido : '';

        $empleado = new Empleado;
        $empleado = $empleado->actualizarEmpleado($datos);
        return $empleado;
    }

    public function actualizarEstadoEmpleado(Request $request){
        $datos['ID']     = isset($request->ID) ? $request->ID : '';
        $datos['Estado'] = isset($request->Estado) ? $request->Estado : '';

        $empleado = new Empleado;
        $empleado = $empleado->actualizarEstadoEmpleado($datos);
        return $empleado;
    }
}
