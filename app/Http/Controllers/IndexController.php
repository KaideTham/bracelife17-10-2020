<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{
	public function index(){

		$institucion = DB::SELECT('SELECT * FROM institucion');
		$tipo_perfil = DB::SELECT('SELECT * FROM tipo_perfil WHERE idtipo_perfil < 4');
		return view('index/index',compact('institucion','tipo_perfil'));
	} 

	public function login(){
		$data = request()->all();
		$rut = $data['rut'];
        $password = $data['pass'];

		$count = DB::select("SELECT * FROM personal WHERE rutpersonal = '$rut'");       
        if(empty($count)){
			Session::flash('error', "El rut ingresado no tiene permisos para acceder a la plataforma");
            return redirect('/');    
		}
		
		if(!password_verify($password, $count[0]->password)) {
			Session::flash('error', "Los datos ingresados no coinciden.");
			
			return redirect('/');   
			} 
		
		
		session_start();
        $_SESSION["rut"] = $count[0]->rutpersonal;
		$_SESSION['tipo_perfil'] = $count[0]->tipo_perfil;
		
		if ($count[0]->tipo_perfil == 1) {
			return redirect('homeadmin');
		}
		if ($count[0]->tipo_perfil == 2) {
			return redirect('principal');
		}
		if ($count[0]->tipo_perfil == 3) {
			return redirect('home');
		}
		if ($count[0]->tipo_perfil > 3) {
			return redirect('/');
		}
        
        
	}
	
	public function registropersonal(){
		$data = request()->all();
		$rutpersonal = $data['rutpersonal'];
		$nombre = $data['nombre'];
		$apellido_paterno = $data['apellido_paterno'];
		$apellido_materno = $data['apellido_materno'];
		$mail = $data['mail'];
		$ocupacion = $data['ocupacion'];
		$institucion = $data['rutinstitucion'];
		$tipo_perfil = $data['tipo_perfil'];
		$password = bcrypt($rutpersonal);

		$query = DB::table('personal')->insert(
			['nombre' => $nombre, 'apellido_paterno' => $apellido_paterno,
			'apellido_materno' => $apellido_materno, 'mail' => $mail, 
			'ocupacion' => $ocupacion, 'institucion' => $institucion,
			'tipo_perfil' => $tipo_perfil, 'password' => $password,
			'rutpersonal' => $rutpersonal
			]
		);

		if ($query){
			Session::flash('success', 'Registro exitoso.');
			return redirect('/');
		} else {
			Session::flash('error', 'No se pudo registrar.');
			return redirect('/');
		}
	}

}