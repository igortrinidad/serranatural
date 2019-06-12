@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Entrada no estoque</h2><br>

<div id="contentBaixa" class="row">


	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Produtos</h4>
			</div>
			<div class="panel-body">
				<h5>Lista de Produtos</h5>
				
				<div class="row"  v-for="produto in produtos.produtos" track-by="$index" v-bind:value="produto">
					<div class="col-md-4">
						<div class="form-group" >
							<label>Produto</label>
							<input type="text" class="form-control" v-model="produto.nome" placeholder="Produto" disabled>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group" >
							<label>Quantidade</label>
							<input type="text" class="form-control moneySql5" v-model="produto.quantidade" placeholder="Quantidade" >
						</div>
					</div>

					<div class="col-md-2">
						<div class="form-group" >
							<label>Valor unitário</label>
							<input type="text" class="form-control moneySql5" v-model="produto.valor" placeholder="Valor" >
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group" >
							<label>Motivo da baixa</label>
							<input type="text" class="form-control" v-model="produto.observacao"  placeholder="Observacao" >
						</div>
					</div>
				</div>

				<hr size="3px"></hr>

				<h5>Adiciona produtos</h5>
				<div class="row">
					<div class="col-md-4">

						<div class="form-group">
							<label>Produtos</label>
				            <select v-model="selected" class="form-control" id="produtos">
								<option 
									v-for="produtoSelected in produtosForSelect" 
									track-by="$index" 
									v-bind:value="produtoSelected" 
								>@{{produtoSelected.nome}}</option>
							</select>
				        </div>
					</div>
					<div class="col-md-2">
						<div class="form-group" >
							<label>Quantidade</label>
							<input type="text" class="form-control moneySql5" :disabled="! selected.nome" v-model="selected.quantidade" >
						</div>
					</div>

					<div class="col-md-2">
						<div class="form-group" >
							<label>Valor unitário</label>
							<input type="text" class="form-control moneySql5" v-model="selected.valor" :disabled="! selected.nome" placeholder="Valor unitário" >
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group" >
							<label>Observações</label>
							<input type="text" class="form-control" :disabled="! selected.nome" v-model="selected.observacao" placeholder="observações">
						</div>
					</div>
				</div>

				<a 
					class="btn btn-primary btn-block" 
					:disabled="!selected.nome || !selected.quantidade" 
					v-on:click="addProduto($event)"
				>Adiciona</a>
<br>
				<a 
					v-if="produtos != ''"
					class="btn btn-success btn-block" 
					:disabled="!produtos.produtos.length"
					v-on:click="confirmaEntrada($event)"
				>Salvar</a>
				
				<br><br>

			</div>

		</div>

	</div>
	<br><br><br>
</div>

</div>


    @section('scripts')
	    @parent

			<script type="text/javascript">

				$('.moneySql3').mask('000.00', {reverse: true});

				Vue.config.debug = true;
				Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#_tokenLaravel').getAttribute('value');
				Vue.http.headers.common['Content-Type'] = 'application/json';

				var vm = new Vue({
				    el: '#contentBaixa',
				    data: {
				    	produtos: {
				    		produtos: [],
				    	},
				    	return: '',
				    	produtosForSelect: [],
				    	selected: {id: '', nome: '', quantidade: '', observacao: '', valor: 0},
				    },

				    attached: function()
    					{

    						$(this.$els.produtoQuantidade).mask('000.000', {reverse: true});
        					
    					},
					    ready: function() {
				 	      	var self = this;	
					      	// GET request
					      	this.$http.get('/admin/produtos/produtosForSelectJson/trackeds').then(function (response) {
					          	self.produtosForSelect = response.data;
					      	}, function (response) {
					          console.log(response);
					      	});

					      	$('.moneySql5').mask('00000.000', {reverse: true});
					    },
				    methods: {
				    	addProduto: function(ev, quantidade) {
				    		ev.preventDefault();

				    		this.produtos.produtos.push(JSON.parse(JSON.stringify(this.selected)));
				    		this.selected = {id: '', nome: '', quantidade: ''};
				    	},
				    	confirmaEntrada: function(ev) {
				    		ev.preventDefault();
				    		if( this.produtos.produtos == '') {
				    			return false;
				    		}
				    		self = this;
				    		swal({   
				    				title: "Entrada no estoque!",
				    				text: "Essa alteração não poderá ser desfeita",
				    				type: "warning",
				    				showCancelButton: true,
				    				cancelButtonText: "Cancelar",
				    				confirmButtonColor: "#DD6B55",
				    				confirmButtonText: "Sim, tenho certeza!",
				    				closeOnConfirm: true,
				    				showLoaderOnConfirm: true
				    			}, function(){

				    				self.saveEntrada(); 				
				    				
				    		});
				    	},

					    saveEntrada: function() {
					    	self = this;
					    	this.$http.post('/admin/produtos/entradaestoquePost', self.produtos).then(function (response) {

						    	self.return = response.data.return;
						    	swal("Atenção!", self.return.message, self.return.type);
					    		self.produtos.produtos = [];
					    		this.selected = {id: '', nome: '', quantidade: ''};

					      	}, function (response) {

					      		self.return = response.data.return;

					          	swal("Atenção!", self.return.message, self.return.type);
					      	});
					    }
				    },
				})
			</script>


	@stop

@stop