<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Exception;
use DB;

class DetalleCompra extends Model
{
    use HasFactory;

    protected $table      = 'detalle_compra';
    protected $primaryKey = 'ID_Compra';
    protected $fillable   = ['ID_Producto', 'Precio_Compra', 'Cantidad_Compra', 'Monto_Parcial_Compra'];
    public $timestamps = false;

    public function listarDetalleCompra($Compra){
        try {
            DB::beginTransaction();
            $detalleCompra = DetalleCompra::select('detalle_compra.*', 'producto.Nombre_Producto as Producto')
                ->join('producto', 'detalle_compra.ID_Producto', 'producto.ID_Producto')
                ->join('compra', 'detalle_compra.ID_Compra', 'compra.ID_Compra')
                ->where('detalle_compra.ID_Compra', '=', $Compra)->get();
            DB::commit();

            return $detalleCompra;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function guardarDetalleCompra($datos){
        try {
            DB::beginTransaction();
            $detalleCompra = new DetalleCompra;
            $detalleCompra->ID_Compra            = trim($datos['Compra']);
            $detalleCompra->ID_Producto          = trim($datos['Producto']);
            $detalleCompra->Precio_Compra        = trim($datos['Precio']);
            $detalleCompra->Cantidad_Compra      = trim($datos['Cantidad']);
            $detalleCompra->Monto_Parcial_Compra = trim($datos['Monto']);
            $detalleCompra->save();
            DB::commit();
            
            return $detalleCompra;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
