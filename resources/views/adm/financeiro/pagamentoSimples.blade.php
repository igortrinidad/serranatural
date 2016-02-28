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

					<input type="hidden" name="_token" value="{!! csrf_token() !!}" />

					<div class="row">
						<div class="col-md-8">
							<div class="form-group">
								<label>Valor</label>
								<input type="text" v-model="pagamento.valor" class="form-control moneySql" required/>
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label>Data despesa</label>
								<input type="text" v-model="pagamento.data_pgto" class="form-control datepicker dataCompleta" required/>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label>Descrição</label>
						<input type="text" v-model="pagamento.descricao" class="form-control"/>
					</div>

					<div class="form-group">
						<label>Fonte pagamento</label>
						<input type="text" v-model="pagamento.fonte_pgto" class="form-control"/>
					</div>

					<div class="form-group">
						<label>Observações</label>
						<textarea type="textarea" class="form-control" v-model="pagamento.observacoes"></textarea>
					</div>

					<div class="form-group" v-if="!pagamento.comprovante">
						<label>Comprovante</label>
						<input type="file" v-on:change="onFileChange" class="form-control"/>
					</div>

					

					<div class="form-group">
						<button class="btn btn-primary btn-block" v-on:click="saveComprovante">Cadastrar despesa</button>
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
				
				<div class="row"  v-for="produto in pagamento.produtos" track-by="$index" v-bind:value="produto">
					<div class="col-md-8">
						<div class="form-group" >
							<input type="text" class="form-control" v-model="produto.nome" placeholder="Produto">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group" >
							<input type="text" class="form-control quantity" v-model="produto.quantidade" placeholder="quantidade" >
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
							<input type="text" class="form-control quantity" :disabled="! selected.nome" v-model="selected.quantidade" placeholder="quantidade">
						</div>
					</div>
				</div>

				<a class="btn btn-default btn-block" :disabled="'true', ! selected.nome || ! selected.quantidade" v-on:click="addProduto($event)">Adiciona</a>
				
				<br><br>

			</div>

		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Comprovante</h4>
			</div>
			<div class="panel-body">
				<div v-if="pagamento.comprovante" style="position: relative">
					<a href="#" v-on:click="removeImage($event)"
						style="
							position: absolute;
							right:5px;
							top:5px;
							color:#ED3D34;
						"
	    			><i class="fa fa-close fa-2x"></i>
	    			</a>
					<img class="img" :src="pagamento.comprovante" style="max-width: 100%"/>
	    			
    			</div>
			</div>
		</div>

	</div>
			<pre>@{{ $data | json}}</pre>
</div>

</div>


    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/financeiro.js') !!}"></script>

			<script type="text/javascript">
				$('.moneySql').mask('000000.00', {reverse: true});
				$('.quantity').mask('000.000', {reverse: true});
			</script>

			<script type="text/javascript">

				Vue.config.debug = true;
				Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#_tokenLaravel').getAttribute('value');

				var vm = new Vue({
				    el: '#contentProduto',
				    data: {
				    	
				    	pagamento: {
				    		valor: '',
				    		data_pgto: '',
				    		descricao: '',
				    		fonte_pgto: '',
				    		observacoes: '',
				    		comprovante: '',
				    		produtos: []
				    	},
				    	produtosForSelect: [],
				    	selected: {id: '', nome: '', quantidade: ''},
				    },

					    ready: function() {

					      // GET request
					      this.$http.get('/admin/produtos/produtosForSelectJson').then(function (response) {
					          this.produtosForSelect = response.data;
					      }, function (response) {
					          console.log(response);
					      });

					    },
				    methods: {
				    	addProduto: function(ev, quantidade) {
				    		ev.preventDefault();
				    		if( ! this.selected.nome  | ! this.selected.quantidade ){
				    			return false;
				    		}
				    		Produto = {id: this.selected.id, nome: this.selected.nome, quantidade: this.selected.quantidade};
				    		this.pagamento.produtos.push(Produto);
				    		this.selected = {id: '', nome: '', quantidade: ''};
				    	},
				    	onFileChange(e) {
					      var files = e.target.files || e.dataTransfer.files;
					      if (!files.length)
					        return;
					      this.createImage(files[0]);
					    },
					    createImage(file) {
					      var image = new Image();
					      var reader = new FileReader();
					      var vm = this;

					      reader.onload = function(e) {
					        vm.pagamento.comprovante = e.target.result;
					      };
					      reader.readAsDataURL(file);
					    },
					    removeImage: function(ev) {
					    	ev.preventDefault();
					      	this.pagamento.comprovante = '';
					    },
					    saveComprovante: function(ev) {
					    	this.$http.post('/admin/financeiro/despesaStoreVue', this.pagamento).then(function (response) {
					    	console.log(response.data);
					      }, function (response) {
					          console.log(response);
					      });
					    }
				    },
				})

			</script>


	@stop

@stop