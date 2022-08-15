<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Exception;
use DB;

class Categoria extends Model
{
    use HasFactory;

    protected $table      = 'categoria';
    protected $primaryKey = 'ID_Categoria';
    protected $fillable   = [
        'Nombre_Categoria', 'Descripcion_Categoria','Estado_Categoria'
    ];

    public $timestamps = false;

    public function listarCategoriaSelect(){
        try {
            DB::beginTransaction();
            $categoria = Categoria::select('ID_Categoria', 'Nombre_Categoria')
                ->where('Estado_Categoria', '=', '1')->get();
            DB::commit();

            return $categoria;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function listarCategorias($parametros){
        try {
            DB::beginTransaction();
            $categoria = Categoria::where('Nombre_Categoria', 'like', '%'.$parametros->filters.'%')
                ->paginate($parametros->rows);
            DB::commit();

            return $categoria;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function guardarCategoria($datos){
        try {
            DB::beginTransaction();
            $categoria = new Categoria;
            $categoria->Nombre_Categoria      = trim($datos['Nombre']);
            $categoria->Descripcion_Categoria = trim($datos['Descripcion']);
            $categoria->save();
            DB::commit();
            
            return $categoria;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function actualizarCategoria($datos){
        try {
            DB::beginTransaction();
            $categoria = Categoria::findOrFail(trim($datos['ID']));
            $categoria->Nombre_Categoria      = trim($datos['Nombre']);
            $categoria->Descripcion_Categoria = trim($datos['Descripcion']);
            $categoria->save();
            DB::commit();
            
            return $categoria;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function actualizarEstadoCategoria($datos){
        try {
            DB::beginTransaction();
            $categoria = Categoria::findOrFail(trim($datos['ID']));
            $categoria->Estado_Categoria = trim($datos['Estado']);
            $categoria->save();
            DB::commit();
            
            return $categoria;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
