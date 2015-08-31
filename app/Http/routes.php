<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/admin', function(){
	return view('layout/admin');
});

Route::get('/login', function(){
	return view('auth/login');
});


Route::get('/PromoVotacao', 'PromocoesController@paginaVotacao');
Route::post('/adm/promocoes/votacao/addVotoCliente', 'PromocoesController@addVotoCliente');
Route::post('/adm/promocoes/addVotoCadastro', 'PromocoesController@addVotoCadastro');
Route::get('admin/promocoes', 'PromocoesController@indexPromocoes');
Route::post('admin/promocoes/sorteioVotacao', 'PromocoesController@sorteioVotacao');
Route::post('admin/promocoes/salvaSorteado', 'PromocoesController@salvaSorteado');


Route::get('/adm/produtos/pratos', 'ProdutosController@formPrato');
Route::get('/adm', 'ProdutosController@formPrato');
Route::post('/adm/produtos/salvaPratos', 'ProdutosController@salvaPrato');

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@novoUser');
Route::post('auth/register', 'Auth\AuthController@salvaUsuario');

Route::get('auth/password', 'Auth\PasswordController@formSenha');
Route::post('password/email', 'Auth\PasswordController@resetPass');

