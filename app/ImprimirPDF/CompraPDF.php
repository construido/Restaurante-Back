<?php

namespace App\ImprimirPDF;

use App\Models\DetalleCompra;
use App\Models\Compra;
use PDF;

class CompraPDF {
    public function imprimir($id_compra){
        $compra = Compra::join('proveedor', 'compra.ID_Proveedor', 'proveedor.ID_Proveedor')
            ->join('empleado', 'compra.ID_Empleado', 'empleado.ID_Empleado')
            ->findOrFail($id_compra);

        $empleado = $compra->Nombre_Empleado . ' ' . $compra->Apellido_Empleado;

        $detalleCompra = DetalleCompra::select('detalle_compra.*', 'producto.Nombre_Producto')
            ->join('producto', 'detalle_compra.ID_Producto', 'producto.ID_Producto')
            ->join('compra', 'detalle_compra.ID_Compra', 'compra.ID_Compra')
            ->where('detalle_compra.ID_Compra', '=', $id_compra)
            ->get();

            $body = '';
            $total = 0;

            foreach ($detalleCompra as $valor => $detalle) {
                $body = $body . '<tr> 
                        <td align="right">'. ($valor + 1) .'</td>
                        <td>'. $detalle->Nombre_Producto .'</td>
                        <td align="right">'. sprintf('Bs %s', number_format($detalle->Precio_Compra, 2)) .'</td>
                        <td align="right">'. $detalle->Cantidad_Compra .'</td>
                        <td align="right">'. sprintf('Bs %s', number_format($detalle->Monto_Parcial_Compra, 2)) .'</td>
                    </tr>';
                
                    $total = $total + $detalle->Monto_Parcial_Compra;
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
                    <h2 align="center"> RESUMEN DE COMPRA </h2>
                    <div id="margen">
                        <span> <b> FECHA: </b> '. date("d-m-Y", strtotime($compra->Fecha_Compra)) .'</span> <br>
                        <span> <b> PROVEEDOR: </b> '. $compra->Nombre_Razon_Social_Proveedor .'</span> <br>
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
        return $pdf->stream('compra.pdf');
    }
}