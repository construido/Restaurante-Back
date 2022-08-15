<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;

class ProveedorController extends Controller
{
    public function listarProveedores(){
        $proveedor = new Proveedor;
        $proveedor = $proveedor->listarProveedores();
        return $proveedor;
    }

    public function listarSelectProveedor(){
        $proveedor = new Proveedor;
        $proveedor = $proveedor->listarSelectProveedor();
        return $proveedor;
    }

    public function guardarProveedor(Request $request){
        $datos['CI_NIT']   = isset($request->CI_NIT) ? $request->CI_NIT : 0;
        $datos['Nombre']   = isset($request->Nombre) ? $request->Nombre : '';
        $datos['Correo']   = isset($request->Correo) ? $request->Correo : '';
        $datos['Telefono'] = isset($request->Telefono) ? $request->Telefono : 0;

        $proveedor = new Proveedor;
        $proveedor = $proveedor->guardarProveedor($datos);
        return $proveedor;
    }

    public function actualizarProveedor(Request $request){
        $datos['ID']       = isset($request->ID) ? $request->ID : '';
        $datos['CI_NIT']   = isset($request->CI_NIT) ? $request->CI_NIT : 0;
        $datos['Nombre']   = isset($request->Nombre) ? $request->Nombre : '';
        $datos['Correo']   = isset($request->Correo) ? $request->Correo : '';
        $datos['Telefono'] = isset($request->Telefono) ? $request->Telefono : 0;

        $proveedor = new Proveedor;
        $proveedor = $proveedor->actualizarProveedor($datos);
        return $proveedor;
    }

    public function actualizarEstadoProveedor(Request $request){
        $datos['ID']     = isset($request->ID) ? $request->ID : '';
        $datos['Estado'] = $request->Estado == 1 ? 0 : 1;

        $proveedor = new Proveedor;
        $proveedor = $proveedor->actualizarEstadoProveedor($datos);
        return $proveedor;
    }
}
