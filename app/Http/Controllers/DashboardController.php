<?php

namespace App\Http\Controllers;

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
        $compra = $compra->cantidadCompras();
        return $compra;
    }

    public function cantidadVentas(){
        $venta = new Venta;
        $venta = $venta->cantidadVentas();
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

    public function productosStockMinimo(){
        $producto = new Producto;
        $producto = $producto->productosStockMinimo();
        return $producto;
    }
}
