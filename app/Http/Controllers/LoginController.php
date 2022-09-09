<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Login;

class LoginController extends Controller
{
    public function guardarLogin(Request $request){
        $login = new Login;
        $login = $login->get();
        return $login;
    }
}
