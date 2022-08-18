<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetalleVenta;
use App\Models\Producto;

class DetalleVentaController extends Controller
{
    public function listarDetalleVenta($Venta){
        $detalleVenta = new DetalleVenta;
        $detalleVenta = $detalleVenta->listarDetalleVenta($Venta);
        return $detalleVenta;
    }

    public function guardarDetalle($Productos, $ID_Venta, $Tipo){
        $detalleVenta = new DetalleVenta;
        $producto      = new Producto;

        for ($i = 0; $i < count($Productos); $i++) {
            $productoDetalle['ID']       = $Productos[$i]["ID"];
            $productoDetalle['Tipo']     = $Tipo;
            $productoDetalle['Cantidad'] = $Productos[$i]["Cantidad"];
            $producto->actualizarCompraVentaProducto($productoDetalle);

            $detalle['Monto']    = $Productos[$i]["Sub_Total"];
            $detalle['Venta']    = $ID_Venta;
            $detalle['Precio']   = $Productos[$i]["Precio"];
            $detalle['Cantidad'] = $Productos[$i]["Cantidad"];
            $detalle['Producto'] = $Productos[$i]["ID"];
            $detalleVenta = $detalleVenta->guardarDetalleVenta($detalle);
        }

        return $detalleVenta;
    }
}
