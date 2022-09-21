<?php

namespace App\ImprimirPDF;

use App\Models\DetalleVenta;
use App\Models\Venta;
use PDF;

class VentaPDF {
    public function imprimir($id_venta){
        $venta = Venta::join('cliente', 'venta.ID_Cliente', 'cliente.ID_Cliente')
            ->join('empleado', 'venta.ID_Empleado', 'empleado.ID_Empleado')
            ->findOrFail($id_venta);

        $empleado = $venta->Nombre_Empleado . ' ' . $venta->Apellido_Empleado;

        $detalleVenta = DetalleVenta::select('detalle_venta.*', 'producto.Nombre_Producto')
            ->join('producto', 'detalle_venta.ID_Producto', 'producto.ID_Producto')
            ->join('venta', 'detalle_venta.ID_Venta', 'venta.ID_Venta')
            ->where('detalle_venta.ID_Venta', '=', $id_venta)
            ->get();

            $body = '';
            $total = 0;

            foreach ($detalleVenta as $valor => $detalle) {
                $body = $body . '<tr> 
                        <td align="right">'. ($valor + 1) .'</td>
                        <td>'. $detalle->Nombre_Producto .'</td>
                        <td align="right">'. sprintf('Bs %s', number_format($detalle->Precio_Venta, 2)) .'</td>
                        <td align="right">'. $detalle->Cantidad_Venta .'</td>
                        <td align="right">'. sprintf('Bs %s', number_format($detalle->Monto_Parcial_Venta, 2)) .'</td>
                    </tr>';
                
                    $total = $total + $detalle->Monto_Parcial_Venta;
            }
            
            $array = '
                <style>
                    table, th, td {
                        border:1px solid black;
                    }
                    th {
                        background-color: #92a8d1;
                    }
                    td {
                        padding-left: 10px;
                        padding-right: 10px;   
                    }
                    #margen {
                        border:1px solid black;
                        padding-left: 20px;
                        padding-right: 20px;
                    }
                </style>

                <div id="margen">
                    <h2 align="center"> RESUMEN DE VENTA </h2>
                    <div id="margen">
                        <span> <b> FECHA: </b> '. date("d-m-Y", strtotime($venta->Fecha_Venta)) .'</span> <br>
                        <span> <b> CLIENTE: </b> '. $venta->Nombre_Razon_Social_Cliente .'</span> <br>
                        <span> <b> EMPLEADO: </b> '. $empleado .'</span> <br>
                    </div>

                    <table style="width: 100%; margin-bottom: 10px; margin-top: 10px;">
                        <thead>
                            <tr>
                                <th width="5%" align="center">N°</th>
                                <th width="48%" align="center">PRODUCTO</th>
                                <th width="15%" align="center">PRECIO</th>
                                <th width="15%" align="center">CANTIDAD</th>
                                <th width="17%" align="center">SUB TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            '.
                                $body
                            .'
                        </tbody>
                    </table>
                    <span style="float: right"> <b> TOTAL: </b> '. sprintf('Bs %s', number_format($total, 2)) .'</span> <br>
                    <h5 align="center"> *** GRACIAS POR SU COMPRA *** </h5>
                </div>
            ';

        $pdf = PDF::loadHTML($array)->setPaper('carta')->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        return $pdf->stream('venta.pdf');
    }
}