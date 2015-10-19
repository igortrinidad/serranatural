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

//Login
Route::get('/login', function(){return view('auth/login');});

//Promoções
Route::get('/PromoVotacao', 'PromocoesController@paginaVotacao');
Route::post('/adm/promocoes/votacao/addVotoCliente', 'PromocoesController@addVotoCliente');
Route::post('/adm/promocoes/addVotoCadastro', 'PromocoesController@addVotoCadastro');
Route::get('admin/promocoes', 'PromocoesController@indexPromocoes');
Route::post('admin/promocoes/sorteioVotacao', 'PromocoesController@sorteioVotacao');
Route::post('admin/promocoes/salvaSorteado', 'PromocoesController@salvaSorteado');

//Produtos
Route::get('/admin', 'ProdutosController@indexPrato');
Route::get('/admin/produtos/pratos/lista', 'ProdutosController@indexPrato');
Route::get('/admin/produtos/pratos/mostra/{id}', 'ProdutosController@mostraPrato');
Route::get('/admin/produtos/pratos/edita/{id}', 'ProdutosController@editaPrato');
Route::post('/admin/produtos/pratos/edita/{id}', 'ProdutosController@updatePrato');
Route::get('/admin/produtos/pratos/ativar/{id}', 'ProdutosController@ativarPrato');
Route::get('/admin/produtos/pratos/desativar/{id}', 'ProdutosController@desativarPrato');
Route::get('/admin/produtos/pratos/excluir/{id}', 'ProdutosController@destroyPrato');

//Pratos
Route::post('/admin/produtos/salvaPratos', 'ProdutosController@salvaPrato');
Route::post('/admin/produtos/pratos/ingredientes/add', 'ReceitasController@addIngrediente');
Route::post('/admin/produtos/ingrediente/editar/{id}', 'ReceitasController@editaIngrediente');
Route::get('/admin/produtos/ingrediente/excluir/{id}', 'ReceitasController@excluiIngrediente');

Route::get('/admin/produtos/pratosSemana', 'ProdutosController@semanaIndex');
Route::post('/admin/produtos/salvaPratoSemana', 'ProdutosController@salvaPratoSemana');
Route::get('/admin/produtos/excluiPratoSemana/{id}', 'ProdutosController@excluiPratoSemana');
Route::post('/admin/produtos/addPratoSemana/{id}', 'ProdutosController@addPratoSemana');
Route::post('/admin/produtos/enviaPratoDoDia', 'ProdutosController@enviaPratoDoDia');

// Clientes
Route::get('/admin/clientes/lista', 'ClienteController@lista');
Route::get('/admin/clientes/mostra/{id}', 'ClienteController@mostraCliente');
Route::get('/admin/clientes/sairEmail/{id}', 'ClienteController@sairEmail');
Route::get('/admin/clientes/entrarEmail/{id}', 'ClienteController@entrarEmail');
Route::get('/admin/clientes/retiraPreferencias/{clienteId}/{preferencia}', 'ClienteController@excluiPreferencia');
Route::post('/admin/clientes/addPreferencia', 'ClienteController@addPreferencia');
Route::get('/admin/clientes/edita/{id}', 'ClienteController@editaCliente');
Route::get('/admin/clientes/excluir/{id}', 'ClienteController@destroy');
Route::post('/admin/clientes/edita/{id}', 'ClienteController@updateCliente');
Route::get('/admin/clientes/enviaPrato/{id}', 'ClienteController@enviaEmailPratoDoDia');

//A bertura
Route::get('/', function () {
    return view('welcome');
});

// Função para testar views
Route::get('/teste', function () {
    return view('emails/marketing/pratoNovo');
});

Route::get('/hoje', 'ProdutosController@landPratoDoDia');
Route::get('/amanha', 'ProdutosController@landAmanha');

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('/auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('/admin/usuarios/add', 'Auth\AuthController@novoUser');
Route::post('auth/register', 'Auth\AuthController@salvaUsuario');

Route::get('password', 'Auth\PasswordController@formSenha');
Route::post('password/email', 'Auth\PasswordController@resetPass');

Route::get('/admin/usuarios/configuracoes', 'Auth\AuthController@editaUsuario');
Route::post('/admin/usuarios/configuracoes/update', 'Auth\AuthController@updateUsuario');

