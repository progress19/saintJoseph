<?php

use Illuminate\Support\Facades\Route;
//use WebhooksController;

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

Auth::routes();


Route::match(['get','post'],'testEmail','Controller@testEmail');

Route::post('webhooks', WebhooksController::class);

Route::post('webhooksCoinbase', WebhooksCoinbaseController::class);

Route::get('/test_coinbase', function () {
    return view('test_coinbase');
});

//Route::post('webhooks','WebhooksController@webhooks')->name('webhooks');

Route::get('/', ['uses' => 'Controller@viewHome']);
Route::get('home', ['uses' => 'Controller@viewHome'])->name('home');
//Route::get('/', ['uses' => 'Controller@viewOffline']);

/*
Route::post('checkout', [
  'uses' => 'Controller@viewCheckout',
  'as' => 'front.view.checkout']);
*/

Route::match(['get','post'],'checkout','Controller@viewCheckout');
Route::match(['get','post'],'gracias','Controller@gracias');

Route::post('enviarContacto', 'Controller@enviarContacto');
Route::post('enviarReserva', 'Controller@enviarReserva');
Route::post('enviarReservaCoinbase', 'Controller@enviarReservaCoinbase');

Route::match(['get','post'],'receive_ipn','Controller@receive_ipn')->name('receive_ipn');

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

Route::match(['get', 'post'], '/admin', 'AdminController@login');
Route::match(['get', 'post'], '/admin/login', 'AdminController@login');
Route::match(['get', 'post'], '/login', 'AdminController@login')->name('login');
  
Route::post('checkCarro', 'Controller@checkCarro');  
Route::post('checkCantidad', 'Controller@checkCantidad'); 
Route::post('getTotalConDescuento', 'Controller@getTotalConDescuento'); 
Route::post('addActividadCarro', 'Controller@addActividadCarro'); 
Route::post('borrarActividadAjax', 'Controller@borrarActividadAjax'); 
Route::post('cambiarCantidadAjax', 'Controller@cambiarCantidadAjax'); 
Route::post('checkDescuento', 'Controller@checkDescuento'); 

Route::post('getTurnosConCupo', 'Controller@getTurnosConCupo'); 
Route::post('getTurnosCollect', 'Controller@getTurnosCollect'); 
Route::post('getChargeUpdate', 'Controller@getChargeUpdate'); 

Route::post('searchCodeDisc', 'Controller@searchCodeDisc'); 
Route::post('checkDiscount', 'Controller@checkDiscount'); 

/* ADMIN */

Route::get('/logout', 'AdminController@logout');

Route::group(['middleware' => ['auth']], function() {

	Route::match(['get', 'post'], 'admin/checkFechaNueva', 'FechaController@checkFechaNueva'); //unique fecha nueva add / edit

	Route::get('/admin/dashboard', 'AdminController@dashboard');

	//Usuarios Routes (Admin)
	Route::match(['get','post'],'/admin/add-usuario','UsuarioController@addUsuario');
	Route::match(['get','post'],'/admin/edit-usuario/{id}','UsuarioController@editUsuario');
	Route::match(['get','post'],'/admin/delete-usuario/{id}','UsuarioController@deleteUsuario');
	Route::get('/admin/view-usuarios','UsuarioController@viewUsuarios');

	Route::get('/admin/reset-pwd','AdminController@resetPassword');

	//Actividades Routes (Admin)
	Route::match(['get','post'],'/admin/add-actividad','ActividadController@addActividad');
	Route::match(['get','post'],'/admin/edit-actividad/{id}','ActividadController@editActividad');
	Route::match(['get','post'],'/admin/delete-actividad/{id}','ActividadController@deleteActividad');
	Route::get('/admin/view-actividades','ActividadController@viewActividades');

	//Reservas Routes (Admin)
	Route::get('/admin/view-reservas','ReservaController@viewReservas');
	Route::match(['get','post'],'/admin/edit-reserva/{id}','ReservaController@editReserva');
	Route::match(['get','post'],'/admin/delete-reserva/{id}','ReservaController@deleteReserva');

	//Imagenes Home Routes (Admin)
    Route::match(['get','post'],'/admin/add-imgHome','ImgsHomeController@addImgHome');
    Route::match(['get','post'],'/admin/edit-imgHome/{id}','ImgsHomeController@editImgHome');
    Route::match(['get','post'],'/admin/delete-imgHome/{id}','ImgsHomeController@deleteImgHome');
    Route::get('/admin/view-imgsHome','ImgsHomeController@viewImgsHome');


	/* DATATABLES */
	Route::get('dataUsuarios', 'UsuarioController@getData')->name('dataUsuarios');
	Route::get('dataActividades', 'ActividadController@getData')->name('dataActividades');
	Route::get('dataReservas', 'ReservaController@getData')->name('dataReservas');
	Route::get('dataImagenesHome', 'ImgsHomeController@getData')->name('dataImagenesHome');

	//Config Routes (Admin)
	Route::match(['get','post'],'/admin/edit-config/{id}','ConfigController@editConfig');

	//exportar a excel reservas 
	Route::get('admin/exportarReservas', 'BackController@exportarReservas');

}) ;




