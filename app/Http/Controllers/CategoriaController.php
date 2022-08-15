<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function listarCategoriaSelect(){
        $categoria = new Categoria;
        $categoria = $categoria->listarCategoriaSelect();
        return $categoria;
    }

    public function listarCategorias(Request $request){
        $categoria = new Categoria;
        $categoria = $categoria->listarCategorias($request);
        return $categoria;
    }

    public function guardarCategoria(Request $request){
        $datos['Nombre']      = isset($request->Nombre) ? $request->Nombre : '';
        $datos['Descripcion'] = isset($request->Descripcion) ? $request->Descripcion : '';

        $categoria = new Categoria;
        $categoria = $categoria->guardarCategoria($datos);
        return $categoria;
    }

    public function actualizarCategoria(Request $request){
        $datos['ID']          = isset($request->ID) ? $request->ID : '';
        $datos['Nombre']      = isset($request->Nombre) ? $request->Nombre : '';
        $datos['Descripcion'] = isset($request->Descripcion) ? $request->Descripcion : '';

        $categoria = new Categoria;
        $categoria = $categoria->actualizarCategoria($datos);
        return $categoria;
    }

    public function actualizarEstadoCategoria(Request $request){
        $datos['ID']     = isset($request->ID) ? $request->ID : '';
        $datos['Estado'] = $request->Estado == 1 ? 0 : 1;

        $categoria = new Categoria;
        $categoria = $categoria->actualizarEstadoCategoria($datos);
        return $categoria;
    }
}
