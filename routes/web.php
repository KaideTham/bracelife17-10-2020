<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//RUTAS PARA PAGINAS PUBLICAS
Route::get('/','IndexController@index')->name('index');
Route::post('/loging','IndexController@login')->name('login');
Route::post('/registro','IndexController@registropersonal')->name('registropersonal');

//RUTAS CLIENTES
Route::get('cliente/cerrarsesion','ClienteController@logoutcliente')->name('logoutcliente');


//RUTAS FUNCIONARIOS
Route::get('funcionario/cerrarsesion','FuncionarioController@logoutfuncionario')->name('logoutfuncionario');

//RUTAS PARA ADMIN
Route::get('homeadmin','AdminController@homeadmin')->name('homeadmin');
Route::get('admin/user','AdminController@user')->name('admin_users');
Route::get('admin/ajustes','AdminController@ajustes')->name('ajustesadmin');
Route::get('admin/cerrarsesion','AdminController@cerrarsesion')->name('cerrarsesion');



// RUTAS ordenes 
Route::get('ordenes','AdminController@ordenes')->name('ordenes');
Route::post('ordenes/add','AdminController@add_orden')->name('saveorden');
Route::get('ordenes/delete/{id}','AdminController@delete_orden');
Route::post('ordenes/modificar','AdminController@modificar_orden')->name('modificarorden');

//RUTAS DESACATOS
Route::get('desacatos','AdminController@desacatos')->name('desacatos');


// RUTAS USUARIOS
Route::get('usuarios','AdminController@usuarios')->name('usuarios');
Route::get('usuarios/delete/{rut}','AdminController@delete_usuario');
Route::post('usuarios/modificarusuario','AdminController@modificar_usuario')->name('modificarusuario');
Route::post('usuarios/modificarusuario/update','AdminController@update_usuario')->name('updateusuario');
Route::get('admin/addusuario','AdminController@add_user')->name('addusuarios');
Route::post('admin/addusuario/save','AdminController@save_user')->name('saveuser');

// RUTAS BRAZALETES
Route::get('brazaletes','AdminController@brazalete')->name('brazaletes');
Route::post('brazaletes/add','AdminController@add_brazalete')->name('savebrazalete');
Route::get('brazaletes/delete/{id}','AdminController@delete_brazalete');
Route::post('brazaletes/modificar','AdminController@modificar_brazalete')->name('modificarbrazalete');

// RUTAS NACIONALIDADES
Route::get('nacionalidades','AdminController@nacionalidades')->name('nacionalidades');
Route::get('nacionalidades/delete/{id}','AdminController@delete_nacionalidad');
Route::post('nacionalidades/modificar','AdminController@modificar_nacionalidad')->name('modificarnacionalidad');
Route::post('nacionalidad/add','AdminController@add_nacionalidad')->name('savenacionalidad');

// RUTAS NIVEL EDUCACIONAL
Route::get('niveleducacional','AdminController@niveleducacional')->name('niveleducacional');
Route::get('niveleducacional/delete/{id}','AdminController@delete_niveleducacional');
Route::post('niveleducacional/modificar','AdminController@modificar_niveleducacional')->name('modificarniveleducacional');
Route::post('niveleducacional/add','AdminController@add_niveleducacional')->name('saveniveleducacional');

// RUTAS ESTADO BRAZALETE
Route::get('estadobrazalete','AdminController@estadobrazalete')->name('estadobrazalete');
Route::get('estadobrazalete/delete/{id}','AdminController@delete_estadobrazalete');
Route::post('estadobrazalete/modificar','AdminController@modificar_estadobrazalete')->name('modificarestadobrazalete');
Route::post('estadobrazalete/add','AdminController@add_estadobrazalete')->name('saveestadobrazalete');

// RUTAS REGIONES, PROVINCIAS Y COMUNAS
// REGIONES
Route::get('regiones','AdminController@regiones')->name('regiones');
Route::post('region/add','AdminController@add_region')->name('saveregion');
Route::get('regiones/delete/{id}','AdminController@delete_region');
Route::post('regiones/modificar','AdminController@modificar_region')->name('modificarregion');

//PROVINCIAS
Route::get('provincias','AdminController@provincias')->name('provincias');
Route::post('provincia/add','AdminController@add_provincia')->name('saveprovincia');
Route::get('provincias/delete/{id}','AdminController@delete_provincia');
Route::post('provincias/modificar','AdminController@modificar_provincia')->name('modificarprovincia');

//COMUNAS
Route::get('comunas','AdminController@comunas')->name('comunas');
Route::post('comuna/add','AdminController@add_comuna')->name('savecomuna');
Route::get('comunas/delete/{id}','AdminController@delete_comuna');
Route::post('comunas/modificar','AdminController@modificar_comuna')->name('modificarcomuna');

//RUTAS PARA CLIENTE
Route::get('home','ClienteController@home')->name('home');

//RUTAS PARA FUNCIONARIOS
Route::get('principal','FuncionarioController@principal')->name('principal');