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
							<table class="table table-bordered">
								<thead>
									<tr>
										<th class="text-center">Abertura</th>
										<th class="text-center">Usuario abertura</th>
										<th class="text-center">Fechamento</th>
										<th class="text-center">Usuario fechamento</th>
										<th class="text-center">Valor abertura</th>
										<th class="text-center">Venda total</th>
										<th class="text-center">Cielo</th>
										<th class="text-center">Rede</th>
										<th class="text-center">Fundo de caixa</th>
										<th class="text-center">Retirada total</th>
										<th class="text-center">Diferença total</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="caixa in caixas">
										<td class="text-center">@{{caixa.dt_abertura}}</td>
										<td class="text-center" v-if="caixa.usuario_abertura">@{{caixa.usuario_abertura.name}}</td>
										<td class="text-center" v-if="!caixa.usuario_abertura">--</td>
										<td class="text-center" v-if="caixa.dt_fechamento > '2010-10-10'">@{{caixa.dt_fechamento}}</td>
										<td class="text-center" v-if="caixa.dt_fechamento < '2010-10-10'">--</td>
										<td class="text-center" v-if="caixa.usuario_fechamento">@{{caixa.usuario_fechamento.name}}</td>
										<td class="text-center" v-if="!caixa.usuario_fechamento">--</td>
										<td class="text-center">R$ @{{caixa.vr_abertura}}</td>
										<td class="text-center">@{{caixa.vendas}}</td>
										<td class="text-center">R$ @{{caixa.vendas_cielo}}</td>
										<td class="text-center">R$ @{{caixa.vendas_rede}}</td>
										<td class="text-center">R$ @{{caixa.vr_emCaixa}}</td>
										<td class="text-center">R$ @{{caixa.total_retirada}}</td>
										<td class="text-center" v-on:click="mostraVendas(caixa)"
										v-bind:class="{ 'warning': caixa.diferenca_final < 0, 'success': caixa.diferenca_final >= 0 }">R$ @{{caixa.diferenca_final}}</td>
									</tr>
								</tbody>
							</table>
				</div>
			
			</div>
		</div>


		<!-- Modal -->
<div class="modal fade" id="modalCaixaSelected" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Caixa: @{{caixaSelected.caixa.id}}</h4>
      </div>
      <div class="modal-body">

      <div class="row">
      	<div class="col-md-6">
      		<label>Usuário abertura</label>
      		<p>@{{caixaSelected.caixa.usuario_abertura.name}}</p>
      		<label>Vendas total</label>
      		<p>R$ @{{caixaSelected.caixa.vendas}}</p>
      		<label>Ticket Médio</label>
      		<p>R$ @{{(caixaSelected.caixa.vendas / caixaSelected.fetched.vendas_resumo.length).toFixed(2)}}</p>
      		<label>Vendas rede</label>
      		<p>@{{caixaSelected.caixa.vendas_rede}}</p>
      		<label>Abertura</label>
      		<p>@{{caixaSelected.caixa.vr_abertura}}</p>
      	</div>

      	<div class="col-md-6">
      		<label>Usuário fechamento</label>
      		<p>@{{caixaSelected.caixa.usuario_fechamento.name}}</p>
      		<label>Volume de vendas</label>
      		<p>@{{caixaSelected.fetched.vendas_resumo.length}}</p>
      		<label>Vendas cielo</label>
      		<p>@{{caixaSelected.caixa.vendas_cielo}}</p>
      		<label>Total retiradas</label>
      		<p>@{{caixaSelected.caixa.total_retirada}}</p>
      		<label>Fundo de caixa</label>
      		<p>@{{caixaSelected.caixa.vr_emCaixa}}</p>
      	</div>

      	<div class="col-md-12 text-center">
      		<label>Diferença</label>
      		<p>R$ @{{ caixaSelected.caixa.diferenca_calculada }}</p>
      	</div>
      </div>

	    <hr size="3px" style="margin-top: 2px"/>

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

		<hr size="3px" style="margin-top: 2px"/>

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
		
      </div>
      <div class="modal-footer">
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
				    data: 
				    {	loading: false,
				    	caixas: [],
				    	retorno: [],
				    	caixaSelected: {
				    		caixa: {
				    			usuario_abertura: {name: ''},
				    			usuario_fechamento: {name: ''},
				    			vendas: 0,
				    			retiradas: [
				    				{valor: '', descricao: '', tipo: '', usuario: {name: ''}, funcionario: {nome: ''}}
				    			],
				    			diferenca_calculada: '',
				    		}, 
				    		fetched: {
				    			vendas_resumo: []
				    		}
				    		
				    	},
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
				    	mostraVendas: function(caixa){
					    	var self = this;	
					      	// GET request
					      	self.loading = true;
					      	if(!caixa.usuario_fechamento.id){
					      		return false;
					      	}
					      	self.caixaSelected.caixa = caixa;

					      	self.calcula();

					      	$('#modalCaixaSelected').modal('show');

					      	this.$http.post('/admin/financeiro/historico/caixa/fetchVendasResume', caixa).then(function (response) {

					          	self.caixaSelected.fetched = response.data;

					          	console.log(self.caixaSelected);
					          	self.loading = false;

					          	


							}, function (response) {
								self.loading = false;
						      	console.log('Erro ao tentar carregar caixas.');

						    });
				    	},
				    	calcula: function(){
				    		that = this;

				    		var retirada = that.caixaSelected.caixa.total_retirada;
				    		var abertura = that.caixaSelected.caixa.vr_abertura;
				    		var fundo = that.caixaSelected.caixa.vr_emCaixa;
				    		var cielo = that.caixaSelected.caixa.vendas_cielo;
				    		var rede = that.caixaSelected.caixa.vendas_rede;
				    		var vendas = that.caixaSelected.caixa.vendas;

				    		console.log(retirada + ' | ' + abertura + ' | '+ fundo + ' | '+ cielo + ' | '+ rede + ' | '+ vendas);

				    		that.caixaSelected.caixa.diferenca_calculada = 
				    		( parseFloat(fundo) + parseFloat(cielo) + parseFloat(rede) + parseFloat(retirada))
				    		-
				    		( parseFloat(vendas) + parseFloat(abertura) )
				    		;

				    		that.caixaSelected.caixa.diferenca_calculada = that.caixaSelected.caixa.diferenca_calculada.toFixed(2);
				    	}

					},
				});


			</script>

	    @stop

@stop