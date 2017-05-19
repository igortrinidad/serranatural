@extends('layout/admin')

@section('conteudo')

<style>
.success{
	background-color: #CDDC39!important;
	font-weight: 800;
}

.warning{
	background-color: #FF5722!important;
	font-weight: 800;
}
</style>

<div id="elHistoricoCaixa">
	<h2 class="text-right">Histórico de caixas</h2><br>

	@include('errors.messages')

	<div v-show="loading">
		@include('utils.loading-full')
	</div>


	<div class="col-md-12">

		<div class="panel panel-default">
			<div class="panel-heading">Caixas</div>
			<div class="panel-body">

				<div v-for="caixa in caixas" v-if="caixa.payments" track-by="$index">

					<div class="row" style="cursor: pointer" v-on:click="mostraVendas(caixa, $index)">
						<div class="col-md-4 col-xs-12">
							<div class="form-group">
							<label>Data abertura</label>
								<input class="form-control" v-model="caixa.dt_abertura | moment 'DD/MM/YYYY HH:mm:ss'" disabled>
							</div>
						</div>

						<div class="col-md-4 col-xs-12">
							<div class="form-group">
							<label>Responsável abertura</label>
								<input class="form-control" v-model="caixa.usuario_abertura.name" disabled>
							</div>
						</div>

						<div class="col-md-4 col-xs-12">
							<div class="form-group">
							<label>Valor abertura</label>
								<input class="form-control" v-model="caixa.payments.register_init_value" disabled>
							</div>
						</div>

						<div class="col-md-4 col-xs-12">
							<div class="form-group">
							<label>Responsável fechamento</label>
								<input class="form-control" v-model="caixa.usuario_fechamento.name" disabled>
							</div>
						</div>
						<div class="col-md-4 col-xs-12">
							<div class="form-group">
							<label>Data fechamento</label>
								<input class="form-control" v-model="caixa.dt_fechamento | moment 'DD/MM/YYYY HH:mm:ss'" disabled>
							</div>
						</div>

						<div class="col-md-4 col-xs-12">
							<div class="form-group">
							<label>Valor fechamento</label>
								<input class="form-control" v-model="caixa.payments.register_end_value" disabled>
							</div>
						</div>

						<div class="col-md-4 col-xs-12">
							<div class="form-group">
							<label>Retiradas total</label>
								<input class="form-control" v-model="caixa.total_retirada" disabled>
							</div>
						</div>
						<div class="col-md-4 col-xs-12">
							<div class="form-group">
							<label>Venda total</label>
								<input class="form-control" v-model="caixa.vendas" disabled>
							</div>
						</div>

						<div class="col-md-4 col-xs-12">
							<div class="form-group">
							<label>Diferença</label>
								<input class="form-control" v-model="caixa.diferenca_final" disabled v-bind:class="{ 'warning': caixa.diferenca_final < 0, 'success': caixa.diferenca_final >= 0 }">
							</div>
						</div>
					</div>
					
					<table class="table table-bordered">
					    <thead>
					        <tr>
					            <th>Vendas total dinheiro</th>
					            <th>Vendas total cartão</th>
					            <th>Contas aberto total</th>
					            <th v-for="item in caixa.payments.items">@{{item.label}}</th>
					        </tr>
					    </thead>
					    <tbody>
					        <tr v-if="caixa.payments">
					            <td >R$ @{{caixa.payments.total_money.toFixed(2)}}</td>
					            <td>R$ @{{caixa.payments.total_cards.toFixed(2)}}</td>
					            <td>R$ @{{caixa.contas.total}}</td>
					            <td v-for="item in caixa.payments.items">R$ @{{item.value}}</td>
					        </tr>
					    </tbody>
					</table>

					<hr line-height="3px">
				</div>

			</div>
		
		</div>
	</div>


		<!-- Modal -->
<div class="modal fade" id="modalCaixaSelected" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Caixa: @{{caixaSelected.caixa.id}}</h4>
      </div>
      <div class="modal-body">

		<!-- DETALHES CAIXA -->
	    <div class="row">
	     	<div class="col-md-12 col-xs-12">
		     	<fieldset>
		     		<legend>Detalhes caixa</legend>
			      	<div class="col-md-6">
			      		<label>Data abertura</label>
			      		<p>@{{caixaSelected.caixa.dt_abertura | moment 'DD/MM/YYYY HH:mm:ss'}}</p>
			      	</div>
			      	<div class="col-md-6">
			      		<label>Data fechamento</label>
			      		<p>@{{caixaSelected.caixa.dt_fechamento | moment 'DD/MM/YYYY HH:mm:ss'}}</p>
			      	</div>
			      	<div class="col-md-6">
			      		<label>Responsável abertura</label>
			      		<p>@{{caixaSelected.caixa.usuario_abertura.name}}</p>
			      	</div>
			      	<div class="col-md-6">
			      		<label>Responsável fechamento</label>
			      		<p>@{{caixaSelected.caixa.usuario_fechamento.name}}</p>
			      	</div>
			      	<div class="col-md-4">
			      		<p>Valor abertura</p>
			      		<h3 v-if="!isEditing">@{{caixaSelected.caixa.payments.register_init_value}}</h3>
			      		<input v-if="isEditing" class="form-control" v-model="caixaSelected.caixa.payments.register_init_value" @blur="calcula()">
			      	</div>

			      	<div class="col-md-4">
			      		<p>Valor fechamento</p>
						<h3 v-if="!isEditing">@{{caixaSelected.caixa.payments.register_end_value}}</h3>
						<input v-if="isEditing" class="form-control" v-model="caixaSelected.caixa.payments.register_end_value" @blur="calcula()">
			      	</div>

			      	<div class="col-md-4">
			      		<p>Vendas no caixa</p>
						<h3>@{{caixaSelected.fetched.vendaBruta}}</h3>
			      	</div>
					
					<div class="col-md-4" v-for="payment in caixaSelected.caixa.payments.items">
						<p>@{{payment.label}}</p>
						<h3 v-if="!isEditing">R$ @{{payment.value}}</h3>
						<input v-if="isEditing" class="form-control" v-model="payment.value" @blur="calcula()">

					</div>

					<div class="col-md-6">
			      		<p>Diferença final</p>
						<h3>R$ @{{ caixaSelected.caixa.diferenca_final }}</h3>
			      	</div>

			      	<div class="col-md-12">
			      		<label>Observações</label>
			      		<p>@{{{ caixaSelected.caixa.obs }}}</p>
			      	</div>

		      	</fieldset>
	     	</div>
	    </div>

		<!-- RETIRADAS -->
		<div class="row">
			<div class="col-md-12 col-xs-12">

				<fieldset>
					<legend>Retiradas</legend>
				    <table class="table table-bordered table-striped">
					    <thead>
					        <tr>
					            <th>Valor</th>
					            <th>Tipo</th>
					            <th>Descrição</th>
					            <th>Quem fez?</th>
					            <th>Para quem?</th>
					        </tr>
					    </thead>
					    <tbody>
					        <tr v-for="retirada in caixaSelected.caixa.retiradas">
					            <td>@{{retirada.valor}}</td>
					            <td>@{{retirada.tipo}}</td>
					            <td>@{{retirada.descricao}}</td>
					            <td>@{{retirada.usuario.name}}</td>
					            <td v-if="retirada.funcionario">@{{retirada.funcionario.nome}}</td>
					            <td v-if="!retirada.funcionario">--</td>
					        </tr>
					    </tbody>
					</table>
				</fieldset>
				
			</div>
		</div>

		<!-- CONTAS EM ABERTO -->
		<div class="row">
			<div class="col-md-12 col-xs-12">

				<fieldset>
					<legend>Contas em aberto</legend>
				    <table class="table table-bordered table-striped">
					    <thead>
					        <tr>
					            <th>Data</th>
					            <th>Cliente</th>
					            <th>Telefone</th>
					            <th>Valor</th>
					            <th>Quem autorizou?</th>
					        </tr>
					    </thead>
					    <tbody v-if="caixaSelected && caixaSelected.caixa.contas">
					        <tr v-for="conta in caixaSelected.caixa.contas.contas_abertas | orderBy 'cliente'">
					            <td>@{{conta.data_init}}</td>
					            <td>@{{conta.cliente}}</td>
					            <td>@{{conta.telefone}}</td>
					            <td>@{{conta.valor}}</td>
					            <td>@{{conta.usuario}}</td>
					        </tr>
					    </tbody>
					</table>
				</fieldset>
				
			</div>
		</div>

		<!-- CONTAS PAGAS -->
		<div class="row">
			<div class="col-md-12 col-xs-12">

				<fieldset>
					<legend>Contas liquidadas</legend>
				    <table class="table table-bordered table-striped">
					    <thead>
					        <tr>
					            <th>Data</th>
					            <th>Cliente</th>
					            <th>Valor</th>
					            <th>Quem autorizou entrada?</th>
					            <th>Quem autorizou baixa?</th>
					        </tr>
					    </thead>
					    <tbody v-if="caixaSelected.caixa.contas && caixaSelected.caixa.contas">
					        <tr v-for="conta in caixaSelected.caixa.contas.contas_pagas">
					            <td>@{{conta.data_pay}}</td>
					            <td>@{{conta.cliente}}</td>
					            <td>@{{conta.valor}}</td>
					            <td>@{{conta.usuario}}</td>
					            <td>@{{conta.usuario_pay}}</td>
					        </tr>
					    </tbody>
					</table>
				</fieldset>
				
			</div>
		</div>

		<!-- VENDAS REALIZADAS -->
		<div class="row">
			<div class="col-md-12 col-xs-12">
				<fieldset>
					<legend>Vendas realizadas neste caixa</legend>

				    <table class="table table-bordered">
						<thead>
							<tr>
								<th>Valor</th>
								<th>Data</th>
								<th>Ver conta</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="venda in caixaSelected.fetched.vendas_resumo">
								<td >R$ @{{(venda.valor/100).formatMoney(2, ',', '.')}}</td>
								<td>@{{venda.data}}</td>
								<td><a href="@{{venda.url}}" target="_blank">Ver recibo</td>
							</tr>
							<tr>
								<td colspan="2">Total de vendas</td>
								<td>@{{ caixaSelected.fetched.vendas_resumo.length }}</td>
							</tr>

						</tbody>
					</table>
					
				</fieldset>
			</div>
		</div>

		<!-- REABRIR CAIXA -->
		<div class="row">
	      	<div class="col-md-12">
	      		<fieldset>
	      			<legend>Reabrir caixa</legend>
	  				<form method="post" action="/admin/financeiro/caixa/reabreCaixa/@{{caixaSelected.caixa.id}}">
						{!! csrf_field() !!}

						<div class="form-group">
							<label>Senha</label>
							<input type="password" name="senha" class="form-control"/>
						</div>

						<button type="submit" class="btn btn-danger btn-block">Reabrir caixa</button>

					</form>
				</fieldset>
	      	</div>
      	</div>
		
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" @click="showEditCaixa()" v-show="!isEditing" :disabled="user_type != 'super_adm'">Editar caixa</button>
        <button type="button" class="btn btn-danger" @click="salva()" v-show="isEditing">Salvar alterações</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

</div>


    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/financeiro.js') !!}"></script>

			<script type="text/javascript">

				$('.maskValor').mask("0000.00", {reverse: true});

				Vue.config.debug = true;
				Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#_tokenLaravel').getAttribute('value');

				var vm = new Vue({
				    el: '#elHistoricoCaixa',
				    data: {
				    	isEditing: false,
				    	loading: false,
				    	caixas: [],
				    	retorno: [],
				    	user_type: '{{Auth::user()->user_type}}',
				    	caixaSelected: {
				    		caixa: {
					    		senha: '', 
					    		senha_conferente: '',
					    		contas: {
				    				contas_abertas: [],
				    				contas_pagas: [],
				    				total: 0,
					    		},
					    		payments: {
					    			register_init_value: 0,
					    			register_end_value: 0,
					    			total_money: 0,
					    			total_cards: 0,
					    			total_accounts: 0,
					    			total: 0,
					    			items: [
					    			{
						    			label: 'Ticket',
						    			value: 0
						    		},
						    		{
						    			label: 'Stone',
						    			value: 0
						    		},
						    		{
						    			label: 'Rede',
						    			value: 0
						    		},
						    		{
						    			label: 'iFood',
						    			value: 0
						    		},
						    		{
						    			label: 'Cielo',
						    			value: 0
						    		},
						    		]
						    	},
						    	usuario_abertura: {name: ''},
						    	usuario_fechamento: {name: ''}
				    		}, 
				    		fetched: {
				    			vendaBruta: '0',
				    			vendas_resumo: []
				    		}	
				    	},
				    	caixaAnterior: {
				    		caixa: {
					    		senha: '', 
					    		senha_conferente: '',
					    		contas: {
				    				contas_abertas: [],
				    				contas_pagas: [],
				    				total: 0,
					    		},
					    		payments: {
					    			register_init_value: 0,
					    			register_end_value: 0,
					    			total_money: 0,
					    			total_cards: 0,
					    			total_accounts: 0,
					    			total: 0,
					    			items: [
					    			{
						    			label: 'Ticket',
						    			value: 0
						    		},
						    		{
						    			label: 'Stone',
						    			value: 0
						    		},
						    		{
						    			label: 'Rede',
						    			value: 0
						    		},
						    		{
						    			label: 'iFood',
						    			value: 0
						    		},
						    		{
						    			label: 'Cielo',
						    			value: 0
						    		},
						    		]
						    	},
						    	usuario_abertura: {name: ''},
						    	usuario_fechamento: {name: ''}
				    		}, 
				    		fetched: {
				    			vendaBruta: '0',
				    			vendas_resumo: []
				    		}	
				    	},
				    },

				    filters: {
				    	moment: {
				    		read: function(val, format){
				    			return moment(val).format(format)
				    		}
				    	}
				    },

				    ready: function(){
				    	var self = this;	
				      	// GET request
				      	this.$http.get('/admin/financeiro/historico/caixa/fetchAll').then(function (response) {
				          	self.caixas = response.data.caixas;
				          	self.retorno = response.data.retorno;
				          	console.log('Caixas carregados com sucesso.');

						}, function (response) {

					      	console.log('Erro ao tentar carregar caixas.');

					    });
				    },
				    methods:
				    {	
				    	showEditCaixa: function(){
				    	    let that = this
				    		
				    		this.isEditing = true;
				    	    
				    	},
				    	mostraVendas: function(caixa, index){
					    	var self = this;	
					      	// GET request
					      	
					      	if(caixa.usuario_fechamento){

					      		self.loading = true;

					      		self.caixaSelected.caixa = caixa;
					      		self.$set('caixaAnterior', this.caixas[index+1]);

						      	$('#modalCaixaSelected').modal('show');

						      	this.$http.post('/admin/financeiro/historico/caixa/fetchVendasResume', caixa).then(function (response) {

						          	self.caixaSelected.fetched = response.data;

						          	console.log(self.caixaSelected);
						          	self.loading = false;
						          	self.calcula();

								}, function (response) {
									self.loading = false;
							      	console.log('Erro ao tentar carregar caixas.');

							    });
					      	}
					      	
				    	},
				    	calcula: function(ev) {
				    		var that = this
				    		this.substracted = false;

				    		var totalPayments = 0;

				    		that.caixaSelected.caixa.payments.items.forEach(function(payment){
				    			if(isNaN(payment.value) || !payment.value){
				    				payment.value = 0;
				    			}
				    			totalPayments += parseFloat(payment.value);

				    		});

				    		if (!that.caixaSelected.caixa.payments.register_end_value || isNaN(that.caixaSelected.caixa.payments.register_end_value)) that.caixaSelected.caixa.payments.register_end_value = 0;

				    		that.caixaSelected.caixa.payments.total_cards = totalPayments;
				    		that.caixaSelected.caixa.payments.total_money = parseFloat(that.caixaSelected.caixa.payments.register_end_value) + 
				    			parseFloat(that.caixaSelected.caixa.total_retirada) -
				    			parseFloat(that.caixaSelected.caixa.payments.register_init_value);
				    		that.caixaSelected.caixa.payments.total_accounts = parseFloat(that.caixaSelected.caixa.contas.total) - parseFloat(that.caixaAnterior.contas.total);

				    		var conferencia1 = 
				    			( parseFloat( that.caixaSelected.caixa.payments.register_end_value )
				    			+ parseFloat( that.caixaSelected.caixa.total_retirada ) 
				    			- (parseFloat( that.caixaSelected.caixa.payments.register_init_value) + parseFloat( that.caixaAnterior.contas.total ) ) );

				    		var conferencia2 = parseFloat( that.caixaSelected.fetched.vendaBruta.replace(',', '') ) - (totalPayments + parseFloat( that.caixaSelected.caixa.contas.total )); 

				    		var diferenca = (conferencia1) - (conferencia2);

				    		console.log('Conferencia 1: ' + conferencia1);
				    		console.log('Conferencia 2: ' + conferencia2);
				    		console.log(': ' + diferenca);

					    	that.caixaSelected.caixa.diferenca_final = diferenca.toFixed(2);
					    	that.caixaSelected.caixa.vendas = that.caixaSelected.fetched.vendaBruta.replace(',', '');
				    	},

				    	salva: function() {
				    		var that = this;

				    		if(!this.loading){

				    			this.loading = true;

					    		this.calcula();

					    		this.$http.post('/admin/financeiro/caixa/update', this.caixaSelected.caixa).then(function (response) {
								       swal(response.data.retorno.title, response.data.retorno.message, response.data.retorno.type);

								       setTimeout(function()
									    {
									    	location.reload();
									    }, 3000);
								       that.isEditing = false;
								       that.loading = false;

								    }, function (response) {

								      	console.log('Erro ao tentar fechar o caixa.');

								      	swal('ERRO', 'ERRO AO SALVAR O CAIXA! TENTE NOVAMENTE E VERIFIQUE SE O CAIXA FOI FECHADO. INFORME AO ASSISTÊNCIA.', 'error');
								      	that.authorization = false;
								      	that.loading = false;
								    });
				    		}

				    	},

					},
				});


			</script>

	    @stop

@stop