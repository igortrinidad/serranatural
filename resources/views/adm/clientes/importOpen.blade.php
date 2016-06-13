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

<div id="elImport">
	<h2 class="text-right">Importar clientes</h2><br>

	@include('errors.messages')

	<div v-show="loading">
		@include('utils.loading-full')
	</div>

	<div class="row">
		<div class="col-md-12">

			<br><br>
			<button v-on:click="saveImport($event)" class="btn btn-success">Salvar alteração</button>
			
		</div>
	</div>


	<div class="row">
		<div class="col-md-12">
		
			<div class="panel panel-default">
				<div class="panel-header">
					<h4>Lista de clientes</h4>
				</div>
				
				<div class="panel-body">
					
					<table class="table table-bordered table-hover table-striped">
					    <thead>
					        <tr>
					            <th>Nome cliente</th>
					            <th>Email</th>
					            <th>Telefone</th>
					            <th>Telefone</th>
					        </tr>
					    </thead>
					    <tbody>
					        <tr v-for="client in clients" v-on:click="setClient($event, client)">
					            <td>@{{client[4]}}</td>
					            <td>@{{client[6]}}</td>
					            <td>@{{client[7]}}</td>
					            <td>@{{client['teste'] = 'test'}}</td>
					        </tr>
					    </tbody>
					</table>
				</div>
			</div>
			
		</div>
	</div>

				
		




<!-- Modal -->
<div class="modal fade" id="modalClient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" >Cliente: @{{ clientSelected[4] }} </h4>
        
      </div>
      <div class="modal-body">
			
		<div class="row">
			<div class="col-md-12">
				<button 
					type="button" 
					class="btn btn-danger pull-right" 
					v-on:click="removeClient($event, clientSelected)" 
					style="margin: 10px">
				Deletar</button >
				<button 
					class="btn btn-success pull-right" 
					v-on:click="nextClient($event, clientSelected, null)" 
					style="margin: 10px">
				Proximo</button>
				<button 
					class="btn btn-success pull-right" 
					v-on:click="saveUser($event, clientSelected)" 
					style="margin: 10px">
				Registrar usuário</button>

				
			</div>
			
		</div>
		<div class="form-group">
			<label>Nome cliente</label>
			<input class="form-control" v-model="clientSelected[4]" />
		</div>

		<div class="form-group">
			<label>Email</label>
			<input class="form-control" v-model="clientSelected[6]" />
		</div>

		<div class="form-group">
			<label>Telefone</label>
			<input class="form-control" v-model="clientSelected[7]" />
		</div>


	    <hr size="3px" style="margin-top: 2px"/>


		<hr size="3px" style="margin-top: 2px"/>

		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
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
				    el: '#elImport',
				    data: 
				    {	
				    	loading: false,
				    	clients: '',
				    	clientSelected: '',
				    	id: '',

				    },
				    ready: function(){
				    	var self = this;	
				      	
				      	self.clients = {!! $import !!};
				      	self.id = {!! $id !!};

				    },
				    methods:
				    {
				    	saveImport: function(ev){
				    		ev.preventDefault();

				    		var self = this;

				    		var data = {id: self.id, clients: self.clients};

				    		self.loading = true;

					    	this.$http.post('/admin/clientes/import/data/update', data).then(function (response) {

					    		self.loading = false;

					         	console.log(response);

							}, function (response) {

						     	console.log(response);

						     	self.loading = false;

						   });
				    	},
				    	setClient(ev, client){
				    		ev.preventDefault();

				    		$('#modalClient').modal('show');

				    		this.clientSelected = client;
				    	},
				    	nextClient(ev, client, index){
				    		ev.preventDefault();

				    		if(index == null){
								var index = this.clients.indexFromAttr(0, client[0]);
								index++
				    		}
				    		this.clientSelected = this.clients[index];
				    	},
				    	removeClient(ev, client){
				    		ev.preventDefault();

				    		var index = this.clients.indexFromAttr(0, client[0]);
				    		this.clients.removeFromAttr(0, client[0])
				    		this.nextClient(ev, client, index)

				    	},
				    	saveUser(ev, client){
				    		var self = this;
				    		ev.preventDefault();

				    		var senha = Math.floor(Math.random() * 9000) + 1000;
				    		var data = {nome: self.clientSelected[4], email: self.clientSelected[6], telefone: self.clientSelected[7], opt_email: 0, senha_resgate: senha};

				    		self.loading = true;

					    	this.$http.post('/cadastro', data).then(function (response) {

					    		self.loading = false;
					         	console.log('Usuario inserido com sucesso.');
					         	this.removeClient(ev, client)

							}, function (response) {

								self.loading = false;
						     	console.log(response);

						   });


				    	}
					}
				});

//Retorna o index de um array baseado em um identificador (ex. 1 *id) e uma ancora (ex. ID)
Array.prototype.indexFromAttr = function arrayObjectIndexOf(anchor, identifier) {
    for (var i = 0, len = this.length; i < len; i++) {
        if (this[i][anchor] === identifier) {
            return i;
        }
    }
    return false;
}

//Remove um objeto de um array localizado por um identificador passado
Array.prototype.removeFromAttr = function arrayObjectIndexOf(anchor, identifier) {
    for (var i = 0, len = this.length; i < len; i++) {
        if (this[i][anchor] === identifier) {
            this.splice(i, 1);
            return true
        }
    }
    return false;
}

			</script>

	    @stop

@stop