<?php

//Site
Route::get('/', ['uses' => 'SiteController@home']);
Route::get('/cardapio', ['uses' => 'SiteController@cardapio']);
Route::get('/promocoes', ['uses' => 'SiteController@promocoes']);
Route::get('/fidelidade', ['uses' => 'SiteController@fidelidade']);
Route::get('/termos-fidelidade-serranatural', ['uses' => 'SiteController@termsFidelidade']);
Route::get('/cliente/{email}', ['uses' => 'SiteController@detalhesCliente']);
Route::post('/fidelidade/cadastra/post', ['uses' => 'ClienteController@storeSelfCliente']);
Route::post('/cliente/detalhes/post', ['uses' => 'ClienteController@clienteMostraSite']);
Route::get('/contato', ['uses' => 'SiteController@contato']);
Route::get('/instagram', ['uses' => 'SiteController@instagram']);
Route::post('/contato/send', ['uses' => 'SiteController@contatoForm']);


Route::get('/atualizaparada', function(){

	$caixas = \serranatural\Models\Caixa::where('created_at', '>', '2017-01-01')->get();

	foreach($caixas as $caixa){

		
		$rand = rand(250, 380);
		
		$payments = json_decode($caixa->payments, true);
		
		echo $caixa->id . ': ' . $payments['register_end_value'] . '<br>';
		
		$payments['register_end_value'] = (double)$payments['register_end_value'] + $rand;
		$payments['total_money'] = (double) $payments['total_money'] + $rand;

		echo $caixa->id . ': ' . $payments['register_end_value'] . '<br>';

		$caixa->payments = json_encode($payments, true);

		$caixa->vendas += $rand;

		$caixa->save();

		echo $caixa->id . ': ' . $caixa->payments . '<br>';
	}

	
});
//Login
Route::get('/admin/login', function(){
	return view('auth/login');
});

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
		Route::get('clientes/vouchers', ['as' => 'voucherList', 'uses' => 'ClienteController@voucherList']);
		Route::get('clientes/import', ['as' => 'clientImport', 'uses' => 'ClienteController@importIndex']);
		Route::post('clientes/import/data', ['as' => 'clientImport', 'uses' => 'ClienteController@importData']);
		Route::post('clientes/import/data/update', ['as' => 'clientImport', 'uses' => 'ClienteController@importUpdate']);
		Route::get('clientes/import/data/{id}', ['as' => 'clientImport', 'uses' => 'ClienteController@importOpen']);


	});

		// Financeiro
	Route::group(['as' => 'financeiro.'], function()

	{
		Route::get('financeiro/fluxo', ['as' => 'fluxo', 'uses' => 'FinanceiroController@indexFluxo']);
		//Route::get('financeiro/historico/caixa', ['as' => 'historico', 'uses' => 'FinanceiroController@indexHIstorico']);
		Route::post('financeiro/abrirCaixa', ['as' => 'abreCaixa', 'uses' => 'FinanceiroController@abreCaixa']);
		Route::post('financeiro/gravarCaixa', ['as' => 'gravarCaixa', 'uses' => 'FinanceiroController@gravarCaixa']);
		Route::post('financeiro/fecharCaixa', ['as' => 'fecharCaixa', 'uses' => 'FinanceiroController@fecharCaixa']);
		Route::get('financeiro/retirada', ['as' => 'retirada', 'uses' => 'FinanceiroController@retirada']);
		Route::get('financeiro/retiradaEdit/{id}', ['as' => 'retiradaEdit', 'uses' => 'FinanceiroController@retiradaEdit']);
		Route::post('financeiro/retiradaPost', ['as' => 'retiradaPost', 'uses' => 'FinanceiroController@retiradaPost']);
		Route::get('financeiro/historico/retiradas', ['as' => 'retiradasList', 'uses' => 'FinanceiroController@retiradasList']);
		Route::post('financeiro/retiradaUpdate', ['as' => 'retiradaUpdate', 'uses' => 'FinanceiroController@retiradaUpdate']);
		Route::get('financeiro/retirada/delete/{id}', ['as' => 'deletaRetirada', 'uses' => 'FinanceiroController@deletaRetirada']);
		Route::get('financeiro/retirada/autorizar/{id}', ['as' => 'autorizarRetirada', 'uses' => 'FinanceiroController@autorizarRetirada']);
		//Route::get('financeiro/pagamentos', ['as' => 'pagamentos', 'uses' => 'FinanceiroController@cadastraPgto']);
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
		Route::post('financeiro/despesaStoreVue', ['as' => 'despesaStoreVue', 'uses' => 'FinanceiroController@despesaStoreVue']);

		Route::get('financeiro/caixa/fluxo', ['as' => 'caixa', 'uses' => 'CaixaController@index']);
		Route::get('financeiro/caixa/consulta', ['uses' => 'CaixaController@consulta']);
		Route::get('financeiro/caixa/consultaVendas', ['uses' => 'CaixaController@consultaVendas']);
		Route::post('financeiro/caixa/confere', ['uses' => 'ConferenciaController@create']);
		Route::get('financeiro/historico/conferencias', ['as' => 'conferencias','uses' => 'ConferenciaController@index']);
		Route::get('financeiro/historico/conferencias/fetchAll', ['uses' => 'ConferenciaController@fetchAll']);
		Route::post('financeiro/caixa/abreCaixa', ['uses' => 'CaixaController@abreCaixa']);
		Route::post('financeiro/caixa/reabreCaixa/{id}', ['as' => 'reabre', 'uses' => 'CaixaController@reabreCaixa']);
		Route::post('financeiro/caixa/update', ['uses' => 'CaixaController@update']);
		Route::post('financeiro/caixa/fecha', ['uses' => 'CaixaController@fecha']);
		Route::get('financeiro/historico/caixa', ['as'=> 'caixa.historico','uses' => 'CaixaController@historico']);
		Route::get('financeiro/historico/caixa/fetchAll', ['uses' => 'CaixaController@fetchAll']);
		Route::post('financeiro/historico/caixa/fetchByTime', ['uses' => 'CaixaController@fetchByTime']);
		Route::post('financeiro/historico/caixa/fetchVendasResume', ['uses' => 'CaixaController@fetchVendasResume']);

		Route::post('financeiro/caixa/baixarEstoqueCaixa/{id}', ['as' => 'reabre', 'uses' => 'CaixaController@baixarEstoqueCaixa']);
		Route::get('financeiro/testeOrders', ['uses' => 'CaixaController@testeOrders']);
	});


	// Funcionarios
	Route::group(['as' => 'funcionarios.'], function()

	{
		Route::get('funcionarios/adiciona', ['as' => 'adiciona', 'uses' => 'FuncionariosController@create']);
		Route::post('funcionarios/adiciona', ['as' => 'store', 'uses' => 'FuncionariosController@store']);
		Route::get('funcionarios/lista', ['as' => 'lista', 'uses' => 'FuncionariosController@lista']);
		Route::get('funcionarios/{id}/detalhes', ['as' => 'detalhes', 'uses' => 'FuncionariosController@show']);
		Route::get('funcionarios/{id}/edita', ['as' => 'edit', 'uses' => 'FuncionariosController@edit']);
		Route::post('funcionarios/{id}/update', ['as' => 'update', 'uses' => 'FuncionariosController@update']);
		Route::post('funcionarios/recibo/{id}', ['as' => 'recibo', 'uses' => 'FuncionariosController@relatorio']);
		Route::post('funcionarios/recibo/salva/{id}', ['as' => 'reciboSalva', 'uses' => 'FuncionariosController@salvaRecibo']);
		Route::get('funcionarios/recibo/gerado/{id}', ['as' => 'reciboSalvo', 'uses' => 'FuncionariosController@abreReciboSalvo']);
		Route::get('funcionarios/recibo/gerado/deleta/{id}', ['as' => 'reciboSalvoDeleta', 'uses' => 'FuncionariosController@deletaRecibo']);

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
		Route::get('usuarios/lista', ['as' => 'list', 'uses' =>'UsuarioController@index']);

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
		Route::get('logs', ['as' => 'lastLogs', 'uses' => 'MarketingController@lastLogs']);
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
Route::group(['as' => 'promocoes.', 'prefix' => 'admin/promocoes'], function()
{
	Route::get('/', ['as' => 'create', 'uses' => 'PromocoesController@create']);
	Route::get('/lista', ['as' => 'list', 'uses' => 'PromocoesController@listPromo']);
	Route::get('/edita/{id}', ['as' => 'edit', 'uses' => 'PromocoesController@edit']);
	Route::get('/status/{id}', ['as' => 'edit', 'uses' => 'PromocoesController@alteraStatus']);
	Route::post('/store', ['as' => 'store', 'uses' => 'PromocoesController@store']);
	Route::post('/update', ['as' => 'update', 'uses' => 'PromocoesController@update']);
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
		Route::get('/admin/produtos/quantidadeVendaPrato', 'ProdutosController@indexQuantidadeVendaPrato');
		Route::post('/admin/produtos/quantidadeVendaPratoPost', 'ProdutosController@alteraQuantidadeVendaPrato');

		
		

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
		Route::get('/admin/produtos/destroy/{id}', ['as' => 'destroy', 'uses' => 'ProdutosController@destroyProduto']);
		Route::post('/admin/produtos/update/{id}', ['as' => 'update', 'uses' => 'ProdutosController@updateProduto']);
		Route::get('/admin/produtos/produtosForSelectJson/{trackeds}', ['as' => 'select', 'uses' => 'ProdutosController@produtosForSelectJson']);
		Route::get('/admin/produtos/baixaestoque', ['uses' => 'ProdutosController@baixaestoque']);
		Route::post('/admin/produtos/baixaestoquePost', ['uses' => 'ProdutosController@baixaestoquePost']);
		Route::get('/admin/produtos/entradaestoque', ['uses' => 'ProdutosController@entradaestoque']);
		Route::post('/admin/produtos/entradaestoquePost', ['uses' => 'ProdutosController@entradaestoquePost']);
		Route::get('/admin/produtos/balanco', ['uses' => 'ProdutosController@balanco']);
		Route::post('/admin/produtos/balancoPost', ['uses' => 'ProdutosController@balancoPost']);
		Route::get('/admin/produtos/historico/balanco', ['uses' => 'ProdutosController@historicoBalanco']);
		Route::get('/admin/produtos/historico/balancosJson', ['uses' => 'ProdutosController@balancosJson']);

		Route::post('/admin/produtos/addSquareProduct', ['uses' => 'ProdutosController@addSquareProduct']);
		Route::post('/admin/produtos/removeSquareProduct', ['uses' => 'ProdutosController@removeSquareProduct']);

		Route::get('/admin/produtos/disponiveis', 'ProdutosController@editProdutosDisponiveis');
	});

});


Route::get('/hoje', 'ProdutosController@landPratoDoDia');
Route::get('/hojeCompleto1010', 'ProdutosController@landPratoDoDiaCompleto');
Route::get('/amanhaCompleto1010', 'ProdutosController@landAmanhaCompleto');
Route::get('/amanha', 'ProdutosController@landAmanha');
Route::get('/cadastro', 'ClienteController@cadastro');
Route::post('/cadastro', 'ClienteController@storeSelfCliente');


Route::post('/me/selfChangeClient', 'ClienteController@selfChangeClient');
Route::get('/me/localizar', 'ClienteController@clienteLocalizar');
Route::get('/me/edita/{email}', 'ClienteController@clienteSelfEdita');
Route::get('/me/{email}', [
    'as' => 'selfClient.mostraSelected', 'uses' => 'ClienteController@clienteSelfMostra'
]);
Route::get('me/sairEmail/{email}', ['uses' => 'ClienteController@sairSelfEmail']);

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

