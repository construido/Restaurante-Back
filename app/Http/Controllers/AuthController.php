<?php

namespace App\Http\Controllers;

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
            'Usuario'    => 'required',
            'password' => 'required',
        ]);

        $credential = $request->only('Usuario', 'password');

        try{
            if(!$token = JWTAuth::attempt($credential)){
                return response(null, 401);
            }

            return \response()->json([
                'status'    => true,
                'token'     => \compact('token'),
                'data'      => JWTAuth::user(),
                'message'   => 'Credenciales válidos'
            ]);

        }catch(\Tymon\JWTAuth\Exceptions\JWTException $e){
            return $e->getMessage();
        }
    }

    public function logout(){
        Auth::logout();
        return \response()->json([
            'status' => true,
            'message' => 'Successfully logged out'
        ]);
    }
}
