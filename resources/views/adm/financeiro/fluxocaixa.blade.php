@extends('layout/admin')

@section('conteudo')


<style>
.success{
	background-color: #CDDC39;
}

.warning{
	background-color: #FF5722;
}
</style>

<h2 class="text-right">Controle de caixa</h2><br>

<div id="contentCaixa">

<div v-show="loading">
	@include('utils.loading-full')
</div>

	<div class="row">

		<div class="col-md-6" v-if="!caixa_is_aberto">
			<div class="panel panel-default">
				<div class="panel-heading">Caixa - <strong><span v-if="abrir_caixa.turno == 1">Primeiro</span><span v-else>Segundo</span> turno</strong></div>
				<div class="panel-body">

					<div class="well text-center">
						<p><strong>Fundo de caixa anterior</strong></p>
						<p><strong>R$ @{{caixa_anterior.vr_emCaixa}} </strong></p>
						<p><strong>Observações</strong></p>
						<p>@{{caixa_anterior.obs}}</p>
					</div>
					<div class="well text-center"
						v-bind:class="{ 'warning': abrir_caixa.diferenca_inicial < 0, 'success': abrir_caixa.diferenca_inicial >= 0 }">
						<p><strong>Diferença entre os caixas!</strong></p>
						<p><strong>R$ @{{abrir_caixa.diferenca_inicial}} </strong></p>
					</div>
					<div class="form-group">
						<select class="form-control" v-model="abrir_caixa.turno">
							<option value="1" selected>Turno 1</option>
							<option value="2">Turno 2</option>
						</select>
					</div>
					<div class="form-group">
						<label>Contagem do caixa atual</label>
						<input class="form-control moneyFloat" type="text" 
							v-model="abrir_caixa.valor" 
							v-on:blur="calculaAbertura()"
						/>
					</div>

					<div class="form-group">
						<label>Senha</label>
						<input class="form-control" type="password" v-model="abrir_caixa.senha"/>
					</div>

					<button class="btn btn-primary btn-block" :disabled="! abrir_caixa.valor || ! abrir_caixa.senha || !abrir_caixa.turno" v-on:click="abreCaixa()">Abrir caixa</button>

				</div>

			</div>	
		</div>
	</div>

	<div class="row">

		<div v-if="caixa_is_aberto == true">

			<div class="row">

				<div class="col-md-3">
					<div class="well text-center">
						<h2>Turno: @{{caixa_aberto.turno}}</h2>
						<p>Turno do caixa</p>
					</div>
				</div>

				<div class="col-md-3">
					<div class="well text-center" 
					>
						<h2>Aberto em:</h2>
						<p>@{{ caixa_aberto.created_at | formatDate }}</p>
					</div>
				</div>	

				<div class="col-md-3">
					<div class="well text-center">
						<h2>R$ @{{caixa_aberto.vr_abertura}}</h2>
						<p>Valor de abertura</p>
					</div>
				</div>

				<div class="col-md-3">
					<div class="well text-center">
						<h2>R$ @{{vendas.vendaBruta}}</h2>
						<p>Vendas total</p>
					</div>
				</div>

				<div class="col-md-3">
					<div class="well text-center">
						<h2>R$ @{{caixa_aberto.total_retirada}}</h2>
						<p>Total retiradas</p>
					</div>
				</div>


				<div class="col-md-3">
					<div class="well text-center">
						<h2>R$ @{{vendas.taxa_dia}}</h2>
						<p>Taxa recolhida</p>
					</div>
				</div>

				<div class="col-md-3">
					<div class="well text-center">
						<h2>R$ @{{caixa_anterior.vendas_rede}}</h2>
						<p>Venda Rede Anterior</p>
					</div>
				</div>	

				<div class="col-md-3">
					<div class="well text-center">
						<h2>R$ @{{caixa_anterior.vendas_cielo}}</h2>
						<p>Venda Cielo Anterior</p>
					</div>
				</div>	

				<div class="col-md-3" v-if="authorization">
					<div class="well text-center" 
						v-bind:class="{ 'warning': caixa_aberto.diferenca_final < 0, 'success': caixa_aberto.diferenca_final >= 0 }"
					>
						<h2>R$ @{{caixa_aberto.diferenca_final}}</h2>
						<p>Diferença</p>
					</div>
				</div>	


			</div>

			<hr size="3px" style="margin-top: 2px"/>

			<div class="row">
				
				<div class="col-md-8">
					<div class="panel panel-default">
						<div class="panel-heading">Caixa</div>
						<div class="panel-body">

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Dinheiro em caixa</label>
										<input type="text" class="form-control moneyFloat" 
											v-model="caixa_aberto.vr_emCaixa"
											v-on:blur="calcula($event)"
										/>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label>Substrair cartões anteriores</label>
										<br>
										<button v-if="unlock" class="btn btn-primary btn-block" @click="substract($event)">Subtrair</button>
										<button v-if="!unlock" class="btn btn-danger btn-block" @click="substract($event)">Desbloquear</button>
									</div>
								</div>
								
							</div>


							<div class="row">

								<div class="col-md-6">
									<div class="form-group">
										<label>Total de venda maquina REDE</label>
										<input type="text" class="form-control moneyFloat" 
											v-on:blur="calcula($event)"
											v-model="caixa_aberto.vendas_rede"

										/>
									</div>
								</div>

								<div class="col-md-6 col-xs-6">
									<div class="form-group">
										<label>Total de venda maquina CIELO</label>
										<input type="text" class="form-control moneyFloat" 
											v-model="caixa_aberto.vendas_cielo"
											v-on:blur="calcula($event)"
										/>
									</div>
								</div>

								<div class="col-md-6 col-xs-6">
									<div class="form-group">
										<label>Vendas ONLINE (somente pagamento online, quando não recebeu)</label>
										<input type="text" class="form-control moneyFloat" 
											v-model="caixa_aberto.vendas_online"
											v-on:blur="calcula($event)"
										/>
									</div>
								</div>
							</div>


							<div class="row">

								<div class="col-md-12">
									<div class="form-group">
										<label>Observações e relatório do dia</label>
										<textarea rows="7" class="form-control" v-model="caixa_aberto.obs"></textarea>
									</div>
								</div>
								
							</div>

						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading">Vendas</div>
						<div class="panel-body">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Valor</th>
										<th>Data</th>
										<th>Ver conta</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="venda in vendas.vendas_resumo">
										<td >R$ @{{(venda.valor/100).formatMoney(2, ',', '.')}}</td>
										<td>@{{venda.data}}</td>
										<td><a href="@{{venda.url}}" target="_blank">Ver recibo</td>
									</tr>

								</tbody>
							</table>
						</div>
					</div>

				</div>
			
			

				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading">Ações</div>
						<div class="panel-body">
							
							<br>
							<div class="form-group">
								<label>Senha operador</label>
								<input class="form-control" type="password" v-model="caixa_aberto.senha"/>
							</div>
							<hr size="3px" style="margin: 10px;"/>
							<div class="form-group">
								<label>Senha conferente</label>
								<input class="form-control" type="password" v-model="caixa_aberto.senha_conferente"/>
							</div>
							<br>
							<button class="btn btn-warning btn-block" 
								v-on:click="confere($event)"
								:disabled="!caixa_aberto.vendas_cielo || !caixa_aberto.vendas_rede || !caixa_aberto.vr_emCaixa"
							>Conferir</button>
							<br>
							<button class="btn btn-primary btn-block" 
								v-on:click="fecha($event)"
								:disabled="!caixa_aberto.vendas_cielo || !caixa_aberto.vendas_rede || !caixa_aberto.vr_emCaixa"
							>Fechar caixa</button >



						</div>

					</div>

					<div class="panel panel-default">
						<div class="panel-heading">Retiradas</div>
						<div class="panel-body">
							<table class="table">
							    <thead>
							        <tr>
							            <th>Tipo</th>
							            <th>Descrição</th>
							            <th>Valor</th>
							        </tr>
							    </thead>
							    <tbody>
							        <tr v-for="retirada in retiradas">
							            <td>@{{retirada.tipo}}</td>
							            <td>@{{retirada.descricao}}</td>
							            <td>R$ @{{retirada.valor}}</td>
							        </tr>
							    </tbody>
							</table>

							<a href="/admin/financeiro/retirada" class="btn btn-primary btn-block">Fazer retirada</a>

						</div>

					</div>
				</div>
			</div>

		</div>

	</div>


</div>
	

    @section('scripts')
	    @parent


	        <script src="{!! elixir('js/financeiro.js') !!}"></script>

			<script type="text/javascript">

				Vue.config.debug = true;
				Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#_tokenLaravel').getAttribute('value');
				var vm = new Vue({
				    el: '#contentCaixa',
				    data: {
				    	loading: false,
				    	authorization: false,
				    	retorno: '',
				    	caixa_aberto: {senha: '', senha_conferente: ''},
				    	caixa_anterior: '',
				    	caixa_is_aberto: false,
				    	vendas: {
				    		vendaBruta: '',
				    		taxa_dia: '',
				    		vendas_resumo: [
				    			{id: '', valor: '', url: '', data: ''},
				    		]
				    	},
				    	abrir_caixa: {
				    		valor: '',
				    		senha: '',
				    		turno: '',
				    		diferenca_inicial: '',
				    	},
				    	retiradas: [],
				    	substracted: false,
				    	unlock: false,
				    },
				    filters: {
					    formatDate: {
			                read: function (val) {
			                    return moment(val).format('DD/MM/YYYY HH:mm:ss')
			                },

			                write: function (val) {
			                	return val
			                }
			            }	
				    },
				    attached: function()
    					{
    						$(this.$els.amount).mask("000.00");
    					},
					    ready: function() {
				 	      	var self = this;	
					      	// GET request
					      	self.loading = true;
					      	this.$http.get('/admin/financeiro/caixa/consulta').then(function (response) {

					          if(response.data.caixa_aberto != null) {

					          	self.caixa_aberto = response.data.caixa_aberto;
					          	self.caixa_anterior = response.data.caixa_anterior;
					          	self.caixa_is_aberto = true;
					          	self.retiradas = response.data.retiradas;
					          	

					          	this.$http.get('/admin/financeiro/caixa/consultaVendas').then(function (response) {
							        self.vendas = response.data;
							        self.caixa_aberto.vendas = self.vendas.vendaBruta;

							    }, function (response) {
							      	console.log('Erro ao tentar buscar vendas.');
							    });

					          } else if(response.data.caixa_anterior != null) {

					          	self.caixa_anterior = response.data.caixa_anterior;
					          	self.caixa_is_aberto = false;

					          }

					          self.abrir_caixa.turno = response.data.turno;

					          self.loading = false;

					      }, function (response) {

					      	console.log('Erro ao tentar buscar caixa.');
					        console.log(response.data);
					        self.caixa_ = response.data.retorno;
					        self.loading = false;

					      });

					    

					      	setTimeout(function()
								    {
								    	location.reload();
								    }, 180000);

					    },
				    methods: {
				    	substract: function(ev){
				    		ev.preventDefault()

				    		if(!this.substracted){

				    		if(!this.unlock){
				    			this.unlock = true;
				    			return false
				    		}
				    			this.caixa_aberto.vendas_cielo = parseFloat(this.caixa_aberto.vendas_cielo) - parseFloat(this.caixa_anterior.vendas_cielo);

				    			this.caixa_aberto.vendas_rede = parseFloat(this.caixa_aberto.vendas_rede) - parseFloat(this.caixa_anterior.vendas_rede);

				    			this.unlock = false;

				    			this.calcula();
				    		}


				    		this.substracted = true;

				    	},
				    	abreCaixa: function(ev) {
				    		self = this;

				    		if(!this.loading){

				    			this.loading = true;

				    			this.$http.post('/admin/financeiro/caixa/abreCaixa', self.abrir_caixa).then(function (response) {

				    				console.log('Caixa aberto com sucesso.');

				    				swal(response.data.retorno.title, response.data.retorno.message, response.data.retorno.type);

				    				setTimeout(function()
								    {
								    	location.reload();
								    }, 2200);

								    this.loading = false;

							    }, function (response) {
							      	console.log('Erro ao abrir o caixa');
							      	console.log(response.data);

							      	this.loading = false;

							      	swal(response.data.retorno.title, response.data.retorno.message, response.data.retorno.type);
							    });

				    		}

				    	},
				    	confere: function(ev) {
				    		ev.preventDefault();

				    		this.calcula();
				    		var that = this;

				    		that.loading = true;

				    		this.$http.post('/admin/financeiro/caixa/confere', this.caixa_aberto).then(function (response) {

				    				console.log(response.data);

							       swal(response.data.retorno.title, response.data.retorno.message, response.data.retorno.type);

							     	that.authorization = true;

							     	setTimeout( function(){
							     		that.authorization = false;
							     	}, 40000)

							     	that.loading = false;

							    }, function (response) {
							      	console.log('Erro ao tentar salvar.');
							      	swal(response.data.retorno.title, response.data.retorno.message, response.data.retorno.type);
							      	that.authorization = false;

      					    		that.loading = false;
							    });

				    		that.caixa_aberto.senha = '';
				    		that.caixa_aberto.senha_conferente = '';


				    	},
				    	fecha: function(ev) {
				    		ev.preventDefault();
				    		var that = this;

				    		if(!this.loading){

				    			this.loading = true;

					    		this.calcula();

					    		this.$http.post('/admin/financeiro/caixa/fecha', this.caixa_aberto).then(function (response) {
								       swal(response.data.retorno.title, response.data.retorno.message, response.data.retorno.type);

								       setTimeout(function()
									    {
									    	location.reload();
									    }, 3000);
								       that.authorization = false;
								       that.loading = false;

								    }, function (response) {

								      	console.log('Erro ao tentar fechar o caixa.');

								      	swal('ERRO', 'ERRO AO FECHAR O CAIXA! TENTE NOVAMENTE OU VERIFIQUE SE O CAIXA FOI FECHADO. INFORME AO ASSISTÊNCIA.', 'error');
								      	that.authorization = false;
								      	that.loading = false;
								    });
				    		}

				    	},
				    	calcula: function(ev) {

				    		this.substracted = false;

				    		if (!this.caixa_aberto.vendas_rede) this.caixa_aberto.vendas_rede = 0;
				    		if (!this.caixa_aberto.vendas_cielo) this.caixa_aberto.vendas_cielo = 0;
				    		if (!this.caixa_aberto.vendas_online) this.caixa_aberto.vendas_online = 0;
				    		if (!this.caixa_aberto.vr_emCaixa) this.caixa_aberto.vr_emCaixa = 0;

				    		console.log('Vendas rede: ' + this.caixa_aberto.vendas_rede);
				    		console.log('Vendas cielo: ' + this.caixa_aberto.vendas_cielo);
				    		console.log('Valor em caixa: ' + this.caixa_aberto.vr_emCaixa);
				    		console.log('Total retirada: ' + this.caixa_aberto.total_retirada);
				    		console.log('Vendas bruta: ' + this.vendas.vendaBruta.replace(',', ''));

				    		var conferencia1 = 
				    			( parseFloat( this.caixa_aberto.vr_emCaixa )
				    			+ parseFloat( this.caixa_aberto.total_retirada ) - 
				    			(parseFloat( this.caixa_aberto.vr_abertura ) ) );


				    		var conferencia2 = 
				    		( parseFloat( this.vendas.vendaBruta.replace(',', '') ) ) -
				    		( parseFloat( this.caixa_aberto.vendas_cielo )
				    		+ parseFloat( this.caixa_aberto.vendas_rede ) 
				    		+ parseFloat( this.caixa_aberto.vendas_online )
				    		); 

				    		var diferenca = (conferencia1) - (conferencia2);

				    		console.log('Conferencia 1: ' + conferencia1);
				    		console.log('Conferencia 2: ' + conferencia2);
				    		console.log('Diferença: ' + diferenca);

					    	this.caixa_aberto.diferenca_final = diferenca.toFixed(2);
					    	this.caixa_aberto.vendas = this.vendas.vendaBruta;

				    	},
				    	calculaAbertura: function(){
				    		var diferenca = 
				    			parseFloat(this.abrir_caixa.valor)
				    			-
				    			parseFloat(this.caixa_anterior.vr_emCaixa);

				    		this.abrir_caixa.diferenca_inicial = diferenca;

				    		console.log(this.abrir_caixa.diferenca_inicial);
				    	},

				    },
				})
			</script>

			<script type="text/javascript">
		        $('.moneyInteger').mask('000000', {reverse: true});
		        $('.moneyFloat').mask('0000.00', {reverse: true});



			</script>

	    @stop

@stop