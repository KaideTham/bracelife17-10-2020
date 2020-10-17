<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
	public function homeadmin(){
		
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}
		
		return view('admin/homeadmin');
	} 

	public function cerrarsesion(){
        
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

	public function ajustes(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		return view('admin/ajustes');
	}

//CONTROLADORES PARA USUARIOS

	public function usuarios(){

		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$personas = DB::SELECT('SELECT P.rut, P.nombre, P.seg_nombre, P.apellido_paterno, P.apellido_materno, P.fecha_nacimiento, P.domicilio, P.ocupacion, P.telefono, C.nombre_comuna, E.desc_estadocivil, N.desc_nacionalidad, A.desc_niveleducacional, T.desc_tipoperfil, S.desc_sexo FROM bracelife.usuario P INNER JOIN comuna C ON C.idcomuna = P.comuna INNER JOIN estado_civil E ON E.idestado_civil = P.estado_civil INNER JOIN nacionalidad N ON N.idnacionalidad = P.nacionalidad INNER JOIN nivel_educacional A ON A.idnivel_educacional = P.nivel_educacional INNER JOIN tipo_perfil T ON T.idtipo_perfil = P.tipo_perfil	INNER JOIN sexo S ON S.idsexo = P.sexo_persona WHERE tipo_perfil = 5 OR tipo_perfil = 4 ORDER BY P.tipo_perfil, P.apellido_paterno');
		$comunas = DB::SELECT('SELECT * FROM comuna');
		$estado_civil = DB::SELECT('SELECT * FROM estado_civil');
		$nacionalidad = DB::SELECT('SELECT * FROM nacionalidad');
		$tipo_perfil = DB::SELECT('SELECT * FROM tipo_perfil WHERE idtipo_perfil = 4 OR idtipo_perfil = 5');
		$nivel_educacional = DB::SELECT('SELECT * FROM nivel_educacional');
		$brazalete = DB::SELECT('SELECT B.*, E.desc_estado FROM brazalete B INNER JOIN estado_brazalete E ON E.idestado_brazalete = B.estado_brazalete WHERE B.estado_brazalete <> 2');
		$sexo = DB::SELECT('SELECT * FROM sexo');
		return view('admin/usuarios', compact('personas','comunas','estado_civil','nacionalidad','tipo_perfil','nivel_educacional','sexo','brazalete'));
	}


	public function save_user(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$data = request()->all();

		$rut = $data['rut'];
		$nombre = $data['nombre'];
		$seg_nombre = $data['seg_nombre'];
		$apellido_paterno = $data['apellido_paterno'];
		$apellido_materno = $data['apellido_materno'];
		$fecha_nacimiento = $data['fecha_nacimiento'];
		$sexo_persona = $data['sexo_persona'];
		$domicilio = $data['domicilio'];
		$estado_civil = $data['estado_civil'];
		$nacionalidad = $data['nacionalidad'];
		$nivel_educacional = $data['nivel_educacional'];
		$ocupacion = $data['ocupacion'];
		$comuna = $data['comuna'];
		$tipo_perfil = $data['tipo_perfil'];
		$telefono = $data['telefono'];
		$alias = "".substr($nombre, 0, 3).substr($rut, 0, 3);

		$busqueda = DB::SELECT('SELECT rut FROM usuario WHERE rut = ?',[$rut]);
		if (!empty($busqueda)) {
			Session::flash('error', "Este usuario ya está registrado.");
            return back();
		}

		$insert = DB::INSERT('INSERT INTO usuario (rut, nombre, seg_nombre, apellido_paterno, apellido_materno, fecha_nacimiento, sexo_persona, domicilio, estado_civil, nacionalidad, nivel_educacional, ocupacion, comuna, tipo_perfil, telefono, activo, alias) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$rut,$nombre,$seg_nombre,$apellido_paterno,$apellido_materno,$fecha_nacimiento,$sexo_persona,$domicilio,$estado_civil,$nacionalidad,$nivel_educacional,$ocupacion,$comuna,$tipo_perfil,$telefono,0,$alias]);

		if ($insert) {
			Session::flash('success', "El registro se ha realizado exitosamente.");
            return back();
		} else {
			Session::flash('error', "No se ha podido guardar el nuevo usuario. Intente otra vez.");
            return back();

		}
	}

	public function delete_usuario($rut){

		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$accion = DB::table('usuario')->where('rut', '=', $rut)->delete();
        if ($accion) {
            Session::flash('success', "El usuario se ha eliminado correctamente");
            return back();
        } else {
            Session::flash('error', "No se pudo eliminar el usuario");
            return back();
        }
	}

	public function modificar_usuario(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$data = request()->all();
		$rut = $data['rut'];
		$persona = DB::SELECT("SELECT P.rut, P.nombre, P.seg_nombre, P.apellido_paterno, P.apellido_materno, P.fecha_nacimiento, P.domicilio, P.ocupacion, P.telefono, P.comuna, P.tipo_perfil, P.nacionalidad, P.nivel_educacional, P.estado_civil, P.sexo_persona, C.nombre_comuna, E.desc_estadocivil, N.desc_nacionalidad, A.desc_niveleducacional, T.desc_tipoperfil, S.desc_sexo FROM bracelife.usuario P INNER JOIN comuna C ON C.idcomuna = P.comuna INNER JOIN estado_civil E ON E.idestado_civil = P.estado_civil INNER JOIN nacionalidad N ON N.idnacionalidad = P.nacionalidad INNER JOIN nivel_educacional A ON A.idnivel_educacional = P.nivel_educacional INNER JOIN tipo_perfil T ON T.idtipo_perfil = P.tipo_perfil INNER JOIN sexo S ON S.idsexo = P.sexo_persona WHERE P.rut = '$rut'");

		$comunas = DB::SELECT('SELECT * FROM comuna');
		$estado_civil = DB::SELECT('SELECT * FROM estado_civil');
		$nacionalidad = DB::SELECT('SELECT * FROM nacionalidad');
		$tipo_perfil = DB::SELECT('SELECT * FROM tipo_perfil WHERE idtipo_perfil = 4 OR idtipo_perfil = 5');
		$nivel_educacional = DB::SELECT('SELECT * FROM nivel_educacional');
		$sexo = DB::SELECT('SELECT * FROM sexo');
		return view('admin/modificarusuario', compact('persona','comunas','estado_civil','nacionalidad','tipo_perfil','nivel_educacional','sexo'));
	}

	public function update_usuario(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$data = request()->all();
		$rut = $data['rut'];
		$nombre = $data['nombre'];
		$seg_nombre = $data['seg_nombre'];
		$apellido_paterno = $data['apellido_paterno'];
		$apellido_materno = $data['apellido_materno'];
		$fecha_nacimiento = $data['fecha_nacimiento'];
		$sexo_persona = $data['sexo_persona'];
		$domicilio = $data['domicilio'];
		$estado_civil = $data['estado_civil'];
		$nacionalidad = $data['nacionalidad'];
		$nivel_educacional = $data['nivel_educacional'];
		$ocupacion = $data['ocupacion'];
		$comuna = $data['comuna'];
		$tipo_perfil = $data['tipo_perfil'];
		$telefono = $data['telefono'];

		$verifica = DB::SELECT('SELECT brazalete FROM usuario WHERE rut = ?',[$rut]);
		/*
		foreach ($verifica as $verifica) {
			$brazaleteactual = $verifica->brazalete;
			if ($brazaleteactual == $brazalete) {
				# code...
			} else {
				$actualizar = DB::INSERT('UPDATE brazalete SET estado_brazalete = 6 WHERE idbrazalete = ?',[$brazaleteactual]);
				$asignar = DB::INSERT('UPDATE persona SET brazalete = ? WHERE rut = ?',[$brazalete,$rut]);
				$modificar = DB::INSERT('UPDATE brazalete SET estado_brazalete = 2 WHERE idbrazalete = ?',[$brazalete]);
			}
		} */

		$update = DB::INSERT('UPDATE usuario SET nombre = ?, seg_nombre = ?, apellido_paterno = ?, apellido_materno = ?, fecha_nacimiento = ?, sexo_persona = ?, domicilio = ?, estado_civil = ?, nacionalidad = ?, nivel_educacional = ?, ocupacion = ?, comuna = ?, tipo_perfil = ?, telefono = ? WHERE rut = ?',[$nombre,$seg_nombre,$apellido_paterno,$apellido_materno,$fecha_nacimiento,$sexo_persona,$domicilio,$estado_civil,$nacionalidad,$nivel_educacional,$ocupacion,$comuna,$tipo_perfil,$telefono,$rut]);

		if ($update) {
			Session::flash('success', "El usuario se ha actualizado exitosamente.");
			$personas = DB::SELECT('SELECT P.rut, P.nombre, P.seg_nombre, P.apellido_paterno, P.apellido_materno, P.fecha_nacimiento, P.domicilio, P.ocupacion, P.brazalete, P.telefono, P.comuna, P.tipo_perfil, P.nacionalidad, P.estado_civil, P.nivel_educacional, P.sexo_persona, C.nombre_comuna, E.desc_estadocivil, N.desc_nacionalidad, A.desc_niveleducacional, T.desc_tipoperfil, S.desc_sexo, B.estado_brazalete FROM bracelife.persona P INNER JOIN comuna C ON C.idcomuna = P.comuna INNER JOIN estado_civil E ON E.idestado_civil = P.estado_civil INNER JOIN nacionalidad N ON N.idnacionalidad = P.nacionalidad INNER JOIN nivel_educacional A ON A.idnivel_educacional = P.nivel_educacional INNER JOIN tipo_perfil T ON T.idtipo_perfil = P.tipo_perfil	INNER JOIN sexo S ON S.idsexo = P.sexo_persona INNER JOIN brazalete B ON B.idbrazalete = P.brazalete WHERE tipo_perfil = 5 OR tipo_perfil = 4');
			$comunas = DB::SELECT('SELECT * FROM comuna');
			$estado_civil = DB::SELECT('SELECT * FROM estado_civil');
			$nacionalidad = DB::SELECT('SELECT * FROM nacionalidad');
			$tipo_perfil = DB::SELECT('SELECT * FROM tipo_perfil WHERE idtipo_perfil = 4 OR idtipo_perfil = 5');
			$nivel_educacional = DB::SELECT('SELECT * FROM nivel_educacional');
			$sexo = DB::SELECT('SELECT * FROM sexo');
			return view('admin/usuarios', compact('personas','comunas','estado_civil','nacionalidad','tipo_perfil','nivel_educacional','sexo'));
		} else {
			Session::flash('error', "No se ha podido acutalizar el usuario. Intente otra vez.");
			$personas = DB::SELECT('SELECT P.rut, P.nombre, P.seg_nombre, P.apellido_paterno, P.apellido_materno, P.fecha_nacimiento, P.domicilio, P.ocupacion, P.brazalete, P.telefono, P.comuna, P.tipo_perfil, P.nacionalidad, P.estado_civil, P.nivel_educacional, P.sexo_persona, C.nombre_comuna, E.desc_estadocivil, N.desc_nacionalidad, A.desc_niveleducacional, T.desc_tipoperfil, S.desc_sexo, B.estado_brazalete FROM bracelife.persona P INNER JOIN comuna C ON C.idcomuna = P.comuna INNER JOIN estado_civil E ON E.idestado_civil = P.estado_civil INNER JOIN nacionalidad N ON N.idnacionalidad = P.nacionalidad INNER JOIN nivel_educacional A ON A.idnivel_educacional = P.nivel_educacional INNER JOIN tipo_perfil T ON T.idtipo_perfil = P.tipo_perfil	INNER JOIN sexo S ON S.idsexo = P.sexo_persona INNER JOIN brazalete B ON B.idbrazalete = P.brazalete WHERE tipo_perfil = 5 OR tipo_perfil = 4');
			$comunas = DB::SELECT('SELECT * FROM comuna');
			$estado_civil = DB::SELECT('SELECT * FROM estado_civil');
			$nacionalidad = DB::SELECT('SELECT * FROM nacionalidad');
			$tipo_perfil = DB::SELECT('SELECT * FROM tipo_perfil WHERE idtipo_perfil = 4 OR idtipo_perfil = 5');
			$nivel_educacional = DB::SELECT('SELECT * FROM nivel_educacional');
			$sexo = DB::SELECT('SELECT * FROM sexo');
			return view('admin/usuarios', compact('personas','comunas','estado_civil','nacionalidad','tipo_perfil','nivel_educacional','sexo'));

		}


	}

	//CONTROLADORES PARA BRAZALETES

	public function brazalete(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$brazaletes = DB::SELECT('SELECT B.*, E.desc_estado FROM brazalete B INNER JOIN estado_brazalete E ON E.idestado_brazalete = B.estado_brazalete');
		$estado_brazalete = DB::SELECT('SELECT * FROM estado_brazalete');
		$estados = DB::SELECT('SELECT * FROM estado_brazalete');
		return view('admin/brazaletes', compact('brazaletes','estado_brazalete','estados'));
	}

	public function add_brazalete(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$data = request()->all();

		$idbrazalete = $data['idbrazalete'];

		$busqueda = DB::SELECT('SELECT idbrazalete FROM brazalete WHERE idbrazalete = ?',[$idbrazalete]);
		if (!empty($busqueda)) {
			Session::flash('error', "Este dispositivo ya está registrado.");
            return back();
		} 

		$insert = DB::INSERT('INSERT INTO brazalete (idbrazalete, estado_brazalete) VALUES (?,?)',[$idbrazalete,1]);
		if ($insert) {
			Session::flash('success', "El registro el dispositivo se ha realizado exitosamente.");
		 	return back();
		} else {
			Session::flash('error', "No se ha podido registrar el dispositivo.");
			return back();
		}
		
	}

	public function delete_brazalete($id){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$busqueda = DB::SELECT('SELECT estado_brazalete FROM brazalete WHERE idbrazalete = ?',[$id]);
		foreach ($busqueda as $busqueda) {
			if ($busqueda->estado_brazalete == 2) {
				Session::flash('error', "El brazalete que intenta eliminar esta actualmente en uso.");
				 return back();
			} else {
				$accion = DB::table('brazalete')->where('idbrazalete', '=', $id)->delete();
				if ($accion) {
					Session::flash('success', "El dispositivo se ha eliminado correctamente");
					return back();
				} else {
					Session::flash('error', "No se pudo eliminar el dispositivo");
					return back();
				}
			}
		}
		
		
	}


	//CONTROLADORES PARA DESACATOS 
	public function desacatos(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$desacatos = DB::SELECT('SELECT * FROM desacato');
		return view('admin/desacatos',compact('desacatos'));
	}

	//CONTROLADORES PARA NACIONALIDADES

	public function nacionalidades(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$nacionalidades = DB::SELECT('SELECT * FROM nacionalidad');
		return view('admin/nacionalidades', compact('nacionalidades'));
	}

	public function add_nacionalidad(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$data = request()->all();

		$desc_nacionalidad = $data['desc_nacionalidad'];

		$busqueda = DB::SELECT('SELECT desc_nacionalidad FROM nacionalidad WHERE desc_nacionalidad = ?',[$desc_nacionalidad]);
		if (!empty($busqueda)) {
			Session::flash('error', "Esta nacionalidad ya está registrada.");
            return back();
		} 

		$insert = DB::INSERT('INSERT INTO nacionalidad (desc_nacionalidad) VALUES (?)',[$desc_nacionalidad]);
		if ($insert) {
			Session::flash('success', "El registro de la nacionalidad se ha realizado exitosamente.");
		 	return back();
		} else {
			Session::flash('error', "No se ha podido registrar la nacionalidad.");
			return back();
		}
		
	}

	public function delete_nacionalidad($id){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$accion = DB::table('nacionalidad')->where('idnacionalidad', '=', $id)->delete();
        if ($accion) {
            Session::flash('success', "La nacionalidad se ha eliminado correctamente");
            return back();
        } else {
            Session::flash('error', "No se pudo eliminar la nacionalidad");
            return back();
        }
	}

	public function modificar_nacionalidad(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$data = request()->all();
		$idnacionalidad = $data['idnacionalidad'];
		$desc_nacionalidad = $data['desc_nacionalidad'];

		$accion = DB::INSERT('UPDATE nacionalidad SET desc_nacionalidad = ? WHERE idnacionalidad = ?',[$desc_nacionalidad,$idnacionalidad]);

		if ($accion) {
            Session::flash('success', "La nacionalidad se ha modificado correctamente");
            return back();
        } else {
            Session::flash('error', "No se pudo modificar la nacionalidad");
            return back();
        }
	}

	//CONTROLADORES PARA REGIONES

	public function regiones(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$regiones = DB::SELECT('SELECT * FROM region');
		return view('admin/regiones', compact('regiones'));
	}

	public function add_region(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$data = request()->all();

		$nombre_region = $data['nombre_region'];

		$busqueda = DB::SELECT('SELECT nombre_region FROM region WHERE nombre_region = ?',[$nombre_region]);
		if (!empty($busqueda)) {
			Session::flash('error', "Esta región ya está registrada.");
            return back();
		} 

		$insert = DB::INSERT('INSERT INTO region (nombre_region) VALUES (?)',[$nombre_region]);
		if ($insert) {
			Session::flash('success', "El registro de la región se ha realizado exitosamente.");
		 	return back();
		} else {
			Session::flash('error', "No se ha podido registrar la región.");
			return back();
		}
		
	}

	public function delete_region($id){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$accion = DB::table('region')->where('idregion', '=', $id)->delete();
        if ($accion) {
            Session::flash('success', "La región se ha eliminado correctamente");
            return back();
        } else {
            Session::flash('error', "No se pudo eliminar la región");
            return back();
        }
	}

	public function modificar_region(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$data = request()->all();
		$idregion = $data['idregion'];
		$nombre_region = $data['nombre_region'];

		$accion = DB::INSERT('UPDATE region SET nombre_region = ? WHERE idregion = ?',[$nombre_region,$idregion]);

		if ($accion) {
            Session::flash('success', "La región se ha modificado correctamente");
            return back();
        } else {
            Session::flash('error', "No se pudo modificar la región");
            return back();
        }
	}

	//CONTROLADORES PARA PROVINCIAS

	public function provincias(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$provincias = DB::SELECT('SELECT P.*, R.nombre_region FROM provincia P INNER JOIN region R ON P.provincia_region = R.idregion');
		$regiones = DB::SELECT('SELECT * FROM region');
		return view('admin/provincias', compact('provincias', 'regiones'));
	}

	public function add_provincia(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$data = request()->all();

		$nombre_provincia = $data['nombre_provincia'];
		$provincia_region = $data['provincia_region'];

		$busqueda = DB::SELECT('SELECT nombre_provincia FROM provincia WHERE nombre_provincia = ?',[$nombre_provincia]);
		if (!empty($busqueda)) {
			Session::flash('error', "Esta provincia ya está registrada.");
            return back();
		} 

		$insert = DB::INSERT('INSERT INTO provincia (nombre_provincia,provincia_region) VALUES (?,?)',[$nombre_provincia,$provincia_region]);
		if ($insert) {
			Session::flash('success', "El registro de la provincia se ha realizado exitosamente.");
		 	return back();
		} else {
			Session::flash('error', "No se ha podido registrar la provincia.");
			return back();
		}
		
	}

	public function delete_provincia($id){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$accion = DB::table('provincia')->where('idprovincia', '=', $id)->delete();
        if ($accion) {
            Session::flash('success', "La provincia se ha eliminado correctamente");
            return back();
        } else {
            Session::flash('error', "No se pudo eliminar la provincia");
            return back();
        }
	}

	public function modificar_provincia(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$data = request()->all();
		$idprovincia = $data['idprovincia'];
		$nombre_provincia = $data['nombre_provincia'];

		$accion = DB::INSERT('UPDATE provincia SET nombre_provincia = ? WHERE idprovincia = ?',[$nombre_provincia,$idprovincia]);

		if ($accion) {
            Session::flash('success', "La provincia se ha modificado correctamente");
            return back();
        } else {
            Session::flash('error', "No se pudo modificar la provincia");
            return back();
        }
	}

	//CONTROLADORES PARA COMUNAS

	public function comunas(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$comunas = DB::SELECT('SELECT C.*, P.nombre_provincia FROM comuna C INNER JOIN provincia P ON C.comuna_prov = P.idprovincia');
		$provincias = DB::SELECT('SELECT * FROM provincia');
		return view('admin/comunas', compact('comunas', 'provincias'));
	}

	public function add_comuna(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$data = request()->all();

		$nombre_comuna = $data['nombre_comuna'];
		$comuna_prov = $data['comuna_prov'];

		$busqueda = DB::SELECT('SELECT nombre_comuna FROM comuna WHERE nombre_comuna = ?',[$nombre_comuna]);
		if (!empty($busqueda)) {
			Session::flash('error', "Esta comuna ya está registrada.");
            return back();
		} 

		$insert = DB::INSERT('INSERT INTO comuna (nombre_comuna,comuna_prov) VALUES (?,?)',[$nombre_comuna,$comuna_prov]);
		if ($insert) {
			Session::flash('success', "El registro de la comuna se ha realizado exitosamente.");
		 	return back();
		} else {
			Session::flash('error', "No se ha podido registrar la comuna.");
			return back();
		}
		
	}

	public function delete_comuna($id){

		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$accion = DB::table('comuna')->where('idcomuna', '=', $id)->delete();
        if ($accion) {
            Session::flash('success', "La comuna se ha eliminado correctamente");
            return back();
        } else {
            Session::flash('error', "No se pudo eliminar la comuna");
            return back();
        }
	}

	public function modificar_comuna(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$data = request()->all();
		$idcomuna = $data['idcomuna'];
		$nombre_comuna = $data['nombre_comuna'];

		$accion = DB::INSERT('UPDATE comuna SET nombre_comuna = ? WHERE idcomuna = ?',[$nombre_comuna,$idcomuna]);

		if ($accion) {
            Session::flash('success', "La comuna se ha modificado correctamente");
            return back();
        } else {
            Session::flash('error', "No se pudo modificar la comuna");
            return back();
        }
	}

//GESTOR DE ORDENES

	public function ordenes(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$ordenes = DB::SELECT('SELECT * FROM orden_alejamiento');
		$victimas = DB::SELECT('SELECT P.*, C.nombre_comuna FROM usuario P INNER JOIN comuna C ON C.idcomuna = P.comuna WHERE tipo_perfil = 4 AND activo = 0');
		$victimarios = DB::SELECT('SELECT P.*, C.nombre_comuna FROM usuario P INNER JOIN comuna C ON C.idcomuna = P.comuna WHERE tipo_perfil = 5 AND activo = 0');
		$brazaletesdisp1 = DB::SELECT('SELECT * FROM brazalete WHERE estado_brazalete = 1');
		$brazaletesdisp2 = DB::SELECT('SELECT * FROM brazalete WHERE estado_brazalete = 1');
		return view('admin/ordenes', compact('ordenes','victimas','victimarios','brazaletesdisp1','brazaletesdisp2'));
	}

	public function add_orden(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$data = request()->all();
		$idorden = $data['idorden'];
		$distancia = $data['distancia'];
		$fechainicio = $data['fechainicio'];
		$fechatermino = $data['fechatermino'];
		$rutvictima = $data['rutvictima'];
		$brazaletevictima = $data['brazaletevictima'];
		$rutvictimario = $data['rutvictimario'];
		$brazaletevictimario = $data['brazaletevictimario'];

		if ($brazaletevictima == $brazaletevictimario) {
			Session::flash('error', "No se puede enlazar un solo brazalete, deben ser distintos.");
			return back();
		} 

		$insert = DB::INSERT('INSERT INTO orden_alejamiento (idorden, distancia, fechainicio, fechatermino, rutvictima, rutvictimario, brazaletevictima, brazaletevictimario) 
		VALUES (?,?,?,?,?,?,?,?)',[$idorden,$distancia,$fechainicio,$fechatermino,$rutvictima,$rutvictimario,$brazaletevictima,$brazaletevictimario]);
		if ($insert) {
			DB::INSERT('UPDATE usuario SET activo = 1 WHERE rut = ?',[$rutvictima]);
			DB::INSERT('UPDATE usuario SET activo = 1 WHERE rut = ?',[$rutvictimario]);
			DB::INSERT('UPDATE brazalete SET estado_brazalete = 2 WHERE idbrazalete = ?',[$brazaletevictima]);
			DB::INSERT('UPDATE brazalete SET estado_brazalete = 2 WHERE idbrazalete = ?',[$brazaletevictimario]);
			Session::flash('success', "El enlace se ha realizado exitosamente.");
		 	return back();
		} else {
			Session::flash('error', "No se ha podido enlazar.");
			return back();
		}
		
	}

	public function delete_orden($id){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$busqueda = DB::SELECT('SELECT * from orden_alejamiento WHERE idorden = ?',[$id]);

		foreach ($busqueda as $busqueda) {
			$brazaletevictima = $busqueda->brazaletevictima;
			$brazaletevictimario = $busqueda->brazaletevictimario;
			$rutvictima = $busqueda->rutvictima;
			$rutvictimario = $busqueda->rutvictimario;
		}

		$accion = DB::table('orden_alejamiento')->where('idorden', '=', $id)->delete();
        if ($accion) {
        	DB::INSERT('UPDATE brazalete SET estado_brazalete = 1 WHERE idbrazalete = ?',[$brazaletevictima]);
			DB::INSERT('UPDATE brazalete SET estado_brazalete = 1 WHERE idbrazalete = ?',[$brazaletevictimario]);
			DB::INSERT('UPDATE usuario SET activo = 0 WHERE rut = ?',[$rutvictima]);
			DB::INSERT('UPDATE usuario SET activo = 0 WHERE rut = ?',[$rutvictimario]);
            Session::flash('success', "El enlace se ha eliminado correctamente");
            return back();
        } else {
            Session::flash('error', "No se pudo eliminar el enlace");
            return back();
        }
	}


//CONTROLADORES PARA ESTADOS DE  BRAZALETES

	public function estadobrazalete(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$estadobrazalete = DB::SELECT('SELECT * FROM estado_brazalete');
		return view('admin/estadobrazalete', compact('estadobrazalete'));
	}

	public function add_estadobrazalete(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$data = request()->all();

		$desc_estado = $data['desc_estado'];

		$busqueda = DB::SELECT('SELECT desc_estado FROM estado_brazalete WHERE desc_estado = ?',[$desc_estado]);
		if (!empty($busqueda)) {
			Session::flash('error', "Esta descripción de estado ya está registrado.");
            return back();
		} 

		$insert = DB::INSERT('INSERT INTO estado_brazalete (desc_estado) VALUES (?)',[$desc_estado]);
		if ($insert) {
			Session::flash('success', "El registro del estado del brazalete se ha realizado exitosamente.");
		 	return back();
		} else {
			Session::flash('error', "No se ha podido registrar este estado.");
			return back();
		}
		
	}

	public function delete_estadobrazalete($id){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}


		$accion = DB::table('estado_brazalete')->where('idestado_brazalete', '=', $id)->delete();
        if ($accion) {
            Session::flash('success', "El estado del brazalete se ha eliminado correctamente");
            return back();
        } else {
            Session::flash('error', "No se pudo eliminar el estado");
            return back();
        }
	}

	public function modificar_estadobrazalete(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}
		$data = request()->all();
		$idestado_brazalete = $data['idestado_brazalete'];
		$desc_estado = $data['desc_estado'];

		$accion = DB::INSERT('UPDATE estado_brazalete SET desc_estado = ? WHERE idestado_brazalete = ?',[$desc_estado,$idestado_brazalete]);

		if ($accion) {
            Session::flash('success', "El estado del brazalete se ha modificado correctamente");
            return back();
        } else {
            Session::flash('error', "No se pudo modificar el estado");
            return back();
        }
	}

	//CONTROLADORES PARA NIVEL EDUCACIONAL

	public function niveleducacional(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}
		$niveleducacional = DB::SELECT('SELECT * FROM nivel_educacional');
		return view('admin/niveleducacional', compact('niveleducacional'));
	}

	public function add_niveleducacional(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}
		$data = request()->all();

		$desc_niveleducacional = $data['desc_niveleducacional'];

		$busqueda = DB::SELECT('SELECT desc_niveleducacional FROM nivel_educacional WHERE desc_niveleducacional = ?',[$desc_niveleducacional]);
		if (!empty($busqueda)) {
			Session::flash('error', "Esta descripción de nivel educacional ya está registrada.");
            return back();
		} 

		$insert = DB::INSERT('INSERT INTO nivel_educacional (desc_niveleducacional) VALUES (?)',[$desc_niveleducacional]);
		if ($insert) {
			Session::flash('success', "El registro del estado del nivel educacional se ha realizado exitosamente.");
		 	return back();
		} else {
			Session::flash('error', "No se ha podido registrar este nivel educacional.");
			return back();
		}
		
	}

	public function delete_niveleducacional($id){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}

		$accion = DB::table('nivel_educacional')->where('idnivel_educacional', '=', $id)->delete();
        if ($accion) {
            Session::flash('success', "El estado del nivel educacional se ha eliminado correctamente");
            return back();
        } else {
            Session::flash('error', "No se pudo eliminar el estado");
            return back();
        }
	}

	public function modificar_niveleducacional(){
		session_start();
		if (empty($_SESSION)){
			return redirect('/');
		}
        if ($_SESSION["tipo_perfil"] <> 1) {
            return redirect('/');
		}
		$data = request()->all();
		$idnivel_educacional = $data['idnivel_educacional'];
		$desc_niveleducacional = $data['desc_niveleducacional'];

		$accion = DB::INSERT('UPDATE nivel_educacional SET desc_niveleducacional = ? WHERE idnivel_educacional = ?',[$desc_niveleducacional,$idnivel_educacional]);

		if ($accion) {
            Session::flash('success', "El estado del nivel educacional se ha modificado correctamente");
            return back();
        } else {
            Session::flash('error', "No se pudo modificar el estado");
            return back();
        }
	}


}

