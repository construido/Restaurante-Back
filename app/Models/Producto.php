<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Exception;
use DB;

class Producto extends Model
{
    use HasFactory;

    protected $table      = 'producto';
    protected $primaryKey = 'ID_Producto';
    protected $fillable   = [
        'Nombre_Producto', 'Precio_Compra_P', 'Precio_Venta_P', 'Ingreso_Producto', 'Salida_Producto', 'Stock',
        'Stock_Minimo', 'Foto_Producto', 'Descripcion_Producto','Estado_Producto', 'ID_Categoria'
    ];
    public $timestamps = false;

    public function listarProductos(){
        try {
            DB::beginTransaction();
            $producto = Producto::select('producto.*', 'categoria.Nombre_Categoria as Categoria')
                ->join('categoria', 'producto.ID_Categoria', 'categoria.ID_Categoria')
                ->get();
            DB::commit();

            return $producto;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function buscarProducto($Nombre){
        try {
            DB::beginTransaction();
            $producto = Producto::select('producto.*', 'categoria.Nombre_Categoria as Categoria')
                ->join('categoria', 'producto.ID_Categoria', 'categoria.ID_Categoria')
                ->where('producto.Nombre_Producto', '=', $Nombre)
                ->get();
            DB::commit();

            return $producto;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function guardarProducto($datos){
        try {
            DB::beginTransaction();
            $producto = new Producto;
            $producto->Precio_Venta_P       = trim($datos['Venta']);
            $producto->Stock                = trim($datos['Stock']);
            $producto->Nombre_Producto      = trim($datos['Nombre']);
            $producto->Precio_Compra_P      = trim($datos['Compra']);
            $producto->Salida_Producto      = trim($datos['Salida']);
            $producto->Stock_Minimo         = trim($datos['Minimo']);
            $producto->Ingreso_Producto     = trim($datos['Ingreso']);
            $producto->ID_Categoria         = trim($datos['Categoria']);
            $producto->Descripcion_Producto = trim($datos['Descripcion']);
            $producto->save();
            DB::commit();
            
            return $producto;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function actualizarProducto($datos){
        try {
            DB::beginTransaction();
            $producto = Producto::findOrFail(trim($datos['ID']));
            $producto->Precio_Venta_P       = trim($datos['Venta']);
            $producto->Stock                = trim($datos['Stock']);
            $producto->Nombre_Producto      = trim($datos['Nombre']);
            $producto->Precio_Compra_P      = trim($datos['Compra']);
            $producto->Salida_Producto      = trim($datos['Salida']);
            $producto->Stock_Minimo         = trim($datos['Minimo']);
            $producto->Ingreso_Producto     = trim($datos['Ingreso']);
            $producto->ID_Categoria         = trim($datos['Categoria']);
            $producto->Descripcion_Producto = trim($datos['Descripcion']);
            $producto->save();
            DB::commit();
            
            return $producto;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function actualizarCompraVentaProducto($datos){
        $salida   = 0;
        $ingreso  = 0;
        $cantidad = 0;

        if ($datos['Tipo'] == 'Ingreso'){
            $ingreso  = $datos['Cantidad'];
            $cantidad = $datos['Cantidad'];
        }else{
            $salida   = $datos['Cantidad'];
            $cantidad = - $datos['Cantidad'];
        }

        try {
            DB::beginTransaction();
            $producto = Producto::findOrFail(trim($datos['ID']));
            $producto->Stock            = $producto->Stock + ($cantidad);
            $producto->Salida_Producto  = $producto->Salida_Producto + $salida;
            $producto->Ingreso_Producto = $producto->Ingreso_Producto + $ingreso;
            $producto->save();
            DB::commit();
            
            return $producto;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function actualizarEstadoProducto($datos){
        try {
            DB::beginTransaction();
            $producto = Producto::findOrFail(trim($datos['ID']));
            $producto->Estado_Producto = trim($datos['Estado']);
            $producto->save();
            DB::commit();
            
            return $producto;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
