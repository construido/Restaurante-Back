<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Exception;
use DB;

class DetalleVenta extends Model
{
    use HasFactory;

    protected $table      = 'detalle_venta';
    protected $primaryKey = 'ID_Venta';
    protected $fillable   = ['ID_Producto', 'Precio_Venta', 'Cantidad_Venta', 'Monto_Parcial_Venta'];
    public $timestamps = false;

    public function listarDetalleVenta($Venta){
        try {
            DB::beginTransaction();
            $detalleVenta = DetalleVenta::select('detalle_venta.*', 'producto.Nombre_Producto as Producto')
                ->join('producto', 'detalle_venta.ID_Producto', 'producto.ID_Producto')
                ->join('venta', 'detalle_venta.ID_Venta', 'venta.ID_Venta')
                ->where('detalle_venta.ID_Venta', '=', $Venta)->get();
            DB::commit();

            return $detalleVenta;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function guardarDetalleVenta($datos){
        try {
            DB::beginTransaction();
            $detalleVenta = new DetalleVenta;
            $detalleVenta->ID_Venta            = trim($datos['Venta']);
            $detalleVenta->ID_Producto         = trim($datos['Producto']);
            $detalleVenta->Precio_Venta        = trim($datos['Precio']);
            $detalleVenta->Cantidad_Venta      = trim($datos['Cantidad']);
            $detalleVenta->Monto_Parcial_Venta = trim($datos['Monto']);
            $detalleVenta->save();
            DB::commit();
            
            return $detalleVenta;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
