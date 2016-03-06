@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Balanço semanal</h2><br>

<div id="contentBaixa" class="row">


	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Lista de balanços</h4>
			</div>
			<div class="panel-body">

				<table class="table table-bordered table-hover table-striped">
				    <thead>
				        <tr>
				            <th>ID</th>
				            <th>Data</th>
				            <th>Usuario</th>
				            <th>Porcentagem</th>
				        </tr>
				    </thead>
				    <tbody v-for="balanco in listaBalancos">
				        <tr>
				        	<td>@{{balanco.id}}
				        	<td>@{{balanco.created_at}}
				            <td>@{{balanco.user_id}}</td>
				            <td>@{{balanco.finished}}%</td>
				        </tr>
				        <tr>
				            <th>Nome Produto</th>
				            <th>Quantidade esperada</th>
				            <th>Quantidade real</th>
				            <th>Diferença</th>
				        </tr>
				        <tr v-for="produto in balanco['lista']" track-by="$index">
							<td colspan="1"> @{{produto.nome}} </td>
							<td colspan="1"> @{{produto.quantidadeEstoque}} </td>
							<td colspan="1"> @{{produto.quantidadeReal}} </td>
							<td colspan="1"> @{{produto.diferenca}} </td>
				        </tr>
				        <tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
				        </tr>
				    </tbody>
				</table>

			</div>

		</div>

	</div>

</div>

    @section('scripts')
	    @parent

			<script type="text/javascript">

				Vue.config.debug = true;
				Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#_tokenLaravel').getAttribute('value');
				Vue.http.headers.common['Content-Type'] = 'application/json';

				var vm = new Vue({
				    el: '#contentBaixa',
				    data: {
			    		listaBalancos: '',
				    	return: '',
				    },
				    attached: function()
    					{

    						$(this.$els.produtoQtdeEstoque).mask('000.00', {reverse: true});
    						$(this.$els.produtoQtdeReal).mask('000.00', {reverse: true});
    						$(this.$els.produtoDiferenca).mask('000.00', {reverse: true});
        					
    					},
					    ready: function() {
				 	      	var self = this;	
					      	// GET request
					      	this.$http.get('/admin/produtos/historico/balancosJson').then(function (response) {

					        self.listaBalancos = response.data;

					        //console.log(JSON.parse(self.listaBalancos));

					      }, function (response) {
					          console.log(response);
					      });
					    },
				    methods: {
				    	

				    },
				})
			</script>


	@stop

@stop