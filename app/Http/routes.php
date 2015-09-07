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


Route::get('/login', function(){return view('auth/login');});


Route::get('/PromoVotacao', 'PromocoesController@paginaVotacao');
Route::post('/adm/promocoes/votacao/addVotoCliente', 'PromocoesController@addVotoCliente');
Route::post('/adm/promocoes/addVotoCadastro', 'PromocoesController@addVotoCadastro');
Route::get('admin/promocoes', 'PromocoesController@indexPromocoes');
Route::post('admin/promocoes/sorteioVotacao', 'PromocoesController@sorteioVotacao');
Route::post('admin/promocoes/salvaSorteado', 'PromocoesController@salvaSorteado');


Route::get('/admin', 'ProdutosController@indexPrato');
Route::get('/admin/produtos/addPrato', 'ProdutosController@indexPrato');
Route::get('/admin/produtos/pratos/edita/{id}', 'ProdutosController@editaPrato');
Route::post('/admin/produtos/pratos/edita/{id}', 'ProdutosController@updatePrato');
Route::get('/admin/produtos/pratos/ativar/{id}', 'ProdutosController@ativarPrato');
Route::get('/admin/produtos/pratos/desativar/{id}', 'ProdutosController@desativarPrato');

Route::post('/admin/produtos/salvaPratos', 'ProdutosController@salvaPrato');

Route::get('/admin/produtos/pratosSemana', 'ProdutosController@semanaIndex');
Route::post('/admin/produtos/salvaPratoSemana', 'ProdutosController@salvaPratoSemana');
Route::get('/admin/produtos/excluiPratoSemana/{id}', 'ProdutosController@excluiPratoSemana');
Route::post('/admin/produtos/addPratoSemana/{id}', 'ProdutosController@addPratoSemana');

Route::get('/admin/clientes/lista', 'ClienteController@lista');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/teste', function () {
    return view('emails/marketing/pratoDoDia');
});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('/auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@novoUser');
Route::post('auth/register', 'Auth\AuthController@salvaUsuario');

Route::get('auth/password', 'Auth\PasswordController@formSenha');
Route::post('password/email', 'Auth\PasswordController@resetPass');

