<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FuncionarioController extends Controller
{
	public function principal(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 2) {
            return redirect('/');
		}
		return view('funcionario/principal');
	} 

	public function logoutfuncionario(){
        
		session_start();
  
		$_SESSION = array();
		if (ini_get("session.use_cookies")) {
  
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
  
		}
		session_destroy();
		return redirect('/');
		
	}

}