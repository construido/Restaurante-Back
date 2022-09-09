<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Empleado;
use App\Models\Cliente;
use App\Models\Compra;
use App\Models\Venta;

class DashboardController extends Controller
{
    public function cantidadCompras(){
        $compra = new Compra;

        if (JWTAuth::user()->Estado_Login == 1) $compra = $compra->cantidadComprasAdmin();
        else  $compra = $compra->cantidadComprasUser();
        
        return $compra;
    }

    public function cantidadVentas(){
        $venta = new Venta;

        if (JWTAuth::user()->Estado_Login == 1) $venta = $venta->cantidadVentasAdmin();
        else  $venta = $venta->cantidadVentasUser();

        return $venta;
    }

    public function cantidadProductos(){
        $producto = new Producto;
        $producto = $producto->cantidadProductos();
        return $producto;
    }

    public function cantidadClientes(){
        $cliente = new Cliente;
        $cliente = $cliente->cantidadClientes();
        return $cliente;
    }

    public function porcentajeProductos(){
        $producto = new Producto;
        $producto = $producto->porcentajeProductos();
        return $producto;
    }

    public function productoStock(){
        $producto = new Producto;
        $producto = $producto->productoStock();
        return $producto;
    }
}
