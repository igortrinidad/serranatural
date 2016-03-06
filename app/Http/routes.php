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
	Route::group(['as' => 'client.'], function() {
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
		Route::post('clientes/addVoucherCortesia/{id}', ['as' => 'addVoucherCortesia', 'uses' => 'ClienteController@addVoucherCortesia']);
		Route::get('clientes/reenviaSenha/{id}', ['as' => 'reenviaSenha', 'uses' => 'ClienteController@reenviaSenha']);
		Route::post('clientes/salvaPonto', ['as' => 'salvaPonto', 'uses' => 'ClienteController@salvaPonto']);
		Route::post('clientes/fidelidade/usaVoucher/{voucher}', ['as' => 'usesVoucher', 'uses' => 'ClienteController@usesVoucher']);
	});

		// Financeiro
	Route::group(['as' => 'financeiro.'], function()

	{
		Route::get('financeiro/fluxo', ['as' => 'fluxo', 'uses' => 'FinanceiroController@indexFluxo']);
		Route::get('financeiro/historico', ['as' => 'historico', 'uses' => 'FinanceiroController@indexHIstorico']);
		Route::post('financeiro/abrirCaixa', ['as' => 'abreCaixa', 'uses' => 'FinanceiroController@abreCaixa']);
		Route::post('financeiro/gravarCaixa', ['as' => 'gravarCaixa', 'uses' => 'FinanceiroController@gravarCaixa']);
		Route::post('financeiro/fecharCaixa', ['as' => 'fecharCaixa', 'uses' => 'FinanceiroController@fecharCaixa']);
		Route::get('financeiro/retirada', ['as' => 'retirada', 'uses' => 'FinanceiroController@retirada']);
		Route::post('financeiro/retiradaPost', ['as' => 'retiradaPost', 'uses' => 'FinanceiroController@retiradaPost']);
		Route::get('financeiro/retiradas', ['as' => 'retiradasList', 'uses' => 'FinanceiroController@retiradasList']);
		Route::get('financeiro/pagamentos', ['as' => 'pagamentos', 'uses' => 'FinanceiroController@cadastraPgto']);
		Route::post('financeiro/pagamentosPost', ['as' => 'pagamentosPost', 'uses' => 'FinanceiroController@storePgto']);
		Route::get('financeiro/Pagar', ['as' => 'aPagar', 'uses' => 'FinanceiroController@listaAPagar']);
		Route::get('financeiro/pagamentos/historico', ['as' => 'historicoPagamentos', 'uses' => 'FinanceiroController@historicoPagamentos']);
		Route::get('financeiro/pagamentos/{id}/detalhes', ['as' => 'detalhes', 'uses' => 'FinanceiroController@detalhesPagamento']);
		Route::post('financeiro/liquidar', ['as' => 'liquidar', 'uses' => 'FinanceiroController@liquidar']);
		Route::get('financeiro/pagamentos/{id}/edit', ['as' => 'editPagamento', 'uses' => 'FinanceiroController@editPagamento']);
		Route::post('financeiro/pagamentos/{id}/update', ['as' => 'updatePagamento', 'uses' => 'FinanceiroController@updatePagamento']);
		Route::get('financeiro/pagamentos/{id}/apagar', ['as' => 'apagarPagamento', 'uses' => 'FinanceiroController@destroyPagamento']);
		Route::get('financeiro/pagamentos/escolha', ['as' => 'escolha', 'uses' => 'FinanceiroController@escolha']);
		Route::post('financeiro/pagamentos/dateRange', ['as' => 'dateRange', 'uses' => 'FinanceiroController@dateRange']);
		Route::get('financeiro/despesa', ['as' => 'despesa', 'uses' => 'FinanceiroController@despesaCreate']);
		Route::post('financeiro/despesaStore', ['as' => 'despesaStore', 'uses' => 'FinanceiroController@despesaStore']);
		Route::post('financeiro/consultaCaixaAjax', ['as' => 'consultaCaixaAjax', 'uses' => 'FinanceiroController@consultaCaixaAjax']);
		Route::post('financeiro/despesaStoreVue', ['as' => 'despesaStoreVue', 'uses' => 'FinanceiroController@despesaStoreVue']);
	});


	// Funcionarios
	Route::group(['as' => 'funcionarios.'], function()

	{
		Route::get('funcioarios/adiciona', ['as' => 'adiciona', 'uses' => 'FuncionariosController@create']);
		Route::post('funcioarios/adiciona', ['as' => 'store', 'uses' => 'FuncionariosController@store']);
		Route::get('funcioarios/lista', ['as' => 'lista', 'uses' => 'FuncionariosController@lista']);
		Route::get('funcioarios/{id}/detalhes', ['as' => 'detalhes', 'uses' => 'FuncionariosController@show']);
		Route::get('funcioarios/{id}/edita', ['as' => 'edit', 'uses' => 'FuncionariosController@edit']);
		Route::post('funcioarios/{id}/update', ['as' => 'update', 'uses' => 'FuncionariosController@update']);

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

	//Rotas MARKETING
	Route::group(['as' => 'marketing.', 'prefix' => 'marketing'], function()
	{
		Route::get('modelos/criar', ['as' => 'criarModelo', 'uses' => 'MarketingController@criarModelo']);
		Route::post('salvarModelo', ['as' => 'salvarModelo', 'uses' => 'MarketingController@salvarModelo']);
		Route::get('modelos/lista', ['as' => 'lista', 'uses' => 'MarketingController@lista']);
		Route::post('modelos/enviaEmail/{id}', ['as' => 'enviaEmail', 'uses' => 'MarketingController@enviaEmail']);
		Route::get('modelos/editar/{id}', ['as' => 'editaModelo', 'uses' => 'MarketingController@editaModelo']);
		Route::post('modelos/update/{id}', ['as' => 'updateModelo', 'uses' => 'MarketingController@updateModelo']);
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

Route::group(['as' => 'produtos.'], function()
{
	Route::group(['as' => 'pratos.'], function()
	{
		Route::get('/admin/produtos/pratos/lista', ['as' => 'lista', 'uses' => 'ProdutosController@listaPrato']);
		Route::get('/admin/produtos/pratos/create', ['as' => 'add', 'uses' =>'ProdutosController@createPrato']);
		Route::get('/admin/produtos/pratos/mostra/{id}', 'ProdutosController@mostraPrato');
		Route::get('/admin/produtos/pratos/edita/{id}', 'ProdutosController@editaPrato');
		Route::post('/admin/produtos/pratos/edita/{id}', 'ProdutosController@updatePrato');
		Route::get('/admin/produtos/pratos/ativar/{id}', 'ProdutosController@ativarPrato');
		Route::get('/admin/produtos/pratos/desativar/{id}', 'ProdutosController@desativarPrato');
		Route::get('/admin/produtos/pratos/excluir/{id}', 'ProdutosController@destroyPrato');
		Route::post('/admin/produtos/pratos/consultaPrato', 'ProdutosController@consultaPrato');

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

		
		

	});

	Route::group(['as' => 'produtos.'], function() {
		
		//Produtos
		Route::get('/admin/produtos/lista', 'ProdutosController@listaProdutos');
		Route::get('/admin/produtos/create', 'ProdutosController@createProdutos');
		Route::post('/admin/produtos/storeProduto', 'ProdutosController@storeProduto');
		Route::get('/admin/produtos/calcular/index', 'ReceitasController@rangeIndex');
		Route::post('/admin/produtos/calcular/dateRange', 'ReceitasController@dateRange');
		Route::get('/admin/produtos/ingredientes/excluir/{produto}/{prato}', 'ReceitasController@excluiIngrediente');
		Route::get('/admin/produtos/show/{id}', ['as' => 'show', 'uses' => 'ProdutosController@showProduto']);
		Route::get('/admin/produtos/edit/{id}', ['as' => 'edit', 'uses' => 'ProdutosController@editProduto']);
		Route::post('/admin/produtos/update/{id}', ['as' => 'update', 'uses' => 'ProdutosController@updateProduto']);
		Route::get('/admin/produtos/produtosForSelectJson/{trackeds}', ['as' => 'select', 'uses' => 'ProdutosController@produtosForSelectJson']);
		Route::get('/admin/produtos/baixaestoque', ['uses' => 'ProdutosController@baixaestoque']);
		Route::post('/admin/produtos/baixaestoquePost', ['uses' => 'ProdutosController@baixaestoquePost']);
		Route::get('/admin/produtos/balanco', ['uses' => 'ProdutosController@balanco']);
		Route::post('/admin/produtos/balancoPost', ['uses' => 'ProdutosController@balancoPost']);
		Route::get('/admin/produtos/historico/balanco', ['uses' => 'ProdutosController@historicoBalanco']);
		Route::get('/admin/produtos/historico/balancosJson', ['uses' => 'ProdutosController@balancosJson']);
	});

});



Route::get('/hoje', 'ProdutosController@landPratoDoDia');
Route::get('/hojeCompleto1010', 'ProdutosController@landPratoDoDiaCompleto');
Route::get('/amanhaCompleto1010', 'ProdutosController@landAmanhaCompleto');
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
	Route::get('', ['as' => 'teste', 'uses' => 'TesteController@testeEmail']);
    Route::post('testeApi', ['as' => 'testeApi', 'uses' => 'ClienteController@testeApi']);
	Route::post('summernote', ['as' => 'summernote', 'uses' => 'TesteController@summernote']);
	Route::get('index', ['as' => 'index', 'uses' => 'TesteController@index']);

});

Route::get('image/pagamentos/{filename}', ['as' => 'image.pagamentos', function ($filename)
			{
			    return Image::make(storage_path() . '/app/financeiro/pagamentos/' . $filename)->response();
			}]
);

Route::get('arquivos/pagamentos/{filename}', ['as' => 'arquivos.pagamentos', function ($filename)
	{
	    $path = storage_path() . '/app/financeiro/pagamentos/' . $filename;

	    $file = File::get($path);
	    $type = File::mimeType($path);

	    $response = Response::make($file, 200);
	    $response->header("Content-Type", $type);

	    return $response;
	}]
	);

Route::get('arquivos/produtos/{filename}', ['as' => 'arquivos.produtos', function ($filename)
	{
	    $path = storage_path() . '/app/produtos/' . $filename;

	    $file = File::get($path);
	    $type = File::mimeType($path);

	    $response = Response::make($file, 200);
	    $response->header("Content-Type", $type);

	    return $response;
	}]
	);

Route::post('oauth/access_token', function() {
    return Response::json(Authorizer::issueAccessToken());
});

Route::group(['as' => 'api.', 'middleware' => 'oauth', 'prefix' => 'api'], function()
{
	Route::get('oauth1', function () 
	{
		return [
			'id' => 1,
			'nome' => 'Sei la quantos',
		];
	});

	Route::get('square/teste', ['as' => 'square.teste', 'uses' => 'ApiController@squareTeste']);
});

Route::get('connect/consultaPontos/{email}', ['as' => 'consultaPontos', 'uses' => 'ApiController@consultaPontos']);
Route::get('connect/consultaPratoHoje', ['as' => 'consultaPratoHoje', 'uses' => 'ApiController@consultaPratoHoje']);


Route::group(['as' => 'cors.',  'prefix' => 'cors', 'middleware' => 'cors'], function()
{
	Route::post('teste', function () 
	{
		return [
			'id' => 2,
			'nome' => 'Sei la quantos',
		];
	});
});
