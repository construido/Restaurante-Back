<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    public function listarClientes(){
        $cliente = new Cliente;
        $cliente = $cliente->listarClientes();
        return $cliente;
    }

    public function listarSelectCliente(){
        $cliente = new Cliente;
        $cliente = $cliente->listarSelectCliente();
        return $cliente;
    }

    public function guardarCliente(Request $request){
        $datos['CI_NIT']   = isset($request->CI_NIT) ? $request->CI_NIT : 0;
        $datos['Nombre']   = isset($request->Nombre) ? $request->Nombre : '';
        $datos['Correo']   = isset($request->Correo) ? $request->Correo : '';
        $datos['Telefono'] = isset($request->Telefono) ? $request->Telefono : 0;

        $cliente = new Cliente;
        $cliente = $cliente->guardarCliente($datos);
        return $cliente;
    }

    public function actualizarCliente(Request $request){
        $datos['ID']       = isset($request->ID) ? $request->ID : '';
        $datos['CI_NIT']   = isset($request->CI_NIT) ? $request->CI_NIT : 0;
        $datos['Nombre']   = isset($request->Nombre) ? $request->Nombre : '';
        $datos['Correo']   = isset($request->Correo) ? $request->Correo : '';
        $datos['Telefono'] = isset($request->Telefono) ? $request->Telefono : 0;

        $cliente = new Cliente;
        $cliente = $cliente->actualizarCliente($datos);
        return $cliente;
    }

    public function actualizarEstadoCliente(Request $request){
        $datos['ID']     = isset($request->ID) ? $request->ID : '';
        $datos['Estado'] = $request->Estado == 1 ? 0 : 1;

        $cliente = new Cliente;
        $cliente = $cliente->actualizarEstadoCliente($datos);
        return $cliente;
    }
}
