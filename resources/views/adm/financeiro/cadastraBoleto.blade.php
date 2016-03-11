@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Cadastro de boleto</h2><br>

<div id="contentBoleto">

	<div class="row">
		<div class="col-md-7">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Informe os detalhes do boleto</h4>
				</div>
				<div class="panel-body">

						{!! csrf_field() !!}

						<div class="form-group">
							<select id="tipo-boleto" class="form-control" v-model="pagamento.tipo" >
								<option value="1" selected>Boleto</option>
								<option value="2">Agua, Luz, Telefone, Impostos</option>
							</select>
						</div>

						
						<div class="form-group">
							<label>Linha digitavel</label>
							<input type="text" v-el:linhaDigitavel v-model="pagamento.linha_digitavel" class="form-control linha-digitavel"/>
						</div>
						<div class="row">
							<div class="col-md-8">
								<div class="form-group">
									<label>Valor</label>
									<input type="text" name="valor" v-model="pagamento.valor" class="form-control moneySql" v-el="moneySql" required/>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Vencimento</label>
									<input type="text" name="vencimento" v-model="pagamento.vencimento" v-el="vencimento" class="form-control datepicker dataCompleta" required/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label>Descrição</label>
							<input type="text" name="descricao" v-model="pagamento.descricao" class="form-control"/>
						</div>

						<div class="form-group">
							<label>Observações</label>
							<textarea type="textarea" class="form-control" v-model="pagamento.observacoes"></textarea>
						</div>

						<div class="form-group" v-if="!pagamento.arquivoPagamento">
							<label>Arquivo pagamento</label>
							<input type="file" v-on:change="onFileChange($event, 'arquivoPagamento')" class="form-control" accept=".jpg,.png,.jpeg" />
						</div>

						<div class="form-group" v-if="!pagamento.arquivoNota">
							<label>Arquivo Nota fiscal</label>
							<input type="file" v-on:change="onFileChange($event, 'arquivoNota')" class="form-control" accept=".jpg,.png,.jpeg"/>
						</div>
						<div class="form-group">
							<button class="btn btn-primary btn-block" 
							v-on:click="savePagamento($event)"
							:disabled="'true', ! pagamento.valor || ! pagamento.vencimento || ! pagamento.linha_digitavel || ! pagamento.arquivoPagamento || ! pagamento.descricao"
						>Cadastrar boleto</button>
						</div>

				</div>
			</div>
			
		</div>

		<div class="col-md-5">

			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Produtos</h4>
				</div>
				<div class="panel-body">
					
					<div class="row"  v-for="produto in pagamento.produtos" track-by="$index" v-bind:value="produto">
						<div class="col-md-8">
							<div class="form-group" >
								<input type="text" class="form-control" v-model="produto.nome" placeholder="Produto">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group" >
								<input type="text" class="form-control" v-model="produto.quantidade" v-el="produtoQuantidade" placeholder="quantidade" >
							</div>
						</div>
					</div>

					<label>Adiciona produto</label>
					<div class="row">
						<div class="col-md-8">

							<div class="form-group">
					            <select v-model="selected" class="form-control">
									<option 
										v-for="produtoSelected in produtosForSelect" 
										track-by="$index" 
										v-bind:value="produtoSelected" 
									>@{{produtoSelected.nome}}</option>
								</select>
					        </div>
						</div>
						<div class="col-md-4">
							<div class="form-group" >
								<input type="text" class="form-control quantity" :disabled="! selected.nome" v-model="selected.quantidade" v-el:produtoQuantidade placeholder="quantidade">
							</div>
						</div>
					</div>

					<a class="btn btn-default btn-block" :disabled="'true', ! selected.nome || ! selected.quantidade" v-on:click="addProduto($event)">Adiciona</a>
					


				</div>

			</div>

			<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Arquivos</h4>
			</div>
			<div class="panel-body">
				<div v-if="pagamento.arquivoPagamento" style="position: relative">
					<a href="#" v-on:click="removeImage($event, 'arquivoPagamento')"
						style="
							position: absolute;
							right:5px;
							top:5px;
							color:#ED3D34;
						"
	    			><i class="fa fa-close fa-2x"></i>
	    			</a>
					<img class="img" :src="pagamento.arquivoPagamento" style="max-width: 100%"/>
	    			
    			</div>

    			<div v-if="pagamento.arquivoNota" style="position: relative">
					<a href="#" v-on:click="removeImage($event, 'arquivoNota')"
						style="
							position: absolute;
							right:5px;
							top:5px;
							color:#ED3D34;
						"
	    			><i class="fa fa-close fa-2x"></i>
	    			</a>
					<img class="img" :src="pagamento.arquivoNota" style="max-width: 100%"/>
	    			
    			</div>
			</div>
		</div>

		<pre> @{{ $data | json}} </pre>

		</div>

</div>


    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/financeiro.js') !!}"></script>

	        <script type="text/javascript">

				Vue.config.debug = true;
				Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#_tokenLaravel').getAttribute('value');
				Vue.http.headers.common['Content-Type'] = 'application/json';

				var vm = new Vue({
				    el: '#contentBoleto',
				    data: {
				    	pagamento: {
				    		tipo: '',
				    		valor: '',
				    		linha_digitavel: '',
				    		vencimento: '',
				    		descricao: '',
				    		observacoes: '',
				    		arquivoPagamento: '',
				    		arquivoNota: '',
				    		produtos: []
				    	},
				    	return: '',
				    	produtosForSelect: [],
				    	selected: {id: '', nome: '', quantidade: ''},
				    },
				    attached: function(){
        					
					},
				    ready: function() {
			 	      	var self = this;	
				      	// GET request
				      	this.$http.get('/admin/produtos/produtosForSelectJson/anything').then(function (response) {
				          self.produtosForSelect = response.data;
				      }, function (response) {
				          console.log(response);
				      });
				    },
				    methods: {
				    	addProduto: function(ev, quantidade) {
				    		ev.preventDefault();
				    		if( ! this.selected.nome  || ! this.selected.quantidade ) {
				    			return false;
				    		}
				    		Produto = {id: this.selected.id, nome: this.selected.nome, quantidade: this.selected.quantidade};
				    		this.pagamento.produtos.push(Produto);
				    		this.selected = {id: '', nome: '', quantidade: ''};
				    	},
				    	onFileChange(e, tipo) {
				    		var tipo  = tipo;
					      	var files = e.target.files || e.dataTransfer.files;
					      	if (!files.length) {
					        	return false;
					    	}
					      	this.createImage(files[0], tipo);
					    },
					    createImage(file, tipo) {
					    	var tipo  = tipo;
					      var image = new Image();
					      var reader = new FileReader();
					      var vm = this;
					      reader.onload = function(e) {
					      	if(tipo == 'arquivoPagamento') {
					      		vm.pagamento.arquivoPagamento = e.target.result;
					      	} else {
					      		vm.pagamento.arquivoNota = e.target.result;
					      	}
					      };
					      reader.readAsDataURL(file);
					    },
					    removeImage: function(ev, tipo) {
					    	var tipo  = tipo;
					    	ev.preventDefault();
					    	if(tipo == 'arquivoPagamento') {
					      		this.pagamento.arquivoPagamento = '';
					      	} else {
					      		this.pagamento.arquivoNota = '';
					      	}
					    },
					    savePagamento: function(ev) {
					    	ev.preventDefault();
					    	self = this;
					    	this.$http.post('/admin/financeiro/pagamentosPost', this.pagamento).then(function (response) {

						    	self.return = response.data.return;
						    	swal(self.return.title, self.return.message, self.return.type);

						    	self.pagamento.tipo = '';
						    	self.pagamento.valor = '';
					    		self.pagamento.vencimento = '';
					    		self.pagamento.descricao = '';
					    		self.pagamento.linhaDigitavel = '';
					    		self.pagamento.observacoes = '';
					    		self.pagamento.arquivoPagamento = '';
					    		self.pagamento.arquivoNota = '';
					    		self.pagamento.produtos = [];

					      	}, function (response) {
					          	console.log(response);
					      	});
					    }
				    }
				})
			</script>

   			<script type="text/javascript">
				$('.linha-digitavel').mask('00000.00000.00000.000000.00000.000000.0.00000000000000');
		        $('.moneySql').mask('000000.00', {reverse: true});
		        
		        $('#tipo-boleto').on('change', function() {
					  if($( "#tipo-boleto option:selected" ).val() == 2)
		        	{

		        	$('.linha-digitavel').mask('00000000000-0 00000000000-0 00000000000-0 00000000000-0');
			        } else if($( "#tipo-boleto option:selected" ).val() == 1)
			        {
			        $('.linha-digitavel').mask('00000.00000 00000.000000 00000.000000 0 00000000000000');
			    	}	
				});
			</script>

	@stop

@stop