<?php

namespace App\Http\Controllers;

use App\Models\Login;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function username() {
        return 'Usuario';
    }

    public function __construnct(){
        $this->middleware('jwt.verify', ['except' => ['authenticate']]);
    }

    public function authenticate(Request $request){
        
        $this->validate($request,[
            'Usuario'  => 'required',
            'password' => 'required',
        ]);

        $credential = $request->only('Usuario', 'password');

        try{
            //if(!$token = JWTAuth::attempt($credential)){
            if(!$token = auth()->attempt($credential)){
                return response(null, 401);
            }else{
                if($this->verificar()){
                    return \response()->json([
                        'status'    => true,
                        'token'     => \compact('token'),
                        'data'      => JWTAuth::user(),
                        'message'   => 'Credenciales válidos'
                    ]);
                }else{
                    return response(null, 403);
                }
            }
        }catch(\Tymon\JWTAuth\Exceptions\JWTException $e){
            return $e->getMessage();
        }
    }

    public function verificar(){
        $login = Login::select('Estado_Empleado')
            ->join('empleado', 'login.ID_Empleado', '=', 'empleado.ID_Empleado')
            ->where('empleado.ID_Empleado', '=', JWTAuth::user()->ID_Empleado)
            ->where('empleado.Estado_Empleado', '=', 1)
            ->where('login.ID_Login', '=', JWTAuth::user()->ID_Login)
            ->get();

        $sw = count($login) == 1 ? true  : false;
        return $sw;
    }

    public function logout(){
        Auth::logout();
        return \response()->json([
            'status' => true,
            'message' => 'Successfully logged out'
        ]);
    }
}
