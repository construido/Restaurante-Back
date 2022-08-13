<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetalleCompra;
use App\Models\Producto;

class DetalleCompraController extends Controller
{
    public function listarDetalleCompra($Compra){
        $detalleCompra = new DetalleCompra;
        $detalleCompra = $detalleCompra->listarDetalleCompra($Compra);
        return $detalleCompra;
    }

    public function guardarDetalle($Productos, $ID_Compra, $Tipo){
        $detalleCompra = new DetalleCompra;
        $producto      = new Producto;

        for ($i = 0; $i < count($Productos); $i++) {
            $productoDetalle['ID']       = $Productos[$i]["ID"];
            $productoDetalle['Tipo']     = $Tipo;
            $productoDetalle['Cantidad'] = $Productos[$i]["Cantidad"];
            $producto->actualizarCompraVentaProducto($productoDetalle);

            $detalle['Monto']    = $Productos[$i]["Sub_Total"];
            $detalle['Compra']   = $ID_Compra;
            $detalle['Precio']   = $Productos[$i]["Precio"];
            $detalle['Cantidad'] = $Productos[$i]["Cantidad"];
            $detalle['Producto'] = $Productos[$i]["ID"];
            $detalleCompra = $detalleCompra->guardarDetalleCompra($detalle);
        }

        return $detalleCompra;
    }
}
