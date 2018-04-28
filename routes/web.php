<?php

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

Route::get('/home', function () {

    if (Auth::check ())
    {
        return redirect ('expedientes');
    }
    else
    {
        return redirect ('login');
    }



});

Route::get('/', function () {
    return redirect()->back();
});


/*Rutas de administración*/
/*
Auth::routes();
Route::resource ('roles', 'RoleController');
Route::resource('users', 'UserController');
Route::resource ('gerencias', 'GerenciaController');
Route::resource ('departamentos', 'DepartamentoController');
Route::resource ('funcionarios', 'FuncionarioController');
Route::resource ('tipoexpedientes', 'TipoexpedienteController')->middleware ('auth');
Route::resource ('expedientes', 'ExpedienteController');
*/

/*DB::listen(function ($query)
{
    echo "<pre>{$query->sql}</pre>";
});
*/
Auth::routes();


Route::group (['middleware'=>'auth'], function (){
    Route::resource ('roles', 'RoleController');
    Route::resource('users', 'UserController');
    Route::resource ('gerencias', 'GerenciaController');
    Route::resource ('departamentos', 'DepartamentoController');
    Route::resource ('funcionarios', 'FuncionarioController');
    Route::resource ('tipoexpedientes', 'TipoexpedienteController');
    Route::resource ('expedientes', 'ExpedienteController');
    Route::resource ('aprobacion_expedientes/expedientes_pendientes', 'HistoryController');
    Route::resource ('expedientes_rechazados/expedientes_rechazados_creador', 'RechazadosController');
    Route::resource ('proveedores', 'ProveedorController');
    Route::resource ('ots', 'OtController');
    Route::resource ('expedientes_por_areas', 'VistaporareaController');
});
