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

<h2 class="text-right">Balanço semanal</h2><br>

<div id="contentBaixa" class="row">


	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Lista de balanços</h4>
			</div>
			<div class="panel-body">

				<div v-for="balanco in listaBalancos">
					
					<table class="table table-bordered table-hover table-striped">
					    <thead>
					        <tr>
					            <th>ID balanço</th>
					            <th>Data</th>
					            <th colspan="3">Usuario</th>
					            <th>Porcentagem</th>
					        </tr>
					    </thead>
					    <tbody >
					        <tr>
					        	<td>@{{balanco.id}}
					        	<td>@{{ balanco.created_at }}
					            <td colspan="3">@{{balanco.usuario ? balanco.usuario.name : 'Usuário não localizado'}}</td>
					            <td>@{{balanco.finished}}%</td>
					        </tr>
					        <tr>
					            <th>Nome Produto</th>
					            <th>Validade</th>
					            <th>Quantidade esperada</th>
					            <th>Quantidade venda</th>
					            <th>Quantidade real</th>
					            <th>Diferença</th>
					        </tr>
					        <tr v-for="produto in balanco['lista']" track-by="$index">
								<td colspan="1"> @{{produto.nome}} </td>
								<td colspan="1"> @{{produto.validade}} </td>
								<td colspan="1"> @{{produto.quantidadeEstoque}} </td>
								<td colspan="1"> @{{produto.venda}} </td>
								<td colspan="1"> @{{produto.quantidadeReal}} </td>
								<td colspan="1" v-bind:class="{ 'warning': produto.diferenca < 0, 'success': produto.diferenca >= 0 }"> @{{produto.diferenca}} </td>

					        </tr>
					    </tbody>
					</table>

				</div>

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