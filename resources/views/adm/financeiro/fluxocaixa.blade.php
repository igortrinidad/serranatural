@extends('layout/admin')

@section('conteudo')

<style>
.success{
	background-color: #CDDC39;
}

.warning{
	background-color: #FF5722;
}
</style>

<h2 class="text-right">Controle de caixa</h2><br>

<div id="contentCaixa">

	<div class="row">

		<div class="col-md-6" v-if="!caixa_is_aberto">
			<div class="panel panel-default">
				<div class="panel-heading">Caixa - <strong><span v-if="abrir_caixa.turno == 1">Primeiro</span><span v-else>Segundo</span> turno</strong></div>
				<div class="panel-body">

					<div class="well text-center">
						<p><strong>Fundo de caixa anterior</strong></p>
						<p><strong>R$ @{{caixa_anterior.vr_emCaixa}} </strong></p>
					</div>

					<div class="form-group">
						<label>Contagem do caixa atual</label>
						<input class="form-control" type="text" v-model="abrir_caixa.valor"/>
					</div>

					<div class="form-group">
						<label>Senha</label>
						<input class="form-control" type="password" v-model="abrir_caixa.senha"/>
					</div>

					<button class="btn btn-primary btn-block" :disabled="! abrir_caixa.valor || ! abrir_caixa.senha" v-on:click="abreCaixa()">Abrir caixa</button>

				</div>

			</div>	
		</div>
	</div>

	<div class="row">

		<div v-if="caixa_is_aberto == true">

			<div class="row">
				<div class="col-md-3">
					<div class="well text-center">
						<h2>R$ @{{caixa_aberto.vr_abertura}}</h2>
						<p>Valor de abertura</p>
					</div>
				</div>

				<div class="col-md-3">
					<div class="well text-center">
						<h2>R$ @{{vendas.venda_dia}}</h2>
						<p>Vendas sistema</p>
					</div>
				</div>

				<div class="col-md-3">
					<div class="well text-center">
						<h2>R$ @{{caixa_aberto.total_retirada}}</h2>
						<p>Total retiradas</p>
					</div>
				</div>

				<div class="col-md-3">
					<div class="well text-center" 
						v-bind:class="{ 'warning': caixa_aberto.diferenca_final < 0, 'success': caixa_aberto.diferenca_final >= 0 }"
					>
						<h2>R$ @{{caixa_aberto.diferenca_final}}</h2>
						<p>Diferença</p>
					</div>
				</div>	

				<div class="col-md-3">
					<div class="well text-center">
						<h2>R$ @{{vendas.taxa_dia}}</h2>
						<p>Taxa recolhida</p>
					</div>
				</div>

				<div class="col-md-3" v-if="caixa_aberto.turno == 2">
					<div class="well text-center">
						<h2>R$ @{{caixa_anterior.vendas_rede}}</h2>
						<p>Venda Rede Anterior</p>
					</div>
				</div>	

				<div class="col-md-3" v-if="caixa_aberto.turno == 2">
					<div class="well text-center">
						<h2>R$ @{{caixa_anterior.vendas_cielo}}</h2>
						<p>Venda Cielo Anterior</p>
					</div>
				</div>	


			</div>

			<hr size="3px" style="margin-top: 2px"/>

			<div class="row">
				
				<div class="col-md-8">
					<div class="panel panel-default">
						<div class="panel-heading">Caixa</div>
						<div class="panel-body">

							<div class="col-md-6">
								<div class="form-group">
									<label>Total de venda maquina REDE</label>
									<input type="text" class="form-control moneyInteger" 
										v-on:keyup="calcula($event)"
										v-model="caixa_aberto.vendas_rede"

									/>
								</div>

								<div class="form-group">
									<label>Total de venda maquina CIELO</label>
									<input type="text" class="form-control moneyInteger" 
										v-model="caixa_aberto.vendas_cielo"
										v-on:keyup="calcula($event)"
									/>
								</div>
								
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Dinheiro em caixa</label>
									<input type="text" class="form-control moneyInteger" 
										v-model="caixa_aberto.vr_emCaixa"
										v-on:keyup="calcula($event)"
									/>
								</div>
							</div>

						</div>
					</div>

					
				</div>

				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading">Ações</div>
						<div class="panel-body">
							<button class="btn btn-default btn-block" v-on:click="update($event)">Salvar</button>
							<br>
							<div class="form-group">
								<label>Senha</label>
								<input class="form-control" type="password" v-model="caixa_aberto.senha"/>
							</div>
							<button class="btn btn-primary btn-block" v-on:click="fecha($event)">Fechar caixa</button>

						</div>

					</div>

					<div class="panel panel-default">
						<div class="panel-heading">Retiradas</div>
						<div class="panel-body">
							<table class="table">
							    <thead>
							        <tr>
							            <th>Descrição</th>
							            <th>Valor</th>
							        </tr>
							    </thead>
							    <tbody>
							        <tr v-for="retirada in retiradas">
							            <td>@{{retirada.descricao}}</td>
							            <td>R$ @{{retirada.valor}}</td>
							        </tr>
							    </tbody>
							</table>

							<a href="/admin/financeiro/retirada" class="btn btn-primary btn-block">Fazer retirada</a>

						</div>

					</div>
				</div>
			</div>

		</div>

	</div>

<pre> @{{ $data | json }}</pre>

</div>
	

    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/financeiro.js') !!}"></script>

	        <script src="{!! elixir('js/financeiro.js') !!}"></script>

			<script type="text/javascript">

				//$('.maskValor').mask("0000.00", {reverse: true});

				Vue.config.debug = true;
				Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#_tokenLaravel').getAttribute('value');
				var vm = new Vue({
				    el: '#contentCaixa',
				    data: {
				    	retorno: '',
				    	caixa_aberto: {senha: ''},
				    	caixa_anterior: '',
				    	caixa_is_aberto: false,
				    	vendas: {
				    		venda_dia: '',
				    		taxa_dia: ''
				    	},
				    	abrir_caixa: {
				    		valor: '',
				    		senha: '',
				    		turno: 'primeiro',
				    	}
				    },
				    attached: function()
    					{
        					
    					},
					    ready: function() {
				 	      	var self = this;	
					      	// GET request
					      	this.$http.get('/admin/financeiro/caixa/consulta').then(function (response) {

					          if(response.data.caixa_aberto != null) {

					          	self.caixa_aberto = response.data.caixa_aberto;
					          	self.caixa_anterior = response.data.caixa_anterior;
					          	self.caixa_is_aberto = true;
					          	self.retiradas = response.data.retiradas;

					          	this.$http.get('/admin/financeiro/caixa/consultaVendas').then(function (response) {
							        self.vendas.venda_dia = response.data.venda_dia;
							        self.vendas.taxa_dia = response.data.taxa_dia;
							        self.vendas.begin_time = response.data.begin_time;
							        self.vendas.end_time = response.data.end_time;
							        self.caixa_aberto.vendas = self.vendas.venda_dia;

							    }, function (response) {
							      	console.log('Erro ao tentar buscar vendas.');
							    });

					          } else if(response.data.caixa_anterior != null) {

					          	self.caixa_anterior = response.data.caixa_anterior;
					          	self.caixa_is_aberto = false;

					          }

					          self.abrir_caixa.turno = response.data.turno;

					          

					      }, function (response) {
					      	console.log('Erro ao tentar buscar caixa.');
					        console.log(response.data);
					        self.caixa_ = response.data.retorno;
					      });

					      	setTimeout(function()
								    {
								    	location.reload();
								    }, 180000);

					    },
				    methods: {
				    	abreCaixa: function(ev) {
				    		self = this;

				    		this.$http.post('/admin/financeiro/caixa/abreCaixa', self.abrir_caixa).then(function (response) {

				    				console.log('Caixa aberto com sucesso.');

				    				swal(response.data.retorno.title, response.data.retorno.message, response.data.retorno.type);

				    				setTimeout(function()
								    {
								    	location.reload();
								    }, 2200);

							    }, function (response) {
							      	console.log('Erro ao abrir o caixa');
							      	console.log(response.data);

							      	swal(response.data.retorno.title, response.data.retorno.message, response.data.retorno.type);
							    });

				    	},
				    	update: function(ev) {
				    		ev.preventDefault();

				    		this.$http.post('/admin/financeiro/caixa/update', this.caixa_aberto).then(function (response) {
							       swal(response.data.retorno.title, response.data.retorno.message, response.data.retorno.type);

							    }, function (response) {
							      	console.log('Erro ao tentar salvar.');
							    });

				    	},
				    	fecha: function(ev) {
				    		ev.preventDefault();

				    		this.$http.post('/admin/financeiro/caixa/fecha', this.caixa_aberto).then(function (response) {
							       swal(response.data.retorno.title, response.data.retorno.message, response.data.retorno.type);

							       setTimeout(function()
								    {
								    	location.reload();
								    }, 2200);

							    }, function (response) {

							      	console.log('Erro ao tentar fechar o caixa.');

							      	swal(response.data.retorno.title, response.data.retorno.message, response.data.retorno.type);
							    });

				    	},
				    	calcula: function(ev) {
				    		
				    		var conferencia1 = ( parseFloat(this.caixa_aberto.vr_emCaixa) + parseFloat(this.caixa_aberto.total_retirada) - (parseFloat(this.caixa_aberto.vr_abertura)));

				    		var conferencia2 = (parseFloat(this.vendas.venda_dia) + parseFloat(this.vendas.taxa_dia)) -
				    		(parseFloat(this.caixa_aberto.vendas_cielo) + parseFloat(this.caixa_aberto.vendas_rede)); 

				    		var diferenca = (conferencia1) - (conferencia2);

					    	this.caixa_aberto.diferenca_final = parseFloat(diferenca).toFixed(2);
				    	},
				    	addProduto: function(ev, quantidade) {
				    		ev.preventDefault();
				    		if( ! this.selected.nome  || ! this.selected.quantidade ) {
				    			return false;
				    		}
				    		Produto = {id: this.selected.id, nome: this.selected.nome, quantidade: this.selected.quantidade};
				    		this.pagamento.produtos.push(Produto);
				    		this.selected = {id: '', nome: '', quantidade: ''};
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
		        $('.moneyInteger').mask('000000', {reverse: true});
		        
			</script>

	    @stop

@stop