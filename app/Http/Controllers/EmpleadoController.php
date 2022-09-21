<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Login;

class EmpleadoController extends Controller
{
    public function listarEmpleados(Request $request){
        $empleado = new Empleado;
        $empleado = $empleado->listarEmpleados($request);
        return $empleado;
    }

    public function buscarEmpleado(Request $request){
        $empleado = new Empleado;
        $empleado = $empleado->buscarEmpleado($request->idEmpleado);
        return $empleado;
    }

    public function guardarEmpleado(Request $request){
        // tabla empleado
        $this->validate($request, [
            'CI'       => 'required',
            'Rol'      => 'required',
            'Correo'   => 'required',
            'Nombre'   => 'required',
            'Celular'  => 'required',
            'Apellido' => 'required',
            'Usuario'  => 'required',
            'Password' => 'required',
        ]);
        $datos['CI']       = $request->CI;
        $datos['Correo']   = $request->Correo;
        $datos['Nombre']   = $request->Nombre;
        $datos['Celular']  = $request->Celular;
        $datos['Apellido'] = $request->Apellido;

        // tabla login
        $this->validate($request, [
            'Usuario'  => 'required',
            'Password' => 'required'
        ]);
        $datos['Usuario']  = isset($request->Usuario) ? $request->Usuario : '';
        $datos['Password'] = isset($request->Password) ? $request->Password : '';
        $datos['Rol']      = $request->Rol;

        $empleado = new Empleado;
        $empleado = $empleado->guardarEmpleado($datos);
        return $empleado;
    }

    public function actualizarEmpleado(Request $request){
        $this->validate($request, [
            'CI'       => 'required',
            'Rol'      => 'required',
            'Correo'   => 'required',
            'Nombre'   => 'required',
            'Celular'  => 'required',
            'Apellido' => 'required',
            'Usuario'  => 'required',
        ]);
        $datos['ID']       = $request->ID;
        $datos['CI']       = $request->CI;
        $datos['Rol']      = $request->Rol;
        $datos['Login']    = $request->Login;
        $datos['Correo']   = $request->Correo;
        $datos['Nombre']   = $request->Nombre;
        $datos['Celular']  = $request->Celular;
        $datos['Usuario']  = $request->Usuario;
        $datos['Apellido'] = $request->Apellido;

        $empleado = new Empleado;
        $empleado = $empleado->actualizarEmpleado($datos);
        return $empleado;
    }

    public function actualizarEstadoEmpleado(Request $request){
        $datos['ID']     = $request->ID;
        $datos['Estado'] = $request->Estado == 1 ? 0 : 1;

        $empleado = new Empleado;
        $empleado = $empleado->actualizarEstadoEmpleado($datos);
        return $empleado;
    }

    public function actualizarContrasena(Request $request){
        $this->validate($request, [
            'Password'     => 'required',
            'Rep_Password' => 'required',
        ]);
        $datos['ID']           = $request->ID;
        $datos['Login']        = $request->Login;
        $datos['Password']     = $request->Password;
        $datos['Rep_Password'] = $request->Rep_Password;

        $login = new Login;
        $login = $login->actualizarContrasena($datos);
        return $login;
    }
}
