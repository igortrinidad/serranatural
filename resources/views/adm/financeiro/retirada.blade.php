@extends('layout/admin')

@section('conteudo')

<div id="elRetirada">
<h2 class="text-right">Retiradas</h2><br>

	@include('errors.messages')

	<div v-show="loading">
		@include('utils.loading-full')
	</div>

	<div class="row">
		<div class="col-md-6">

			<div class="panel panel-default">
				<div class="panel-heading">Detalhes retirada</div>
				<div class="panel-body">

				<!-- <form action="'admin.financeiro.retiradaPost')" method="POST"> -->

					{{ csrf_field() }}

						<div class="form-group">
							<label>Motivo retirada</label>
								<select class="form-control"v-model="retirada.tipo">
									<option value="" selected disabled>Selecione uma opção</option>
									<option value="Sangria">Sangria</option>
									<option value="Vale Transporte">Vale Transporte</option>
									<option value="Bonificação">Bonificação</option>
									<option value="Rateio taxa de serviço">Taxa de serviço</option>
									<option value="Adiantamento">Adiantamento</option>
									<option value="Pagamento">Pagamento</option>
									<option value="Outros">Outros</option>
								</select>
						</div>

						

						<div class="form-group">
							<label>Valor</label>
							<input type="text" 
								name="valor" 
								class="form-control maskValor"
								v-model="retirada.valor" />
						</div>
						
		                <div class="form-group" >
		                	<input type="hidden" name="retirado_caixa" value="0" />
		                	<label >Valor retirado do caixa?</label><br>
		                    <button class="btn btn-danger" v-show="retirada.retiradoCaixa" v-on:click="retiraCaixa">Sim</button>
							<button class="btn btn-default" v-show="!retirada.retiradoCaixa" v-on:click="retiraCaixa">Não</button>
		                  
		                </div>

		                <div class="form-group">
		                	<label>Usuario</label>
							<select class="form-control" v-model="retirada.usuario_id">
								<option v-for="usuario in users" v-bind:value="usuario.id">@{{usuario.name}}</option>
							</select>
						</div>

		                <div class="form-group">
							<label>Senha operação</label>
							<input type="password" 
								name="senha_operacao" 
								class="form-control"
								v-model="retirada.senha_operacao" />
						</div>

		                <div class="form-group">
							<label>Observações (informe o motivo dessa retirada - obrigatório)</label>
							<input type="text" 
								name="descricao" 
								class="form-control"
								v-model="retirada.descricao" />
						</div>

						

						<div class="form-group">
							<label>Origem retirada</label>
								<select class="form-control" v-model="retirada.fontePgto">
									<option value="" selected disabled>Selecione uma opção</option>
									<option value="Dinheiro Caixa">Dinheiro Caixa</option>
									<option value="Dinheiro externo">Dinheiro externo</option>
									<option value="Conta Loja">Conta Loja</option>
									<option value="Conta MB">Conta MB</option>
									<option value="Dinheiro Igor">Dinheiro Igor</option>
									<option value="Outros">Outros</option>
								</select>
						</div>

		                <div class="form-group" >
		                	<input type="hidden" name="retirado_caixa" value="0" />
		                	<label >Registrar retirada no financeiro?</label><br>
		                	<small>Ex. vale-transporte, adiantamento, pagamentos de contas gas entre outras.</small><br>
		                    <button class="btn btn-danger" 
		                    	v-show="retirada.registraPagamento"
		                    	v-on:click="registraPagamento"
		                    >Sim</button>
							<button class="btn btn-default" 
								v-show="!retirada.registraPagamento"
								v-on:click="registraPagamento"
							>Não</button>
		                </div>




					
						<div class="form-group">
							{!! Form::select('funcionario_id', $funcionarios, null, ['class' => 'form-control', 
							'single' => 'single', 
							'id' => 'funcionarios', 
							'placeholder' => 'Selecione um funcionario',
							'v-model' => 'retirada.funcionario_id'])   !!}
						</div>

						<div class="form-group"  v-show="retirada.funcionario_id">
		                	<input type="hidden" name="retirado_caixa" value="0" />
		                	<label >O valor é algum tipo de desconto do pagamento do funcionário?</label><br>
		                	<small>Ex. Adiantamento / Mau uso / INSS</small><br>
		                    <button class="btn btn-danger" 
		                    	v-show="retirada.is_debito"
		                    	v-on:click="pagamentoFuncionario"
		                    >Sim</button>
							<button class="btn btn-default" 
								v-show="!retirada.is_debito"
								v-on:click="pagamentoFuncionario"
							>Não</button>
		                  
		                </div>

						<div class="form-group" v-show="retirada.funcionario_id">
								<label>Referência periodo - início</label>
								<input type="text" v-model="retirada.init" class="form-control datepicker dataCompleta" required/>
						</div>

						<div class="form-group" v-show="retirada.funcionario_id">
								<label>Referência periodo - final</label>
								<input type="text" v-model="retirada.end" class="form-control datepicker dataCompleta" required/>
						</div>
						



						<button type="submit" 
							v-on:click="confirmRetirada($event)" 
							:disabled=" !retirada.tipo || !retirada.valor || !retirada.fontePgto || !retirada.descricao"
							class="btn btn-block btn-primary">Fazer retirada</button>

				</div>
			</div>

		</div>

		<div class="col-md-6">

			<div class="panel panel-default">
				<div class="panel-heading">Instruções</div>
				<div class="panel-body">
					<p>Atenção! As retiradas referente à funcionário constarão nos recibos de pagamento, portanto precisa ter padrão de preenchimento.</p>
					<p><strong>Exemplos de preenchimento</strong></p>
					<p>Vale transporte (10/10/2016 a 17/10/2016)</p>
					<p>Adiantamento</p>
					<p>Desconto mau uso de material (Açaí fora da geladeira)</p>
					<p>Desconto mau uso de material (Quebras de copos e taças)</p>
				</div>
			
			</div>
		</div>

	</div>

</div>


    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/financeiro.js') !!}"></script>

			<script type="text/javascript">

				var $funcionarios = $('#funcionarios')

				$('.maskValor').mask("0000.00", {reverse: true});


				Vue.config.debug = true;
				Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#_tokenLaravel').getAttribute('value');
				var vm = new Vue({
				    el: '#elRetirada',
				    data: 
				    {	
				    	loading: false,
				    	retirada: {
				    		usuario_id: '',
				    		senha_operacao: '',
				    		tipo: '',
				    		valor: '',
					    	descricao: '',
					    	retiradoCaixa: 0,
					    	funcionario_id: '',
					    	is_debito: 0,
					    	motivo: '',
					    	init: '',
					    	end: '',
					    	registraPagamento: 0,
					    	fontePgto: ''
					    },
					    response: {
					    	error: {
						    	message: '',
						    	status_code: '',
					    	}
					    },
					    users: {!! $usuarios !!}
				  
				    },
				    methods:
				    {	
				    	retiraCaixa: function() {
				    		self = this;
				    		if (self.retirada.retiradoCaixa == 0) {
				    			self.retirada.retiradoCaixa = 1;
				    		} else {
				    			self.retirada.retiradoCaixa = 0;
				    		}
				    	},
				    	registraPagamento: function() {
				    		self = this;
				    		if (self.retirada.registraPagamento == 0) {
				    			self.retirada.registraPagamento = 1;
				    		} else {
				    			self.retirada.registraPagamento = 0;
				    		}
				    	},
				    	pagamentoFuncionario: function() {
				    		self = this;
				    		if (self.retirada.is_debito == 0) {
				    			swal("ATENÇÃO!", "O Pagamento será descontado do funcionário, ok?", "warning");
				    			self.retirada.is_debito = 1;
				    		} else {
				    			self.retirada.is_debito = 0;
				    		}
				    	},
				    	confirmRetirada: function(ev) {
				    		ev.preventDefault();
				    		self = this;
				    		swal({   
				    				title: "Tem certeza?",
				    				text: "Você não poderá alterar o valor da retirada novamente!",
				    				type: "warning",
				    				showCancelButton: true,
				    				cancelButtonText: "Cancelar",
				    				confirmButtonColor: "#DD6B55",
				    				confirmButtonText: "Sim, tenho certeza!",
				    				closeOnConfirm: true,
				    				showLoaderOnConfirm: true
				    			}, function(){

				    				self.sendRetirada(); 				
				    				
				    		});
				    	},
				    	sendRetirada: function() {
				    		self = this;
				    		self.loading = true;
				    		console.log('Retirada foi recebida até aqui zé!');
					    	self.$http.post('/admin/financeiro/retiradaPost', self.retirada).then(function (response) 
					    	{
						    	console.log(response.data);
						    	self.retirada.valor = '';
						    	self.retirada.descricao = '';
						    	self.retirada.funcionario_id = '';
						    	self.response.error.message = '';
						    	self.response.error.status_code = '';

						    	swal("Ok!", "Sua Retirada foi cadastrada", "success"); 

						    	self.loading = false;

					      	}, function (response) {
					          	console.log(response.data);
					          	swal("ERRO!", response.data.error.message, "warning");
					          	self.loading = false;
					      	});
				    	}
				    },
				});


			</script>

	    @stop

@stop