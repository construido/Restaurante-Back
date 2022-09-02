<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;

class ProveedorController extends Controller
{
    public function listarProveedores(Request $request){
        $proveedor = new Proveedor;
        $proveedor = $proveedor->listarProveedores($request);
        return $proveedor;
    }

    public function listarSelectProveedor(){
        $proveedor = new Proveedor;
        $proveedor = $proveedor->listarSelectProveedor();
        return $proveedor;
    }

    public function guardarProveedor(Request $request){
        $this->validate($request,[
            'CI_NIT'   => 'required',
            'Nombre'   => 'required',
            'Correo'   => 'required|email:rfc,dns',
            'Telefono' => 'required',
        ]);

        try {
            $datos['CI_NIT']   = $request->CI_NIT;
            $datos['Nombre']   = $request->Nombre;
            $datos['Correo']   = $request->Correo;
            $datos['Telefono'] = $request->Telefono;
    
            $proveedor = new Proveedor;
            $proveedor = $proveedor->guardarProveedor($datos);
            return $proveedor;
        } catch (Exception $err) {
            return $err->getMessage();
        }
    }

    public function actualizarProveedor(Request $request){
        $this->validate($request,[
            'CI_NIT'   => 'required',
            'Nombre'   => 'required',
            'Correo'   => 'required|email:rfc,dns',
            'Telefono' => 'required',
        ]);

        try {
            $datos['ID']       = $request->ID;
            $datos['CI_NIT']   = $request->CI_NIT;
            $datos['Nombre']   = $request->Nombre;
            $datos['Correo']   = $request->Correo;
            $datos['Telefono'] = $request->Telefono;
    
            $proveedor = new Proveedor;
            $proveedor = $proveedor->actualizarProveedor($datos);
            return $proveedor;
        } catch (Exception $err) {
            return $err->getMessage();
        }
    }

    public function actualizarEstadoProveedor(Request $request){
        $datos['ID']     = isset($request->ID) ? $request->ID : '';
        $datos['Estado'] = $request->Estado == 1 ? 0 : 1;

        $proveedor = new Proveedor;
        $proveedor = $proveedor->actualizarEstadoProveedor($datos);
        return $proveedor;
    }
}
