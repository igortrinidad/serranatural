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


		<div class="col-md-12">

			<div class="panel panel-default">
				<div class="panel-heading">Caixas</div>
				<div class="panel-body">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th class="text-center">Abertura</th>
										<th class="text-center">Fechamento</th>
										<th class="text-center">Venda total</th>
										<th class="text-center">Valor abertura</th>
										<th class="text-center">Usuario abertura</th>
										<th class="text-center">Cielo</th>
										<th class="text-center">Rede</th>
										<th class="text-center">Fundo de caixa</th>
										<th class="text-center">Usuario fechamento</th>
										<th class="text-center">Diferença total</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="caixa in caixas">
										<td class="text-center">@{{caixa.dt_abertura}}</td>
										<td class="text-center" v-if="caixa.dt_fechamento > '2010-10-10'">@{{caixa.dt_fechamento}}</td>
										<td class="text-center" v-if="caixa.dt_fechamento < '2010-10-10'">--</td>

										<td class="text-center">@{{caixa.vendas}}</td>
										<td class="text-center">R$ @{{caixa.vr_abertura}}</td>
										<td class="text-center" v-if="caixa.usuario_abertura">@{{caixa.usuario_abertura.name}}</td>
										<td class="text-center" v-if="!caixa.usuario_abertura">--</td>
										<td class="text-center">R$ @{{caixa.vendas_cielo}}</td>
										<td class="text-center">R$ @{{caixa.vendas_rede}}</td>
										<td class="text-center">R$ @{{caixa.vr_emCaixa}}</td>
										<td class="text-center" v-if="caixa.usuario_fechamento">@{{caixa.usuario_fechamento.name}}</td>
										<td class="text-center" v-if="!caixa.usuario_fechamento">--</td>
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
      	</div>

      	<div class="col-md-6">
      		<label>Usuário fechamento</label>
      		<p>@{{caixaSelected.caixa.usuario_fechamento.name}}</p>
      		<label>Volume de vendas</label>
      		<p>@{{caixaSelected.fetched.vendas_resumo.length}}</p>
      	</div>
      </div>
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
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
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
				    {
				    	caixas: [],
				    	retorno: [],
				    	caixaSelected: {
				    		caixa: {
				    			usuario_abertura: {name: ''},
				    			usuario_fechamento: {name: ''},
				    			vendas: 0,
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
					      	self.caixaSelected.caixa = caixa;

					      	$('#modalCaixaSelected').modal('show');

					      	this.$http.post('/admin/financeiro/historico/caixa/fetchVendasResume', caixa).then(function (response) {

					          	self.caixaSelected.fetched = response.data;

					          	console.log(self.caixaSelected);


							}, function (response) {

						      	console.log('Erro ao tentar carregar caixas.');

						    });
				    	}

					},
				});


			</script>

	    @stop

@stop