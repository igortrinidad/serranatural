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
										<th class="text-center">Fundo de caixa</th>
										<th class="text-center">Usuario fechamento</th>
										<th class="text-center">Diferença total</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="caixa in caixas">
										<td class="text-center">@{{caixa.dt_abertura}}</td>
										<td class="text-center" v-if="caixa.dt_fechamento > '2010-10-10'">@{{caixa.dt_fechamento}}</td>

										<td class="text-center">@{{caixa.vendas}}</td>
										<td class="text-center">R$ @{{caixa.vr_abertura}}</td>
										<td class="text-center">@{{caixa.usuario_abertura.name}}</td>
										<td class="text-center">R$ @{{caixa.vr_emCaixa}}</td>
										<td class="text-center" v-if="caixa.usuario_fechamento">@{{caixa.usuario_fechamento.name}}</td>
										<td class="text-center" v-if="!caixa.usuario_fechamento">--</td>
										<td class="text-center" 
										v-bind:class="{ 'warning': caixa.diferenca_final < 0, 'success': caixa.diferenca_final >= 0 }">R$ @{{caixa.diferenca_final}}</td>
									</tr>
								</tbody>
							</table>
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
				    	

					},
				});


			</script>

	    @stop

@stop