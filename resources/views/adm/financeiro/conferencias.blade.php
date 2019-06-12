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
<h2 class="text-right">Histórico de conferências</h2><br>

	@include('errors.messages')


		<div class="col-md-12">

			<div class="panel panel-default">
				<div class="panel-heading">Conferências</div>
				<div class="panel-body">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th class="text-center">Caixa ID</th>
										<th class="text-center">Abertura</th>
										<th class="text-center">Vendas</th>
										<th class="text-center">Valor abertura</th>
										<th class="text-center">Usuario abertura</th>
										<th class="text-center">Usuario conferencia</th>
										<th class="text-center">Vr em caixa</th>
										<th class="text-center">Diferença registrada</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="conferencia in conferencias">
										<td class="text-center">@{{conferencia.caixa_id}}</td>
										<td class="text-center">@{{conferencia.dt_abertura}}</td>
										<td class="text-center">@{{conferencia.vendas}}</td>
										<td class="text-center">R$ @{{conferencia.vr_abertura}}</td>
										<td class="text-center">@{{conferencia.usuario.name}}</td>
										<td class="text-center">@{{conferencia.usuario_conferencia.name}}</td>
										<td class="text-center">R$ @{{conferencia.vr_emCaixa}}</td>
										<td class="text-center" 
											v-bind:class="{ 'warning': conferencia.diferenca_final < 0, 'success': conferencia.diferenca_final >= 0 }">R$ @{{conferencia.diferenca_final}}</td>
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
				    	conferencias: [],
				    	retorno: [],
				    },
				    ready: function(){
				    	var self = this;	
				      	// GET request
				      	this.$http.get('/admin/financeiro/historico/conferencias/fetchAll').then(function (response) {
				          	self.conferencias = response.data.data;
				          	self.retorno = response.data.data.retorno;
				          	console.log(response.data);

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