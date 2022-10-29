<?php

namespace App\ImprimirPDF;

use App\Models\Movimiento;
use App\Models\Caja;
use PDF;

class CajaPDF {
    public function imprimir($id_caja){
        $caja = Caja::join('empleado', 'caja.ID_Empleado', 'empleado.ID_Empleado')->findOrFail($id_caja);

        $empleado = $caja->Nombre_Empleado . ' ' . $caja->Apellido_Empleado;

        $movimientos = Movimiento::select('movimiento.*')
            ->join('caja', 'movimiento.ID_Caja', 'caja.ID_Caja')
            ->where('movimiento.ID_Caja', '=', $id_caja)
            ->get();

            $body = '';

            foreach ($movimientos as $valor => $movimiento) {
                $body = $body . '<tr> 
                        <td align="right">'. ($valor + 1) .'</td>
                        <td>'. $movimiento->Tipo_Movimiento .'</td>
                        <td>'. $movimiento->Observacion_Movimiento .'</td>
                        <td align="right">'. sprintf('Bs %s', number_format($movimiento->Monto_Movimiento, 2)) .'</td>
                        
                    </tr>';
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
                    <h2 align="center"> RESUMEN DE CAJA </h2>
                    <div id="margen">
                        <span> <b> CÓDIGO: </b> '. $id_caja .'</span> <br>
                        <span> <b> APERTURA: </b> '. date("d-m-Y", strtotime($caja->Fecha_Apertura)) .'</span> <br>
                        <span> <b> CIERRE: </b> '. date("d-m-Y", strtotime($caja->Fecha_Cierre)) .'</span> <br>
                    </div>
                    <br>
                    <div id="margen">
                        <span> <b> IMPORTE: </b> '. sprintf('Bs %s', number_format($caja->Saldo_Inicial, 2)) .'</span> <br>
                        <span> <b> EMPLEADO: </b> '. $empleado .'</span> <br>
                        <span> <b> OBSERVACION: </b> '. $caja->Observacion .'</span> <br>
                    </div>

                    <table style="width: 100%; margin-bottom: 10px; margin-top: 10px;">
                        <thead>
                            <tr>
                                <th width="5%" align="center">N°</th>
                                <th width="30%" align="center">MOVIMIENTO</th>
                                <th width="45%" align="center">DETALLE</th>
                                <th width="20%" align="center">MONTO</th>
                            </tr>
                        </thead>
                        <tbody>
                            '.
                                $body
                            .'
                        </tbody>
                    </table>
                    <span style="float: right"> <b> SALDO: </b> '. sprintf('Bs %s', number_format($caja->Saldo_Caja, 2)) .'</span> <br><br>
                </div>
            ';

        $pdf = PDF::loadHTML($array)->setPaper('carta')->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        return $pdf->stream('caja.pdf');
    }
}