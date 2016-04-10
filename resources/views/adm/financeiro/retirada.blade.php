@extends('layout/admin')

@section('conteudo')

<div id="elRetirada">
<h2 class="text-right">Retiradas</h2><br>

	@include('errors.messages')

	<div class="row">
		<div class="col-md-6">

			<div class="panel panel-default">
				<div class="panel-heading">Detalhes retirada</div>
				<div class="panel-body">

				<!-- <form action="'admin.financeiro.retiradaPost')" method="POST"> -->

					{{ csrf_field() }}

						<div class="form-group">
								<select class="form-control"v-model="retirada.tipo">
									<option value="Sangria">Sangria</option>
									<option value="Vale Transporte">Vale Transporte</option>
									<option value="Bonificação">Bonificação</option>
									<option value="Taxa de serviço">Taxa de serviço</option>
									<option value="Adiantamento">Adiantamento</option>
									<option value="Pagamento">Pagamento</option>
									<option value="Outros">Outros</option>
								</select>
						</div>

						<div class="form-group">
							<label>Descrição adicional</label>
							<input type="text" 
								name="descricao" 
								class="form-control"
								v-model="retirada.descricao" />
						</div>

						<div class="form-group">
							<label>Valor</label>
							<input type="text" 
								name="valor" 
								class="form-control maskValor"
								v-model="retirada.valor" />
						</div>

		                <div class="form-group" v-on:click="retiraCaixa">
		                	<input type="hidden" name="retirado_caixa" value="0" />
		                	<label >Valor retirado do caixa?</label><br>
		                    <input type="checkbox" 
	                    		class="form-control" 
	                    		name="retirado_caixa" 
	                    		value="1" 
	                    		data-toggle="toggle" 
	                    		data-onstyle="danger" 
	                    		data-on="Sim" 
	                    		data-off="Não",

		                    />
		                  
		                </div>

						<div class="form-group">
								<select class="form-control"v-model="retirada.fontePgto">
									<option value="Dinheiro Caixa">Dinheiro Caixa</option>
									<option value="Dinheiro externo">Dinheiro externo</option>
									<option value="Conta Loja">Conta Loja</option>
									<option value="Conta MB">Conta MB</option>
									<option value="Dinheiro Igor">Dinheiro Igor</option>
									<option value="Outros">Outros</option>
								</select>
						</div>

		                <div class="form-group" v-on:click="registraPagamento">
		                	<input type="hidden" name="retirado_caixa" value="0" />
		                	<label >Registrar retirada no financeiro?</label><br>
		                    <input type="checkbox" 
	                    		class="form-control" 
	                    		name="registra_pagamento" 
	                    		value="1" 
	                    		data-toggle="toggle" 
	                    		data-onstyle="danger" 
	                    		data-on="Sim" 
	                    		data-off="Não",

		                    />
		                </div>




					
						<div class="form-group">
							{!! Form::select('funcionario_id', $funcionarios, null, ['class' => 'form-control', 
							'single' => 'single', 
							'id' => 'funcionarios', 
							'placeholder' => 'Selecione um funcionario',
							'v-model' => 'retirada.funcionario_id'])   !!}
						</div>

						<div class="form-group" v-on:click="pagamentoFuncionario" v-show="retirada.funcionario_id">
		                	<input type="hidden" name="retirado_caixa" value="0" />
		                	<label >O valor é algum tipo de desconto na folha de pagamento?</label><br>
		                	<label >Ex. Adiantamento / Mau uso / INSS</label><br>
		                    <input type="checkbox" 
	                    		class="form-control" 
	                    		name="is_debito" 
	                    		value="1" 
	                    		data-toggle="toggle" 
	                    		data-onstyle="danger" 
	                    		data-on="Sim" 
	                    		data-off="Não",

		                    />
		                  
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
							:disabled="! retirada.tipo"
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

	<pre> @{{ $data | json }}</pre>
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
				    	retirada: {
				    		tipo: '',
				    		valor: '',
					    	descricao: '',
					    	retiradoCaixa: 0,
					    	funcionario_id: '',
					    	is_debito: '',
					    	motivo: '',
					    	init: '',
					    	end: '',
					    	registraPagamento: '',
					    	fontePgto: ''
					    },
					    response: {
					    	error: {
						    	message: '',
						    	status_code: '',
					    	}
					    }
				  
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



					      	}, function (response) {
					          	console.log(response.data);
					          	swal("ERRO!", "Erro ao cadastrar retirada, ligue para o Igor.", "warning");
					      	});
				    	}
				    },
				});


			</script>

	    @stop

@stop