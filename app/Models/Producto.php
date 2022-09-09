<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DateTime;
use Exception;
use DB;

class Producto extends Model
{
    use HasFactory;

    protected $table      = 'producto';
    protected $primaryKey = 'ID_Producto';
    protected $fillable   = [
        'Nombre_Producto', 'Precio_Compra_P', 'Precio_Venta_P', 'Ingreso_Producto', 'Salida_Producto', 'Stock',
        'Stock_Minimo', 'Foto_Producto', 'Descripcion_Producto','Estado_Producto', 'ID_Categoria', 'Codigo_Producto'
    ];
    public $timestamps = false;

    public function porcentajeProductos(){
        try {
            DB::beginTransaction();
            $producto = Producto::select('Nombre_Producto', 'Nombre_Categoria',
                (DB::raw('CONCAT(ROUND(SUM((Cantidad_venta / ( SELECT SUM( Cantidad_venta ) FROM producto, detalle_venta, venta
                    WHERE detalle_venta.ID_Producto = producto.ID_Producto AND detalle_venta.ID_venta = venta.ID_venta
                    AND YEAR(Fecha_Venta) = YEAR("'.date('Y-m-d').'") AND MONTH(Fecha_Venta) = MONTH("'.date('Y-m-d').'")) * 100 )), 2), "%") as Porcentaje')))
                ->join('categoria', 'producto.ID_Categoria', 'categoria.ID_Categoria')
                ->join('detalle_venta', 'producto.ID_Producto', 'detalle_venta.ID_Producto')
                ->join('venta', 'detalle_venta.ID_Venta', 'venta.ID_Venta')
                ->where(DB::raw('YEAR(venta.Fecha_Venta)'), '=', DB::raw('YEAR("'.date('Y-m-d').'")'))
                ->where(DB::raw('MONTH(venta.Fecha_Venta)'), '=', DB::raw('MONTH("'.date('Y-m-d').'")'))
                ->groupBy('detalle_venta.ID_Producto')
                ->orderBy('Porcentaje', 'DESC')
                ->limit(3)
                ->get();
            DB::commit();

            return $producto;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function productoStock(){
        try {
            DB::beginTransaction();
            $producto = Producto::select('Nombre_Producto', 'Nombre_Categoria', 'Stock')
                ->join('categoria', 'producto.ID_Categoria', 'categoria.ID_Categoria')
                ->whereColumn('Stock', '<=', 'Stock_Minimo')
                ->get();
            DB::commit();
            
            return $producto;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function cantidadProductos(){
        try {
            DB::beginTransaction();
            $producto = Producto::select(DB::raw('COUNT(ID_Producto) as Producto'))
                ->where('Estado_Producto', '=', 1)
                ->get();
            DB::commit();

            return $producto;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function listarProductos($parametros){
        try {
            DB::beginTransaction();
            $producto = Producto::select('producto.*', 'categoria.Nombre_Categoria as Categoria')
                ->join('categoria', 'producto.ID_Categoria', 'categoria.ID_Categoria')
                ->where('Nombre_Producto', 'like', '%'.$parametros->filters.'%')
                ->orderBy('ID_Producto', 'DESC')
                ->paginate($parametros->rows);
            DB::commit();

            return $producto;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function buscarProducto($Codigo){
        try {
            DB::beginTransaction();
            $producto = Producto::select('producto.*', 'categoria.Nombre_Categoria as Categoria')
                ->join('categoria', 'producto.ID_Categoria', 'categoria.ID_Categoria')
                ->where('producto.Codigo_Producto', '=', $Codigo)
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
            $producto->Precio_Venta_P       = $datos['Venta'];
            $producto->Stock                = $datos['Ingreso'];
            $producto->Nombre_Producto      = mb_strtoupper(trim($datos['Nombre']), 'UTF-8');
            $producto->Precio_Compra_P      = $datos['Compra'];
            $producto->Stock_Minimo         = $datos['Minimo'];
            $producto->Ingreso_Producto     = $datos['Ingreso'];
            $producto->Codigo_Producto      = mb_strtoupper(trim($datos['Codigo']), 'UTF-8');
            $producto->ID_Categoria         = $datos['Categoria'];
            $producto->Descripcion_Producto = mb_strtoupper(trim($datos['Descripcion']), 'UTF-8');
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
            $producto->Stock                = trim($datos['Ingreso']);
            $producto->Nombre_Producto      = mb_strtoupper(trim($datos['Nombre']), 'UTF-8');
            $producto->Precio_Compra_P      = trim($datos['Compra']);
            $producto->Stock_Minimo         = trim($datos['Minimo']);
            $producto->Ingreso_Producto     = trim($datos['Ingreso']);
            $producto->Codigo_Producto      = mb_strtoupper(trim($datos['Codigo']), 'UTF-8');
            $producto->ID_Categoria         = trim($datos['Categoria']);
            $producto->Descripcion_Producto = mb_strtoupper(trim($datos['Descripcion']), 'UTF-8');
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
