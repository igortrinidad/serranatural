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

				<div class="col-md-3">
					<div class="well text-center">
						<h2>R$ @{{caixa_anterior.vendas_online}}</h2>
						<p>Venda Online Anterior</p>
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
										<label>Substrair cartões anteriores</label>
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

								<div class="col-md-6 col-xs-6">
									<div class="form-group">
										<label>Contas em aberto total</label>
										<input type="text" class="form-control" 
											v-model="caixa_aberto.contas.total"
											disabled
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
						<div class="panel-heading">Contas | Total de contas pendentes: R$ @{{caixa_aberto.contas.total}}</div>
						<div class="panel-body">
							<p>Obs. Toda conta adicionada deve ser impressa e arquivada até o momento do pagamento.</p>

							<div class="row">
								<div class="col-md-5">
									<div class="form-group">
										<label>Selecione o cliente</label>
										<select v-model="newConta.cliente" class="form-control">
											  <option v-for="cliente in clientes" v-bind:value="cliente" >
											    @{{ cliente.nome }}
											  </option>
											</select>
									</div>
								</div>

								<div class="col-md-3">
									<div class="form-group">
										<label>Valor</label>
										<input class="form-control moneyFloat" placeholder="Valor do vale" data-mask="000.00" v-model="newConta.valor">
									</div>
								</div>

								<div class="col-md-4">
									<button class="btn btn-block btn-primary m-t-25" @click="addNewConta()">Adicionar conta</button>
								</div>
							</div>

							
							<h3>Contas por cliente *novo</h3>
							

							<span v-for="cliente in caixa_aberto.contas.contas_abertas" v-if="cliente.contas">
								<hr line-height="3px" />
								<h4>@{{cliente.nome}}</h4>
								<h5>Valor total conta: @{{cliente.contasTotal}}</h5>

								<table class="table table-bordered table-hover table-striped">
								    <thead>
								        <tr>
								            <td>Data</td>
								            <td>Valor</td>
								            <td colspan="2">Autorizado por:</td>
								            <td>Quitar</td>
								        </tr>
								    </thead>
								    <tbody>
								    	<tr>
								    		<td colspan="5">
								    			<h5>Contas em aberto</h5>
								    		</td>
								    	</tr>
								        <tr v-for="conta in cliente.contas" v-show="!conta.data_pay">
								            <td>@{{conta.data_init}}</td>
								            <td>R$ @{{conta.valor}}</td>
								            <td colspan="2">@{{conta.usuario_add}}</td>
								            <td class="text-center"><button class="btn btn-primary" @click="liquidaConta(conta)">Quitar notinha</button></td>
								        </tr>
								        <tr>
								        	<td colspan="5"><h5>Contas liquidadas</h5></td>
								        </tr>
								        <tr>
								        	<td>Data liquidação</td>
								        	<td>Valor</td>
								        	<td>Autorizado por</td>
								        	<td>Quem recebeu</td>
								        	<td>Cancelar quitação</td>
								        </tr>
								        <tr v-for="conta in cliente.contas" v-show="conta.data_pay">
								            <td>@{{conta.data_pay}}</td>
								            <td>R$ @{{conta.valor}}</td>
								            <td>@{{conta.usuario_add}}</td>
								            <td>@{{conta.usuario_pay}}</td>
								            <td class="text-center"><button class="btn btn-danger" @click="removeConta(cliente, conta)">Remover conta</button></td>
								        </tr>
								    </tbody>
								</table>

							</span>


							<hr line-height="3px" />

							<h4>Contas *antigo</h4>

							<table class="table table-bordered table-hover table-striped">
							    <thead>
							        <tr>
							            <td>Nome cliente</td>
							            <td>Autorizado por</td>
							            <td>Data</td>
							            <td>Valor</td>
							            <td>Baixar</td>
							        </tr>
							    </thead>
							    <tbody>
							        <tr v-for="cliente in caixa_aberto.contas.contas_abertas" v-show="!cliente.contas">
							            <td>@{{cliente.cliente}}</td>
							            <td>@{{cliente.usuario}}</td>
							            <td>@{{cliente.data_init}}</td>
							            <td>R$ @{{cliente.valor}}</td>
							            <td><button class="btn btn-primary" @click="baixaConta(cliente)">Quitar conta</button></td>
							        </tr>
							    </tbody>
							</table>

							<br>


							
							<h4>Contas arquivadas</h4>

							<table class="table">
							    <thead>
							        <tr>
							            <th width="20%">Data compras</th>
							            <th width="15%">Cliente</th>
							            <th width="10%">Telefone</th>
							            <th width="20%">Valor</th>
							            <th width="10%" class="text-center">Excluir</th>
							        </tr>
							    </thead>
							    <tbody v-for="conta in caixa_aberto.contas.contas_pagas">
								        <tr >
								            <td>@{{conta.data_init}}</td>
								            <td>@{{conta.cliente}}</td>
								            <td>@{{conta.telefone}}</td>
								            <td>R$ @{{conta.valor}}</td>
								            <td class="text-center" @click="removeConta(conta)"><i class="fa fa-trash" style="cursor:pointer;"></i></td>
								        </tr>
								        <tr>
											<td colspan="2">Data quitação</td>
											<td colspan="3">Usuário quitação</td>
								        </tr>
								        <tr>
											<td colspan="2"> @{{conta.data_pay}}</td>
											<td colspan="3"> @{{conta.usuario_pay}}</td>
								        </tr>
							    </tbody>
							</table>



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
							<button class="btn btn-primary btn-block" 
								v-on:click="fecha($event)"
								:disabled="!caixa_aberto.vendas_cielo || !caixa_aberto.vendas_rede || !caixa_aberto.vr_emCaixa || !vendas.vendaBruta || !caixa_aberto.senha"
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
				    			diff_actual_register_to_last: 0,
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
				    		contas: {},
				    		payments: {
				    			register_init_value: 0,
				    			register_end_value: 0,
				    			diff_actual_register_to_last: 0,
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

				          	self.caixa_aberto = response.data.caixa_aberto;
				          	self.caixa_anterior = response.data.caixa_anterior;
				          	self.caixa_is_aberto = true;
				          	self.retiradas = response.data.retiradas;
				          	self.clientes = response.data.clientes;

				          	self.checkContas()

				          	this.$http.get('/admin/financeiro/caixa/consultaVendas').then(function (response) {
						        self.vendas = response.data;
						        self.caixa_aberto.vendas = self.vendas.vendaBruta;

						    }, function (response) {
						      	console.log('Erro ao tentar buscar vendas.');
						    });

				          } else if(response.data.caixa_anterior != null) {

				          	self.caixa_anterior = response.data.caixa_anterior;
				          	self.caixa_is_aberto = false;
				          	self.abrir_caixa.contas = self.caixa_anterior.contas

				          	self.checkContas()

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

				    		console.log(totalPayments);

				    		if (!that.caixa_aberto.payments.register_end_value || isNaN(that.caixa_aberto.payments.egister_end_value)) that.caixa_aberto.payments.egister_end_value = 0;

				    		var conferencia1 = 
				    			( parseFloat( that.caixa_aberto.payments.register_end_value )
				    			+ parseFloat( this.caixa_aberto.total_retirada ) 
				    			- (parseFloat( that.caixa_aberto.payments.register_init_value) + parseFloat( this.caixa_anterior.contas.total ) ) );

				    		console.log('init' + that.caixa_aberto.payments.register_init_value);
				    		console.log('end' + that.caixa_aberto.payments.register_end_value);

				    		var conferencia2 = parseFloat( this.vendas.vendaBruta.replace(',', '') ) - (totalPayments + parseFloat( this.caixa_aberto.contas.total )); 

				    		var diferenca = (conferencia1) - (conferencia2);

				    		console.log('Conferencia 1: ' + conferencia1);
				    		console.log('Conferencia 2: ' + conferencia2);
				    		console.log('Diferença: ' + diferenca);

					    	this.caixa_aberto.diferenca_final = diferenca.toFixed(2);
					    	this.caixa_aberto.vendas = this.vendas.vendaBruta.replace(',', '');
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
						    			}

						    		});

					    		});

				    			this.unlock = false;

				    			this.calcula();
				    		}

				    		this.substracted = true;
				    	},

				    	addNewConta: function(){
				    		var that = this

				    		if(!that.newConta.cliente || !that.newConta.valor){
				    			swal('Ops!', 'Preencha corretamente a conta.', 'error');
				    			return false
				    		}

				    		that.newConta.data_init = moment().format('DD/MM/YYYY HH:mm:ss')
				    		

				    		var cliente = that.newConta.cliente;

				    		var conta = {
				    			data_init: that.newConta.data_init,
				    			data_pay: that.newConta.data_pay,
				    			usuario_add: that.newConta.usuario_add,
				    			usuario_pay: '',
				    			valor: that.newConta.valor
				    		}

				    		var clienteIndex = that.caixa_aberto.contas.contas_abertas.indexFromAttr('id', that.newConta.cliente.id)

				    		if(clienteIndex === false){

				    			cliente.contas = [];
				    			cliente.contas.push(conta);

				    			that.caixa_aberto.contas.contas_abertas.push($.extend(true, {}, cliente))
				    		} else {
				    			that.caixa_aberto.contas.contas_abertas[clienteIndex].contas.push(conta)
				    		}

				    		that.newConta.data_init = '';
				    		that.newConta.data_pay = '';
				    		that.newConta.cliente = '';
				    		that.newConta.valor = '';

				    		that.checkContas();
				    	},

				    	baixaConta: function(conta){
				    		var that = this

				    		that.caixa_aberto.contas.contas_abertas.$remove(conta)

				    		conta.data_pay = moment().format('DD/MM/YYYY HH:mm:ss')

				    		that.caixa_aberto.contas.contas_pagas.push(conta)

				    		that.checkContas()

				    		swal('Ok!', 'Conta liquidada corretamente.', 'success');
				    	},

				    	liquidaConta: function(conta){
				    		var that = this

				    		conta.data_pay = moment().format('DD/MM/YYYY HH:mm:ss');
				    		conta.usuario_pay = that.newConta.usuario_pay;

				    		that.checkContas()

				    		swal('Ok!', 'Conta liquidada corretamente.', 'success');
				    	},

				    	removeConta: function(cliente, index){
				    		var that = this

				    		if(that.newConta.usuario_add != 'Igor Trindade'){
				    			return false
				    			swal('Ops!', 'Você não pode remover uma conta', 'error');

				    		} else {

				    			//Condição para antigo contas
				    			if(!cliente.contas){
				    				that.caixa_aberto.contas.contas_pagas.$remove(cliente);
				    			} else {

					    			cliente.contas.splice(index, 1)

					    			if(!cliente.contas.length){
					    				var index = that.caixa_aberto.contas.contas_abertas.indexFromAttr('id', cliente.id);
					    				that.caixa_aberto.contas.contas_abertas.splice(index, 1);
					    			}
				    				
				    			}
				    		}
				    	},

				    	checkContas: function(){
				    		var that = this

				    		var soma = 0;

				    		if(that.caixa_aberto.contas.contas_abertas.length){

				    			that.caixa_aberto.contas.contas_abertas.forEach( function(cliente){

				    				if(cliente.contas){


					    				cliente.contasTotal = cliente.contas.reduce( function(a, conta){

					    					if(!conta.data_pay){
					    						return a + parseFloat(conta.valor);
					    					} else {
					    						return a;
					    					}
					    					
					    				}, 0);

					    				soma = soma + parseFloat(cliente.contasTotal);
				    					
				    				} else {

				    					soma = soma + parseFloat(cliente.valor);
				    				}

				    			})

				    		}

				    		that.caixa_aberto.contas.total = soma.toFixed(2);

				    		that.calcula();
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