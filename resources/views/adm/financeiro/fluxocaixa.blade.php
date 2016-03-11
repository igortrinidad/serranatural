@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Controle de caixa</h2><br>

<div class="row" id="contentCaixa">

	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">Caixa</div>
			<div class="panel-body">

				<div class="col-md-6">
					<div class="form-group">
						<label>Total de vendas sistema</label>
						<input type="text" class="form-control" />
					</div>

					<div class="form-group">
						<label>Total de taxa recolhida periodo</label>
						<input type="text" class="form-control" />
					</div>
					
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>Total de vendas sistema</label>
						<input type="text" class="form-control" />
					</div>
				</div>
				

			</div>
		</div>

		
	</div>

	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">Ações</div>
			<div class="panel-body">
				<button class="btn btn-default btn-block">Salvar</button>
				<button class="btn btn-primary btn-block">Fechar caixa</button>

			</div>

		</div>
	</div>

</div>
<div class="row">

	<div class="jumbotron">
			<h3>Instruções</h3>
			<h5>Total de vendas em dinheiro (sistema)</h5>
			<p style="font-size: 14px;">Inserir o valor de acordo com o registrado no aplicativo de vendas. Caminho: Acessar o menu no ícone: <i class="fa fa-bars"></i> <b> / REPORTS / SALES / CASH SALES: ( VALOR )</p>

			<h5>Total de vendas em cartão (sistema)</h5>
			<p style="font-size: 14px;">Inserir o valor de acordo com o registrado no aplicativo de vendas. Caminho: Acessar o menu no ícone: <i class="fa fa-bars"></i> <b> / REPORTS / SALES / THIRD PARTY SALES: ( VALOR )</p>

			<h5>Total de vendas maquina REDE</h5>
			<p style="font-size: 14px;">Inserir o valor de acordo com valor informado na máquina de cartão REDE através do caminho: <b>ADMINISTRA / RESUMO DE VENDAS / escolha da data do dia (HOJE) / RESUMIDO / DESCARTAR IMPRESSÃO: NÃO</b>. Obs. o valor a ser preenchido é o total no final da impressão.</p>

			<h5>Total de vendas maquina CIELO</h5>
			<p style="font-size: 14px;">Somar o valor total das vendas realizadas através da máquina CIELO. Obs. a máquina CIELO não permite a consulta diretamente pela máquina, portanto todos os comprovantes de vendas da máquina deverão ser guardados para o fechamento do caixa.</p>

			<h5>Total de retiradas</h5>
			<p style="font-size: 14px;">Este valor é preenchido automaticamente conforme for cadastrado as retiradas.</p>

			<h5>Valor em caixa</h5>
			<p style="font-size: 14px;">Contar todo dinheiro no caixa, incluindo dinheiro guardado em baixo da gaveta e vouchers.</p>

			<h5>Fechar caixa</h5>
			<p style="font-size: 14px;">Clicar em <b>Calcular caixa</b> e conferir se o valor bate com o esperado (positivo ou negativo), clicar em <b>Gravar caixa</b> e <b>Fechar caixa</b> inserindo a senha de operação (pessoal).</p>

		</div>


</div>


		<div class="jumbotron">
			<h3>Instruções</h3>
			<p style="font-size: 14px;">Contar todo dinheiro no caixa, incluindo dinheiro guardado em baixo da gaveta e vouchers. Inserir o valor e clicar em <b>"abrir caixa"</b>.</p>
		</div>
	</div>
	

<!-- Modal editar atividade -->              
                            <div class="modal inmodal fade" id="modalSenha" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title" id="tituloModal">Confirma</h4>
                                        </div>
                                        <div class="modal-body text-center">
											<h4>Valor em caixa:</h4>

                                            <p style="font-size: 25px;font-weight:700" id="valor_confirmation">??</p>
											<span >
	                                            <h4>Diferença final:</h4>

	                                            <p style="font-size: 25px;font-weight:700" id="diferenca_caixa"></p>
                                            </span>
                                    
                                        </div>
                                        <div class="modal-footer inline">

											<form id="formAbreCaixa" method="POST">

												<input type="hidden" name="_token" value="{{ csrf_token() }}">
											
											<div class="form-group">
												<label>Insira sua senha</label>
                                        		<input type="password" id="inputSenha" name="senha" class="form-control" value="" />
											</div>

	                                            <button type="button" class="btn btn-white btn-sm" data-dismiss="modal">Cancela</button>
	                                            
	                                            <button id="btnAbreCaixaDefinitivo" class="btn btn-danger btn-sm">Confirma abertura</button>

	                                            <button id="btnFechaDefinitivo" class="btn btn-danger btn-sm" style="display:none">Confirma fechamento</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">


    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/financeiro.js') !!}"></script>

	        <script src="{!! elixir('js/financeiro.js') !!}"></script>

			<script type="text/javascript">

				Vue.config.debug = true;
				Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#_tokenLaravel').getAttribute('value');
				var vm = new Vue({
				    el: '#contentCaixa',
				    data: {
				    	return: '',
				    	caixa_1: {
				    		'fundo_caixa_anterior',
				    		'abertura_caixa',
				    		venda_total: '',
				    		tax_total: '',
				    		'venda_liquido',
				    		'rede_total',
				    		'cielo_total',
				    		'fundo_caixa',

				    	},
				    	caixa_2: {

				    	},
				    	produtosForSelect: [],
				    	selected: {id: '', nome: '', quantidade: ''},
				    },
				    attached: function()
    					{
        					
    					},
					    ready: function() {
				 	      	var self = this;	
					      	// GET request
					      	this.$http.get('/admin/produtos/produtosForSelectJson/anything').then(function (response) {
					          self.produtosForSelect = response.data;
					      }, function (response) {
					          console.log(response);
					      });
					    },
				    methods: {
				    	addProduto: function(ev, quantidade) {
				    		ev.preventDefault();
				    		if( ! this.selected.nome  || ! this.selected.quantidade ) {
				    			return false;
				    		}
				    		Produto = {id: this.selected.id, nome: this.selected.nome, quantidade: this.selected.quantidade};
				    		this.pagamento.produtos.push(Produto);
				    		this.selected = {id: '', nome: '', quantidade: ''};
				    	},
				    	onFileChange(e) {
					      	var files = e.target.files || e.dataTransfer.files;
					      	if (!files.length) {
					        	return false;
					    	}
					      	this.createImage(files[0]);
					    },
					    createImage(file) {
					      var image = new Image();
					      var reader = new FileReader();
					      var vm = this;
					      reader.onload = function(e) {
					        vm.pagamento.comprovante = e.target.result;
					      };
					      reader.readAsDataURL(file);
					    },
					    removeImage: function(ev) {
					    	ev.preventDefault();
					      	this.pagamento.comprovante = '';
					    },
					    saveComprovante: function(ev) {
					    	self = this;
					    	this.$http.post('/admin/financeiro/despesaStoreVue', this.pagamento).then(function (response) {

						    	self.return = response.data.return;
						    	swal(self.return.title, self.return.message, self.return.type);

						    	self.pagamento.valor = '';
					    		self.pagamento.data_pgto = '';
					    		self.pagamento.descricao = '';
					    		self.pagamento.fonte_pgto = '';
					    		self.pagamento.observacoes = '';
					    		self.pagamento.comprovante = '';
					    		self.pagamento.produtos = [];

					      	}, function (response) {
					          	swal(self.return.title, self.return.message, self.return.type);
					      	});
					    }
				    },
				})
			</script>

			<script type="text/javascript">
		        $('.moneySql').mask('000000.00', {reverse: true});
		        
			</script>

	    @stop

@stop