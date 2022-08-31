<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Exception;

class ClienteController extends Controller
{
    public function listarClientes(Request $request){
        $cliente = new Cliente;
        $cliente = $cliente->listarClientes($request);
        return $cliente;
    }

    public function listarSelectCliente(){
        $cliente = new Cliente;
        $cliente = $cliente->listarSelectCliente();
        return $cliente;
    }

    public function guardarCliente(Request $request){
        $this->validate($request,[
            'Nombre' => 'required',
            'Correo' => 'required',
            'CI_NIT' => 'required',
            //'CI_NIT' => 'required|unique:cliente',
        ]);

        try {
            $datos['CI_NIT']   = $request->CI_NIT;
            $datos['Nombre']   = $request->Nombre;
            $datos['Correo']   = $request->Correo;
            $datos['Telefono'] = $request->Telefono;
    
            $cliente = new Cliente;
            $cliente = $cliente->guardarCliente($datos);
            return $cliente;
        } catch (Exception $err) {
            $err->getMessage();
        }

    }

    public function actualizarCliente(Request $request){
        $this->validate($request,[
            'ID'     => 'required',
            'Nombre' => 'required',
            'Correo' => 'required',
            'CI_NIT' => 'required',
        ]);

        try {
            $datos['ID']       = $request->ID;
            $datos['CI_NIT']   = $request->CI_NIT;
            $datos['Nombre']   = $request->Nombre;
            $datos['Correo']   = $request->Correo;
            $datos['Telefono'] = $request->Telefono;
    
            $cliente = new Cliente;
            $cliente = $cliente->actualizarCliente($datos);
            return $cliente;
        } catch (Exception $err) {
            $err->getMessage();
        }

    }

    public function actualizarEstadoCliente(Request $request){
        $datos['ID']     = isset($request->ID) ? $request->ID : '';
        $datos['Estado'] = $request->Estado == 1 ? 0 : 1;

        $cliente = new Cliente;
        $cliente = $cliente->actualizarEstadoCliente($datos);
        return $cliente;
    }
}
