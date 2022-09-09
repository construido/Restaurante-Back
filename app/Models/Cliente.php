<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Exception;
use DB;

class Cliente extends Model
{
    use HasFactory;

    protected $table      = 'cliente';
    protected $primaryKey = 'ID_Cliente';
    protected $fillable   = ['Nombre_Razon_Social_Cliente', 'CI_NIT_Cliente', 'Telefono_Cliente', 'Correo_Cliente', 'Estado_Cliente'];
    public $timestamps = false;

    public function cantidadClientes(){
        try {
            DB::beginTransaction();
            $cliente = Cliente::select(DB::raw('COUNT(ID_Cliente) as Cliente'))
                ->where('Estado_Cliente', '=', 1)
                ->get();
            DB::commit();

            return $cliente;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function listarClientes($parametros){
        try {
            DB::beginTransaction();
            $cliente = Cliente::where('Nombre_Razon_Social_Cliente', 'like', '%'.$parametros->filters.'%')
            ->orderBy('ID_Cliente', 'DESC')
            ->paginate($parametros->rows);
            DB::commit();

            return $cliente;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function listarSelectCliente(){
        try {
            DB::beginTransaction();
            $cliente = Cliente::select('ID_Cliente', 'Nombre_Razon_Social_Cliente')
                ->where('Estado_Cliente', '=', 1)
                ->get();
            DB::commit();

            return $cliente;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function guardarCliente($datos){
        try {
            DB::beginTransaction();
            $cliente = new Cliente;
            $cliente->CI_NIT_Cliente              = trim($datos['CI_NIT']);
            $cliente->Correo_Cliente              = mb_strtoupper(trim($datos['Correo']), 'UTF-8');
            $cliente->Telefono_Cliente            = trim($datos['Telefono']);
            $cliente->Nombre_Razon_Social_Cliente = mb_strtoupper(trim($datos['Nombre']), 'UTF-8');
            $cliente->save();
            DB::commit();
            
            return $cliente;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function actualizarCliente($datos){
        try {
            DB::beginTransaction();
            $cliente = Cliente::findOrFail(trim($datos['ID']));
            $cliente->CI_NIT_Cliente              = trim($datos['CI_NIT']);
            $cliente->Correo_Cliente              = mb_strtoupper(trim($datos['Correo']), 'UTF-8');
            $cliente->Telefono_Cliente            = trim($datos['Telefono']);
            $cliente->Nombre_Razon_Social_Cliente = mb_strtoupper(trim($datos['Nombre']), 'UTF-8');
            $cliente->save();
            DB::commit();
            
            return $cliente;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function actualizarEstadoCliente($datos){
        try {
            DB::beginTransaction();
            $cliente = Cliente::findOrFail(trim($datos['ID']));
            $cliente->Estado_Cliente = trim($datos['Estado']);
            $cliente->save();
            DB::commit();
            
            return $cliente;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
