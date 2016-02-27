@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Despesa simples</h2><br>

<div id="contentProduto" class="row">

	<div class="col-md-7">

		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Informe os dados da despesa</h4>
			</div>
			<div class="panel-body">
				
				<form action="{{route('admin.financeiro.despesaStore')}}" method="POST" enctype="multipart/form-data">

					{!! csrf_field() !!}
				

					<div class="row">
						<div class="col-md-8">
							<div class="form-group">
								<label>Valor</label>
								<input type="text" name="valor" class="form-control moneySql" required/>
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label>Data despesa</label>
								<input type="text" name="data_pgto" class="form-control datepicker dataCompleta" required/>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label>Descrição</label>
						<input type="text" name="descricao" class="form-control"/>
					</div>

					<div class="form-group">
						<label>Fonte pagamento</label>
						<input type="text" name="fonte_pgto" class="form-control"/>
					</div>

					<div class="form-group">
						<label>Observações</label>
						<textarea type="textarea" class="form-control" name="observacoes"></textarea>
					</div>

					<div class="form-group">
						<label>Comprovante</label>
						<input type="file" name="comprovante" class="form-control"/>
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Cadastrar despesa</button>
					</div>

					
				</form>

			</div>
		</div>

	</div>

	<div class="col-md-5">
		<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Produtos</h4>
		</div>
		<div class="panel-body">
			
			<div class="row"  v-for="produto in produtos" track-by="$index" v-bind:value="produto">
				<div class="col-md-8">
					<div class="form-group" >
						<input type="text" class="form-control" v-model="produto.nome" placeholder="Produto">@{{index}}
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group" >
						<input type="text" class="form-control" v-model="produto.quantidade" placeholder="quantidade">
					</div>
				</div>
			</div>

			<label>Adiciona produto</label>
			<div class="row">
				<div class="col-md-8">

					<div class="form-group">
			            <select v-model="selected" class="form-control">
							<option v-for="produtoSelected in produtosForSelect" track-by="$index" v-bind:value="produtoSelected">@{{produtoSelected.nome}}</option>
						</select>
			        </div>
				</div>
				<div class="col-md-4">
					<div class="form-group" >
						<input type="text" class="form-control" :disabled="selected.nome == ''" v-model="selected.quantidade" placeholder="quantidade" id="quantidade">
					</div>
				</div>
			</div>

			<a class="btn btn-default btn-block" v-on:click="addProduto($event)">Adiciona</a>

			<pre>@{{ $data | json}}</pre>

		</div>


		</div>
	</div>
</div>

</div>


    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/financeiro.js') !!}"></script>

			<script type="text/javascript">
				$('.moneySql').mask('000000.00', {reverse: true});
			</script>

			<script type="text/javascript">

				Vue.config.debug = true;

				var vm = new Vue({
				    el: '#contentProduto',
				    data: {
				    	produtos: [],
				    	produtosForSelect: [],
				    	selected: {id: '', nome: '', quantidade: ''},
				    },

					    ready: function() {

					      // GET request
					      this.$http({url: '/admin/produtos/produtosForSelectJson', method: 'GET'}).then(function (response) {
					          this.produtosForSelect = response.data;
					      }, function (response) {
					          console.log(response);
					      });

					    },
					    watch: {
						    'selected': function () {
						      if(this.selected.nome != '') {
						      	$('#quantidade').removeAttr("disabled");
						      }
						    },
						  },
				    methods: {
				    	addProduto: function(ev, quantidade) {
				    		ev.preventDefault();
				    		this.produtos.push(this.selected);
				    		this.selected = '';
				    		$('#quantidade').attr("disabled", "true");
				    	},
				    },
				})

			</script>


	@stop

@stop