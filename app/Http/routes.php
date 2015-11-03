<?php

//Home
Route::get('/', function() {
	return view('auth/login');
});
Route::get('/login', function(){return view('auth/login');});

//Rota adimin geral
Route::group(['as' => 'admin.', 'prefix' => 'admin'], function()
{
		// Clientes
	Route::group(['as' => 'client.'], function()

	{
		Route::get('clientes/lista', ['as' => 'lista', 'uses' => 'ClienteController@lista']);
		Route::get('clientes/{id}/mostra', ['as' => 'show', 'uses' => 'ClienteController@mostraCliente']);
		Route::get('clientes/sairEmail/{id}', ['as' => 'sairEmail', 'uses' => 'ClienteController@sairEmail']);
		Route::get('clientes/entrarEmail/{id}', ['as' => 'entrarEmail', 'uses' => 'ClienteController@entrarEmail']);
		Route::get('clientes/retiraPreferencias/{clienteId}/{preferencia}', ['as' => 'retiraPreferencias', 'uses' => 'ClienteController@excluiPreferencia']);
		Route::post('clientes/addPreferencia', ['as' => 'addPreferencia', 'uses' => 'ClienteController@addPreferencia']);
		Route::get('clientes/edita/{id}', ['as' => 'edit', 'uses' => 'ClienteController@editaCliente']);
		Route::get('clientes/excluir/{id}', ['as' => 'destroy', 'uses' => 'ClienteController@destroy']);
		Route::post('clientes/edita/{id}', ['as' => 'update', 'uses' => 'ClienteController@updateCliente']);
		Route::get('clientes/enviaPrato/{id}', ['as' => 'enviaPrato', 'uses' => 'ClienteController@enviaEmailPratoDoDia']);
		Route::post('clientes/editaSelected', ['as' => 'editaSelected', 'uses' => 'ClienteController@editaSelected']);
		Route::get('clientes/fidelidade', ['as' => 'fidelidade', 'uses' => 'ClienteController@fidelidadeIndex']);
		Route::post('clientes/salvaPonto', ['as' => 'salvaPonto', 'uses' => 'ClienteController@salvaPonto']);
		Route::post('clientes/fidelidade/usaVoucher/{voucher}', ['as' => 'usesVoucher', 'uses' => 'ClienteController@usesVoucher']);

	});

		// Clientes
	Route::group(['as' => 'financeiro.'], function()

	{
		Route::get('financeiro/fluxo', ['as' => 'fluxo', 'uses' => 'FinanceiroController@indexFluxo']);
		Route::get('financeiro/historico', ['as' => 'historico', 'uses' => 'FinanceiroController@indexHIstorico']);
		Route::post('financeiro/abrirCaixa', ['as' => 'abreCaixa', 'uses' => 'FinanceiroController@abreCaixa']);
		Route::post('financeiro/gravarCaixa', ['as' => 'gravarCaixa', 'uses' => 'FinanceiroController@gravarCaixa']);
		Route::post('financeiro/fecharCaixa', ['as' => 'fecharCaixa', 'uses' => 'FinanceiroController@fecharCaixa']);

	});

	//Rota index dashboard
	Route::get('', ['as' => 'index', 'uses' => 'SystemController@indexDashboard']);
	//Rotas de login e usuario
	Route::group(['as' => 'users.'], function()
	{
		Route::get('usuarios/add', ['as' => 'add', 'uses' =>'Auth\AuthController@novoUser']);
		Route::get('password', ['as' => 'password', 'uses' =>'Auth\PasswordController@formSenha']);
		Route::post('password/email', ['as' => 'reset', 'uses' =>'Auth\PasswordController@resetPass']);
		Route::get('usuarios/configuracoes', ['as' => 'edit', 'uses' =>'Auth\AuthController@editaUsuario']);
		Route::post('usuarios/configuracoes/update', ['as' => 'update', 'uses' =>'Auth\AuthController@updateUsuario']);

	});


});

//Rotas originais Auth Laravel
Route::group(['as' => 'auth.', 'prefix' => 'auth'], function()
{
		Route::get('login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
		Route::post('login', ['as' => 'postLogin', 'uses' => 'Auth\AuthController@postLogin']);
		Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);
		Route::post('register', ['as' => 'register', 'uses' =>'Auth\AuthController@salvaUsuario']);		
});

//Promoções
Route::group(['as' => 'promocoes.'], function()
{
	Route::get('/PromoVotacao', ['as' => 'landVotacao', 'uses' => 'PromocoesController@paginaVotacao']);
	Route::post('/adm/promocoes/votacao/addVotoCliente', ['as' => 'addVotoCliente', 'uses' => 'PromocoesController@addVotoCliente']);
	Route::post('/adm/promocoes/addVotoCadastro', ['as' => 'addVotoCadastro', 'uses' => 'PromocoesController@addVotoCadastro']);
	Route::get('admin/promocoes', ['as' => 'index', 'uses' => 'PromocoesController@indexPromocoes']);
	Route::post('admin/promocoes/sorteioVotacao', ['as' => 'sorteioVotacao', 'uses' => 'PromocoesController@sorteioVotacao']);
	Route::post('admin/promocoes/salvaSorteado', ['as' => 'salvaSorteado', 'uses' => 'PromocoesController@salvaSorteado']);
});

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






Route::get('/hoje', 'ProdutosController@landPratoDoDia');
Route::get('/amanha', 'ProdutosController@landAmanha');
Route::get('/cadastro', 'ClienteController@cadastro');
Route::post('/cadastro', 'ClienteController@storeSelfCliente');


Route::post('/me/selfChangeClient', 'ClienteController@selfChangeClient');
Route::get('/me/edita/{email}', 'ClienteController@clienteSelfEdita');
Route::get('/me/{email}', [
    'as' => 'selfClient.mostraSelected', 'uses' => 'ClienteController@clienteSelfMostra'
]);

// Rotas para teste
Route::group(['as' => 'teste.', 'prefix' => 'teste'], function()
{
	Route::get('', function () 
	{
		return view('emails/marketing/pratoNovo');
	});
    Route::post('testeApi', ['as' => 'testeApi', 'uses' => 'ClienteController@testeApi']);
	Route::post('summernote', ['as' => 'summernote', 'uses' => 'TesteController@summernote']);
	Route::get('index', ['as' => 'index', 'uses' => 'TesteController@index']);

});


