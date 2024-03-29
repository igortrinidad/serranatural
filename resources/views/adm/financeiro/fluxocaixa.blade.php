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
<p> <?php echo date('d/m/Y H:i:s'); ?></p>

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
							v-model="abrir_caixa.payments.register_init_value" 
							v-on:blur="calculaAbertura()"
						/>
					</div>

					<div class="form-group">
						<label>Senha</label>
						<input class="form-control" type="password" v-model="abrir_caixa.senha"/>
					</div>

					<button class="btn btn-primary btn-block" :disabled="! abrir_caixa.payments.register_init_value || ! abrir_caixa.senha || !abrir_caixa.turno" v-on:click="abreCaixa()">Abrir caixa</button>

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
					<div class="well text-center" 
					>
						<h2>Responsável:</h2>
						<p>@{{ caixa_aberto.usuario_abertura.name }}</p>
					</div>
				</div>	

				<div class="col-md-3">
					<div class="well text-center">
						<h2>R$ @{{caixa_aberto.payments.register_init_value}}</h2>
						<p>Valor de abertura</p>
					</div>
				</div>

				<div class="col-md-3">
					<div class="well text-center">
						<h2>R$ @{{vendas.vendaBruta}}</h2>
						<p>Vendas total</p>
					</div>
				</div>

				<div class="col-md-3" v-for="payment in caixa_anterior.payments.items">
					<div class="well text-center">
						<h2>R$ @{{payment.value}}</h2>
						<p>@{{payment.label}} anterior</p>
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
											v-model="caixa_aberto.payments.register_end_value"
											v-on:blur="calcula($event)"
										/>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label>Subtrair cartões anteriores</label>
										<br>
										<button v-if="unlock" class="btn btn-primary btn-block" @click="substract($event)">Subtrair</button>
										<button v-if="!unlock" class="btn btn-danger btn-block" @click="substract($event)">Desbloquear</button>
									</div>
								</div>
								
							</div>


							<div class="row">

								<div class="col-md-6" v-for="payment in caixa_aberto.payments.items">
									<div class="form-group">
										<label>Total de venda: @{{payment.label}}</label>
										<input type="text" class="form-control moneyFloat" 
											v-on:blur="calcula($event)"
											v-model="payment.value"
										/>
									</div>
								</div>


							</div>


							<div class="row">

								<div class="col-md-12">
									<div class="form-group">
										<label>Observações e relatório do dia</label>
										<textarea rows="7" class="form-control" v-model="caixa_aberto.obs" placeholder="É obrigatorio o preenchimento correto com a quantidade de salgados que sobraram, se sobraram e qualquer fato relevante que tenha ocorrido no turno. Como a falta de algum produto que o cliente solicitou, a urgencia em algum produto que precisa reposição, uma reclamação de algum cliente, atitudes de funcionários em desacordo com as politicas da empresa entre outras. O não cumprimento dessas obrigações poderá ser penalizada com advertência pela empresa."></textarea>
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
					
					<!-- DIFERENÇA -->
					<div class="panel panel-default" v-if="user_type == 'super_adm'">
						<div class="panel-heading">Diferença</div>
						<div class="panel-body">
							<span class="" >
								<h3>@{{caixa_aberto.diferenca_final}}</h3>
							</span>
						</div>
					</div>
					
					<!-- AÇÕES -->
					<div class="panel panel-default">
						<div class="panel-heading">Ações</div>
						<div class="panel-body">
							
							<br>
							<div class="form-group">
								<label>Senha operador</label>
								<input class="form-control" type="password" v-model="caixa_aberto.senha"/>
							</div>
							<hr size="3px" style="margin: 10px;"/>
							<button class="btn btn-primary btn-block" 
								v-on:click="fecha($event)"
								:disabled="!caixa_aberto.vr_emCaixa || !caixa_aberto.senha || !caixa_aberto.obs"
							>Fechar caixa</button >
							<hr size="3px" style="margin: 10px;"/>
							<br>
							<button 
								class="btn btn-success btn-block" 
								v-on:click="salva($event)"
							>Salvar</button>
							<br>




						</div>
					</div>
					
					<!-- RETIRADAS -->
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

			//Retorna o objeto de um array baseado em um identificador (ex. 1 *id) e uma ancora (ex. ID)
			Array.prototype.findFromAttr = function arrayObjectIndexOf(anchor, identifier) {
			    for (var i = 0, len = this.length; i < len; i++) {
			        if (this[i][anchor] === identifier) {
			            return this[i];
			        }
			    }
			    return false;
			}

			//Retorna o index de um array baseado em um identificador (ex. 1 *id) e uma ancora (ex. ID)
				Array.prototype.indexFromAttr = function arrayObjectIndexOf(anchor, identifier) {
				    for (var i = 0, len = this.length; i < len; i++) {
				        if (this[i][anchor] === identifier) {
				            return i
				        }
				    }
				    return false;
				}


				Vue.config.debug = true;
				Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#_tokenLaravel').getAttribute('value');
				var vm = new Vue({
				    el: '#contentCaixa',
				    data: {
				    	loading: false,
				    	authorization: false,
				    	retorno: '',
				    	caixa_aberto: {
				    		senha: '', 
				    		senha_conferente: '',
				    		contas: {
			    				contas_abertas: [],
			    				contas_pagas: [],
			    				total: 0,
				    		},
				    		payments: {
				    			register_init_value: 0,
				    			register_end_value: 0,
				    			total_money: 0,
				    			total_cards: 0,
				    			total_accounts: 0,
				    			total: 0,
				    			items: [
				    			{
					    			label: 'Ticket',
					    			value: 0
					    		},
					    		{
					    			label: 'Stone',
					    			value: 0
					    		},
					    		{
					    			label: 'Rede',
					    			value: 0
					    		},
					    		{
					    			label: 'iFood',
					    			value: 0
					    		},
					    		{
					    			label: 'Cielo',
					    			value: 0
					    		},
					    		]
					    	},
				    	},
				    	caixa_anterior: {
			    			contas: {
			    				contas_abertas: [],
			    				contas_pagas: [],
			    				total: 0,
			    			}
				    	},
				    	clientes: [],
				    	caixa_is_aberto: false,
				    	vendas: {
				    		vendaBruta: 0,
				    		taxa_dia: 0,
				    		vendas_resumo: [
				    			{id: '', valor: 0, url: '', data: ''},
				    		]
				    	},
				    	abrir_caixa: {
				    		valor: '',
				    		senha: '',
				    		turno: '',
				    		diferenca_inicial: '',
				    		contas: {},
				    		payments: {
				    			register_init_value: 0,
				    			register_end_value: 0,
				    			total_money: 0,
				    			total_cards: 0,
				    			total_accounts: 0,
				    			total: 0,
				    			items: [
					    			{
						    			label: 'Ticket',
						    			value: 0,
										tax: 10
						    		},
						    		{
						    			label: 'Stone',
						    			value: 0,
										tax: 5
						    		},
						    		{
						    			label: 'Rede',
						    			value: 0,
										tax: 5
						    		},
						    		{
						    			label: 'PagSimples',
						    			value: 0,
										tax: 5
						    		},
									{
						    			label: 'Glovo',
						    			value: 0,
										tax: 22
						    		},
									{
						    			label: 'iFood',
						    			value: 0,
										tax: 12
						    		},
									{
						    			label: 'Uber Eats',
						    			value: 0,
										tax: 25
						    		},
					    		]
					    	},

				    	},
				    	newConta: {
				    		data_init: '',
				    		cliente: '',
				    		telefone: '',
				    		valor: '',
				    		data_pay: '',
				    		usuario_add: '{{\Auth::user()->name}}',
				    		usuario_pay: '{{\Auth::user()->name}}'
				    	},
				    	retiradas: [],
				    	substracted: false,
				    	unlock: false,
				    	user_type: '{{Auth::user()->user_type}}'
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
				    attached: function(){
						$(this.$els.amount).mask("000.00");
					},
				    ready: function() {
			 	      	var self = this;	
				      	// GET request
				      	self.loading = true;
				      	this.$http.get('/admin/financeiro/caixa/consulta').then(function (response) {

				          if(response.data.caixa_aberto != null) {

				          	self.$set('caixa_aberto', response.data.caixa_aberto);
				          	self.$set('caixa_anterior', response.data.caixa_anterior);
				          	self.caixa_is_aberto = true;
				          	self.retiradas = response.data.retiradas;
				          	self.clientes = response.data.clientes;

				          	this.$http.get('/admin/financeiro/caixa/consultaVendas').then(function (response) {
						        self.vendas = response.data;
						        self.caixa_aberto.vendas = parseFloat(self.vendas.vendaBruta.replace(',', ''));
						        self.vendas.vendaBruta = parseFloat(self.vendas.vendaBruta.replace(',', ''));

								console.log(self.caixa_aberto.vendas)

								self.calcula();

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

										    

				      	setTimeout(function(){
					    	location.reload();
					    }, 180000);

					},
				    methods: {

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

				    	calcula: function(ev) {
				    		var that = this
				    		this.substracted = false;

				    		var totalPayments = 0;

				    		that.caixa_aberto.payments.items.forEach(function(payment){
				    			if(isNaN(payment.value) || !payment.value){
				    				payment.value = 0;
				    			}
				    			totalPayments += parseFloat(payment.value);

				    		});

				    		if (!that.caixa_aberto.payments.register_end_value || isNaN(that.caixa_aberto.payments.register_end_value)) that.caixa_aberto.payments.register_end_value = 0;

				    		that.caixa_aberto.payments.total_cards = totalPayments;
				    		that.caixa_aberto.payments.total_money = parseFloat(that.caixa_aberto.payments.register_end_value) + 
				    			parseFloat(this.caixa_aberto.total_retirada) -
				    			parseFloat(that.caixa_aberto.payments.register_init_value);

				    		var conferencia1 = 
				    			( parseFloat( that.caixa_aberto.payments.register_end_value )
				    			+ parseFloat( this.caixa_aberto.total_retirada ) 
				    			- (parseFloat( that.caixa_aberto.payments.register_init_value)  ) );
							
							this.vendas.vendaBruta = parseFloat(this.vendas.vendaBruta)

				    		var conferencia2 = this.vendas.vendaBruta - totalPayments; 

				    		var diferenca = (conferencia1) - (conferencia2);

					    	this.caixa_aberto.diferenca_final = diferenca.toFixed(2);
					    	this.caixa_aberto.vendas = this.vendas.vendaBruta;
				    	},

				    	substract: function(ev){
				    		ev.preventDefault()
				    		var that = this

				    		if(!this.substracted){

					    		if(!this.unlock){
					    			this.unlock = true;
					    			return false
					    		}
				    			that.caixa_anterior.payments.items.forEach(function(oldPayment){

					    			that.caixa_aberto.payments.items.forEach(function(payment){

						    			if(oldPayment.label == payment.label){
						    				payment.value = parseFloat(payment.value) - parseFloat(oldPayment.value)

						    				if(payment.value < 0){
						    					payment.value = 0;
						    					swal('oO!', 'PRESTA ATENÇÃO AI !!!!', 'error');
						    				}
						    			}

						    		});

					    		});

				    			this.unlock = false;

				    			this.calcula();
				    		}

				    		this.substracted = true;
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

					    		if(this.caixa_aberto.diferenca_final > 50 && this.user_type != 'super_adm'){
					    			console.log('dddd: ' + this.caixa_aberto.diferenca_final);
					    			swal('Atenção!', 'Confira o caixa antes de fecha-lo, não será aceito fechamento de caixa com diferença superior a R$50,00.', 'warning');
					    			this.loading = false;
					    			return false;
					    		}

					    		if(this.caixa_aberto.diferenca_final < -50 && this.user_type != 'super_adm'){
					    			swal('Atenção!', 'Confira o caixa antes de fecha-lo, não será aceito fechamento de caixa com diferença superior a R$50,00.', 'warning');
					    			this.loading = false;
					    			return false;
					    		}

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

				    	salva: function(ev) {
				    		ev.preventDefault();
				    		var that = this;

				    		if(!this.loading){

				    			this.loading = true;

					    		this.calcula();

					    		this.$http.post('/admin/financeiro/caixa/update', this.caixa_aberto).then(function (response) {
								       swal(response.data.retorno.title, response.data.retorno.message, response.data.retorno.type);

								       setTimeout(function()
									    {
									    	location.reload();
									    }, 3000);
								       that.authorization = false;
								       that.loading = false;

								    }, function (response) {

								      	console.log('Erro ao tentar fechar o caixa.');

								      	swal('ERRO', 'ERRO AO SALVAR O CAIXA! TENTE NOVAMENTE E VERIFIQUE SE O CAIXA FOI FECHADO. INFORME AO ASSISTÊNCIA.', 'error');
								      	that.authorization = false;
								      	that.loading = false;
								    });
				    		}

				    	},
				    	
				    	calculaAbertura: function(){
				    		var diferenca = 
				    			parseFloat(this.abrir_caixa.payments.register_init_value)
				    			-
				    			parseFloat(this.caixa_anterior.vr_emCaixa);

				    		this.abrir_caixa.diferenca_inicial = diferenca.toFixed(2);

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