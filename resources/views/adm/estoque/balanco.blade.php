@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Balanço semanal</h2><br>

<div id="contentBaixa" class="row">


	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Produtos</h4>
			</div>
			<div class="panel-body">
				<h5>Lista de Produtos</h5>

				<h5 style="
				position: fixed;
				font-size: 20px;
				color:#E12730;
				font-weight: 800;
				right:40px;
				bottom:20px;

				">
				@{{produtos.finished}}%</h5>
				
				<div class="row"  v-for="produto in produtos.listaProdutos" >
					<div class="col-md-5">
						<div class="form-group" >
							<label>Produto</label>
							<input type="text" class="form-control" v-model="produto.nome" placeholder="Produto" disabled>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group" >
							<label>Qtde esperada</label>
							<input type="text" class="form-control" v-model="produto.quantidadeEstoque" v-el:produtoQtdeEstoque placeholder="00.00" disabled>
						</div>
					</div>

					<div class="col-md-2">
						<div class="form-group" >
							<label>Qtde real</label>
							<input type="text" class="form-control" v-on:keyup="calculaDiferenca($event, produto)" v-model="produto.quantidadeReal" v-el:produtoQtdeReal placeholder="00.00" >
						</div>
					</div>

					<div class="col-md-2">
						<div class="form-group" >
							<label>Diferença</label>
							<input type="text" class="form-control"  v-el:produtoDiferenca v-model="produto.diferenca" placeholder="00.00" disabled >
						</div>
					</div>
				</div>

				<hr size="3px"></hr>

<br>
				<a 
					v-if="produtos != ''"
					class="btn btn-primary btn-block" 
					:disabled="'true', produtos.produtos == ''"
					v-on:click="confirmBalanco($event)"
				>Salvar Balanço</a>
				
				<br><br>
				<pre>@{{ $data | json }}</pre>
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
				    	produtos: {
				    		listaProdutos: [],
				    		finished: '',
				    	},
				    	arrayFinished: [],
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
					      	this.$http.get('/admin/produtos/produtosForSelectJson').then(function (response) {
					          self.produtos.listaProdutos = response.data;
					      }, function (response) {
					          console.log(response);
					      });
					    },
				    methods: {
				    	calculaDiferenca: function(ev, produto) {
				    		self = this;
				    		ev.preventDefault;
				    		

    		                index = self.arrayFinished.indexOf(produto.id);


				            if(produto.quantidadeReal != '') {
				            	if(index == -1) {
				            		self.arrayFinished.push(produto.id);
				            	}
				            } else if(produto.quantidadeReal == '') {
				            		self.arrayFinished.$remove(produto.id);
			
				            }

				            self.produtos.finished = 100 / self.produtos.listaProdutos.length * self.arrayFinished.length;

				            if(produto.quantidadeReal != '') {
				            	produto.diferenca = parseFloat(produto.quantidadeReal) - parseFloat(produto.quantidadeEstoque);
				            } else {
				            	produto.diferenca = 0;
				            }


				    	},
				    	confirmBalanco: function(ev) {
				    		ev.preventDefault();
				    		if( this.produtos.produtos == '') {
				    			return false;
				    		}
				    		self = this;
				    		swal({   
				    				title: "Baixa no estoque!",
				    				text: "Essa alteração não poderá ser desfeita",
				    				type: "warning",
				    				showCancelButton: true,
				    				cancelButtonText: "Cancelar",
				    				confirmButtonColor: "#DD6B55",
				    				confirmButtonText: "Sim, tenho certeza!",
				    				closeOnConfirm: true,
				    				showLoaderOnConfirm: true
				    			}, function(){

				    				self.saveBalanco(); 				
				    				
				    		});
				    	},

					    saveBalanco: function() {
					    	self = this;
					    	this.$http.post('/admin/produtos/balancoPost', self.produtos).then(function (response) {

						    	self.return = response.data.return;
						    	swal("Atenção!", self.return.message, self.return.type);

					      	}, function (response) {

					      		self.return = response.data;

					          	swal("Atenção!", self.return.message, self.return.type);
					      	});
					    }
				    },
				})
			</script>


	@stop

@stop