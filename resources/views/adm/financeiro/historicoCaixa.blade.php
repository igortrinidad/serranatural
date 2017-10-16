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

<div id="elHistoricoCaixa">
	<h2 class="text-right">Histórico de caixas</h2><br>

	@include('errors.messages')

	<div v-show="loading">
		@include('utils.loading-full')
	</div>


	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label>Inicio</label>
				<input class="form-control" v-model="init" data-mask="00/00/0000">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>Término</label>
				<input class="form-control" v-model="end" data-mask="00/00/0000">
			</div>
		</div>

		<div class="col-md-4">
			<div class="form-group m-t-25">
				<button class="btn btn-primary btn-block" @click="getCaixas()">Alterar</button>
			</div>
		</div>
		
	</div>

	<div class="" v-if="user_type == 'super_adm'">
		

		<div class="row">
			<div class="col-md-12 col-xs-12 text-center">

				<h3>Resumo
					<button class="btn btn-default pull-right" @click="showResumo = !showResumo" v-if="!showResumo">+</button>
					<button class="btn btn-default pull-right" @click="showResumo = !showResumo" v-if="showResumo">-</button>
				</h3>

				<hr>				
			</div>

		</div>

		<div class="" v-if="showResumo">

			<div class="row">
				<div class="col-md-3 col-xs-6 text-center">
					<div class="panel panel-default">
						<h5>Vendas total</h5>
						<p>@{{insights.sell_total | formatCurrency}}</p>
					</div>
				</div>

				<div class="col-md-3 col-xs-6 text-center">
					<div class="panel panel-default">
						<h5>Média de vendas</h5>
						<p>@{{insights.sell_medium | formatCurrency}}</p>
					</div>
				</div>

				<div class="col-md-3 col-xs-6 text-center">
					<div class="panel panel-default">
						<h5>Menor de venda</h5>
						<p>@{{insights.sell_min | formatCurrency}}</p>
					</div>
				</div>

				<div class="col-md-3 col-xs-6 text-center">
					<div class="panel panel-default">
						<h5>Maior de venda</h5>
						<p>@{{insights.sell_max | formatCurrency}}</p>
					</div>
				</div>

				<div class="col-md-3 col-xs-6 text-center">
					<div class="panel panel-default">
						<h5>Número de caixas</h5>
						<p>@{{insights.numbers_of_caixas}}</p>
					</div>
				</div>

				<div class="col-md-3 col-xs-6 text-center">
					<div class="panel panel-default">
						<h5>Total cartões</h5>
						<p>@{{insights.total_sell_cards | formatCurrency}}</p>
					</div>
				</div>

				<div class="col-md-3 col-xs-6 text-center">
					<div class="panel panel-default">
						<h5>Total dinheiro</h5>
						<p>@{{insights.total_sell_money | formatCurrency}}</p>
					</div>
				</div>

				<div class="col-md-3 col-xs-6 text-center">
					<div class="panel panel-default">
						<h5>Maior diferença positiva</h5>
						<p>@{{insights.bigger_positive_diff.total | formatCurrency}}</p>
						<p>@{{insights.bigger_positive_diff.user_name}}</p>
					</div>
				</div>

				<div class="col-md-3 col-xs-6 text-center">
					<div class="panel panel-default">
						<h5>Maior diferença negativa</h5>
						<p>@{{insights.bigger_negative_diff.total | formatCurrency}}</p>
						<p>@{{insights.bigger_negative_diff.user_name}}</p>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 col-xs-12 text-center">
					<h3>Cartões</h3>
					<hr>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 col-xs-12">
					<div class="col-md-3 col-xs-6 text-center" v-for="card in insights.total_by_cards">
						<div class="panel panel-default">
							<h5>Total @{{card.label}}</h5>
							<p>@{{card.value | formatCurrency}}</p>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 col-xs-12 text-center">
					<h3>Por dia da semana</h3>
					<hr>
				</div>
			</div>

			<div class="row">
				<div class="col-md-2 col-xs-6 text-center" v-for="dow in insights.sell_by_dow">
					<div class="panel panel-default">
						<h5>@{{dow.dow}}</h5>
						<p>Max: @{{dow.max | formatCurrency}}</p>
						<p>Min: @{{dow.min | formatCurrency}}</p>
						<p>Med: @{{dow.med | formatCurrency}}</p>
						<p>Qtde caixas: @{{dow.total_caixas}}</p>
						<p>Valor total: @{{dow.total_sell | formatCurrency}}</p>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 col-xs-12 text-center">
					<h3>Por semana do mês</h3>
					<hr>
				</div>
			</div>

			<div class="row">
				<div class="col-md-2 col-xs-6 text-center" v-for="week in insights.sell_by_week">
					<div class="panel panel-default">
						<h5>Semana @{{week.week}}</h5>
						<p>Max: @{{week.max | formatCurrency}}</p>
						<p>Min: @{{week.min | formatCurrency}}</p>
						<p>Med: @{{week.med | formatCurrency}}</p>
						<p>Qtde caixas: @{{week.total_caixas}}</p>
						<p>Valor total: @{{week.total_sell | formatCurrency}}</p>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 col-xs-12 text-center">
					<h3>Por mês</h3>
					<hr>
				</div>
			</div>

			<div class="row">
				<div class="col-md-2 col-xs-6 text-center" v-for="month in insights.sell_by_month">
					<div class="panel panel-default">
						<h5>Mês @{{month.month}}</h5>
						<p>Max: @{{month.max | formatCurrency}}</p>
						<p>Min: @{{month.min | formatCurrency}}</p>
						<p>Med: @{{month.med | formatCurrency}}</p>
						<p>Qtde caixas: @{{month.total_caixas}}</p>
						<p>Valor total: @{{month.total_sell | formatCurrency}}</p>
					</div>
				</div>
			</div>
			
		</div>


	</div>

	<div class="row">
		<div class="col-md-12 col-xs-12 text-center">
			<h3>Lista de caixas</h3>
			<hr>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">

			<div class="panel panel-default">
				<div class="panel-heading">Caixas</div>
				<div class="panel-body">

					<div v-for="caixa in caixas" v-if="caixa.payments" track-by="$index">

						<div class="row" style="cursor: pointer" v-on:click="mostraVendas(caixa, $index)">
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
								<label>Data abertura</label>
									<input class="form-control" v-model="caixa.dt_abertura | moment 'DD/MM/YYYY HH:mm:ss'" disabled>
								</div>
							</div>

							<div class="col-md-4 col-xs-12">
								<div class="form-group">
								<label>Responsável abertura</label>
									<input class="form-control" v-model="caixa.usuario_abertura.name" disabled>
								</div>
							</div>

							<div class="col-md-4 col-xs-12">
								<div class="form-group">
								<label>Valor abertura</label>
									<input class="form-control" v-model="caixa.payments.register_init_value  | formatCurrency" disabled>
								</div>
							</div>

							<div class="col-md-4 col-xs-12">
								<div class="form-group">
								<label>Responsável fechamento</label>
									<input class="form-control" v-model="caixa.usuario_fechamento.name" disabled>
								</div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
								<label>Data fechamento</label>
									<input class="form-control" v-model="caixa.dt_fechamento | moment 'DD/MM/YYYY HH:mm:ss'" disabled>
								</div>
							</div>

							<div class="col-md-4 col-xs-12">
								<div class="form-group">
								<label>Valor fechamento</label>
									<input class="form-control" v-model="caixa.payments.register_end_value  | formatCurrency" disabled>
								</div>
							</div>

							<div class="col-md-4 col-xs-12">
								<div class="form-group">
								<label>Retiradas total</label>
									<input class="form-control" v-model="caixa.total_retirada  | formatCurrency" disabled>
								</div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
								<label>Venda total</label>
									<input class="form-control" v-model="caixa.vendas  | formatCurrency" disabled>
								</div>
							</div>

							<div class="col-md-4 col-xs-12">
								<div class="form-group">
								<label>Diferença</label>
									<input class="form-control" v-model="caixa.diferenca_final  | formatCurrency" disabled v-bind:class="{ 'warning': caixa.diferenca_final < 0, 'success': caixa.diferenca_final >= 0 }">
								</div>
							</div>
						</div>
						
						<table class="table table-bordered">
						    <thead>
						        <tr>
						            <th>Vendas total dinheiro</th>
						            <th>Vendas total cartão</th>
						            <th>Contas aberto total</th>
						            <th v-for="item in caixa.payments.items">@{{item.label}}</th>
						        </tr>
						    </thead>
						    <tbody>
						        <tr v-if="caixa.payments">
						            <td >@{{caixa.payments.total_money  | formatCurrency}}</td>
						            <td>@{{caixa.payments.total_cards  | formatCurrency}}</td>
						            <td>@{{caixa.contas.total  | formatCurrency}}</td>
						            <td v-for="item in caixa.payments.items">R$ @{{item.value}}</td>
						        </tr>
						    </tbody>
						</table>

						<hr line-height="3px">
					</div>

				</div>
			
			</div>
		</div>
	</div>


		<!-- Modal -->
<div class="modal fade" id="modalCaixaSelected" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Caixa: @{{caixaSelected.caixa.id}}</h4>
      </div>
      <div class="modal-body">

		<!-- DETALHES CAIXA -->
	    <div class="row">
	     	<div class="col-md-12 col-xs-12">
		     	<fieldset>
		     		<legend>Detalhes caixa</legend>
			      	<div class="col-md-6">
			      		<label>Data abertura</label>
			      		<p>@{{caixaSelected.caixa.dt_abertura | moment 'DD/MM/YYYY HH:mm:ss'}}</p>
			      	</div>
			      	<div class="col-md-6">
			      		<label>Data fechamento</label>
			      		<p>@{{caixaSelected.caixa.dt_fechamento | moment 'DD/MM/YYYY HH:mm:ss'}}</p>
			      	</div>
			      	<div class="col-md-6">
			      		<label>Responsável abertura</label>
			      		<p>@{{caixaSelected.caixa.usuario_abertura.name}}</p>
			      	</div>
			      	<div class="col-md-6">
			      		<label>Responsável fechamento</label>
			      		<p>@{{caixaSelected.caixa.usuario_fechamento.name}}</p>
			      	</div>
			      	<div class="col-md-4">
			      		<p>Valor abertura</p>
			      		<h3 v-if="!isEditing">@{{caixaSelected.caixa.payments.register_init_value  | formatCurrency}}</h3>
			      		<input v-if="isEditing" class="form-control" v-model="caixaSelected.caixa.payments.register_init_value" @blur="calcula()">
			      	</div>

			      	<div class="col-md-4">
			      		<p>Valor fechamento</p>
						<h3 v-if="!isEditing">@{{caixaSelected.caixa.payments.register_end_value  | formatCurrency}}</h3>
						<input v-if="isEditing" class="form-control" v-model="caixaSelected.caixa.payments.register_end_value" @blur="calcula()">
			      	</div>

			      	<div class="col-md-4">
			      		<p>Vendas no caixa</p>
						<h3>@{{caixaSelected.fetched.vendaBruta  | formatCurrency}}</h3>
			      	</div>
					
					<div class="col-md-4" v-for="payment in caixaSelected.caixa.payments.items">
						<p>@{{payment.label}}</p>
						<h3 v-if="!isEditing">@{{payment.value | formatCurrency}}</h3>
						<input v-if="isEditing" class="form-control" v-model="payment.value" @blur="calcula()">

					</div>

					<div class="col-md-6">
			      		<p>Diferença final</p>
						<h3>@{{ caixaSelected.caixa.diferenca_final | formatCurrency }}</h3>
			      	</div>

			      	<div class="col-md-12">
			      		<label>Observações</label>
			      		<p>@{{{ caixaSelected.caixa.obs }}}</p>
			      	</div>

		      	</fieldset>
	     	</div>
	    </div>

		<!-- RETIRADAS -->
		<div class="row">
			<div class="col-md-12 col-xs-12">

				<fieldset>
					<legend>Retiradas</legend>
				    <table class="table table-bordered table-striped">
					    <thead>
					        <tr>
					            <th>Valor</th>
					            <th>Tipo</th>
					            <th>Descrição</th>
					            <th>Quem fez?</th>
					            <th>Para quem?</th>
					        </tr>
					    </thead>
					    <tbody>
					        <tr v-for="retirada in caixaSelected.caixa.retiradas">
					            <td>@{{retirada.valor}}</td>
					            <td>@{{retirada.tipo}}</td>
					            <td>@{{retirada.descricao}}</td>
					            <td>@{{retirada.usuario.name}}</td>
					            <td v-if="retirada.funcionario">@{{retirada.funcionario.nome}}</td>
					            <td v-if="!retirada.funcionario">--</td>
					        </tr>
					    </tbody>
					</table>
				</fieldset>
				
			</div>
		</div>

		<!-- CONTAS EM ABERTO -->
		<div class="row">
			<div class="col-md-12 col-xs-12">

				<fieldset>
					<legend>Contas em aberto</legend>
				    <table class="table table-bordered table-striped">
					    <thead>
					        <tr>
					            <th>Data</th>
					            <th>Cliente</th>
					            <th>Telefone</th>
					            <th>Valor</th>
					            <th>Quem autorizou?</th>
					        </tr>
					    </thead>
					    <tbody v-if="caixaSelected && caixaSelected.caixa.contas">
					        <tr v-for="conta in caixaSelected.caixa.contas.contas_abertas | orderBy 'cliente'">
					            <td>@{{conta.data_init}}</td>
					            <td>@{{conta.cliente}}</td>
					            <td>@{{conta.telefone}}</td>
					            <td>@{{conta.valor}}</td>
					            <td>@{{conta.usuario}}</td>
					        </tr>
					    </tbody>
					</table>
				</fieldset>
				
			</div>
		</div>

		<!-- CONTAS PAGAS -->
		<div class="row">
			<div class="col-md-12 col-xs-12">

				<fieldset>
					<legend>Contas liquidadas</legend>
				    <table class="table table-bordered table-striped">
					    <thead>
					        <tr>
					            <th>Data</th>
					            <th>Cliente</th>
					            <th>Valor</th>
					            <th>Quem autorizou entrada?</th>
					            <th>Quem autorizou baixa?</th>
					        </tr>
					    </thead>
					    <tbody v-if="caixaSelected.caixa.contas && caixaSelected.caixa.contas">
					        <tr v-for="conta in caixaSelected.caixa.contas.contas_pagas">
					            <td>@{{conta.data_pay}}</td>
					            <td>@{{conta.cliente}}</td>
					            <td>@{{conta.valor}}</td>
					            <td>@{{conta.usuario}}</td>
					            <td>@{{conta.usuario_pay}}</td>
					        </tr>
					    </tbody>
					</table>
				</fieldset>
				
			</div>
		</div>

		<!-- VENDAS REALIZADAS -->
		<div class="row">
			<div class="col-md-12 col-xs-12">
				<fieldset>
					<legend>Vendas realizadas neste caixa</legend>

				    <table class="table table-bordered">
						<thead>
							<tr>
								<th>Valor</th>
								<th>Data</th>
								<th>Ver conta</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="venda in caixaSelected.fetched.vendas_resumo">
								<td >R$ @{{(venda.valor/100).formatMoney(2, ',', '.')}}</td>
								<td>@{{venda.data}}</td>
								<td><a href="@{{venda.url}}" target="_blank">Ver recibo</td>
							</tr>
							<tr>
								<td colspan="2">Total de vendas</td>
								<td>@{{ caixaSelected.fetched.vendas_resumo.length }}</td>
							</tr>

						</tbody>
					</table>
					
				</fieldset>
			</div>
		</div>

		<!-- REABRIR CAIXA -->
		<div class="row">
	      	<div class="col-md-12">
	      		<fieldset>
	      			<legend>Reabrir caixa</legend>
	  				<form method="post" action="/admin/financeiro/caixa/reabreCaixa/@{{caixaSelected.caixa.id}}">
						{!! csrf_field() !!}

						<div class="form-group">
							<label>Senha</label>
							<input type="password" name="senha" class="form-control"/>
						</div>

						<button type="submit" class="btn btn-danger btn-block">Reabrir caixa</button>

					</form>
				</fieldset>
	      	</div>
      	</div>

      	<br>
      	<!-- REABRIR CAIXA -->
		<div class="row">
	      	<div class="col-md-12">
	      		<fieldset>
	      			<legend>Baixar estoque caixa</legend>
	  				<form method="post" action="/admin/financeiro/caixa/baixarEstoqueCaixa/@{{caixaSelected.caixa.id}}">
						{!! csrf_field() !!}

						<div class="" v-if="caixaSelected.caixa.estoquebaixadoem == '0000-00-00 00:00:00'">
							<button type="submit" class="btn btn-danger btn-block">Baixar estoque Caixa</button>
						</div>

						<div class="" v-if="caixaSelected.caixa.estoquebaixadoem != '0000-00-00 00:00:00'">
							<h3>@{{caixaSelected.caixa.estoquebaixadoem}}</h3>
						</div>

					</form>
				</fieldset>
	      	</div>
      	</div>
		
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" @click="showEditCaixa()" v-show="!isEditing" :disabled="user_type != 'super_adm'">Editar caixa</button>
        <button type="button" class="btn btn-danger" @click="salva()" v-show="isEditing">Salvar alterações</button>
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



				accounting.settings = {
				    currency: {
				        symbol : "R$ ",   // default currency symbol is '$'
				        format: "%s%v", // controls output: %s = symbol, %v = value/number (can be object: see below)
				        decimal : ",",  // decimal point separator
				        thousand: ".",  // thousands separator
				        precision : 2   // decimal places
				    },
				    number: {
				        precision: 2,  // default precision on numbers is 0
				        thousand: ".",
				        decimal : ","
				    }
				}

				Vue.config.debug = true;
				Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#_tokenLaravel').getAttribute('value');

				Vue.filter('formatCurrency', function(value){
				    return accounting.formatMoney(parseFloat(value))
				})

				var vm = new Vue({
				    el: '#elHistoricoCaixa',
				    data: {
				    	init: moment().startOf('month').format('DD/MM/YYYY'),
				    	end: moment().endOf('month').format('DD/MM/YYYY'),
				    	showResumo: true,
				    	isEditing: false,
				    	loading: false,
				    	caixas: [],
				    	retorno: [],
				    	user_type: '{{Auth::user()->user_type}}',
				    	caixaSelected: {
				    		caixa: {
				    			estoquebaixadoem: '',
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
						    	usuario_abertura: {name: ''},
						    	usuario_fechamento: {name: ''}
				    		}, 
				    		fetched: {
				    			vendaBruta: '0',
				    			vendas_resumo: []
				    		}
				    	},
				    	caixaAnterior: {
				    		caixa: {
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
						    	usuario_abertura: {name: ''},
						    	usuario_fechamento: {name: ''}
				    		}, 
				    		fetched: {
				    			vendaBruta: '0',
				    			vendas_resumo: []
				    		},

				    	},
			    		insights: {
			    			sell_total: 0,
			    			sell_medium: 0,
			    			numbers_of_caixas: 0,
			    			total_sell_money: 0,
			    			total_sell_cards: 0,
			    			total_by_cards: [],
			    			sell_by_dow: [],
			    			sell_by_week: [],
			    			sell_by_month: [],
			    			min_sell_by_day: [],
			    			bigger_negative_diff: {
			    				user_name: '',
			    				total: 0
			    			},
			    			bigger_positive_diff: {
			    				user_name: '',
			    				total: 0
			    			},

			    		}
				    },

				    filters: {
				    	moment: {
				    		read: function(val, format){
				    			return moment(val).format(format)
				    		},
				    		write: function(val, format){
				    		    let that = this
				    		
				    			return moment(val).format(format)
				    		    
				    		},
				    	}
				    },

				    ready: function(){
				    	this.getCaixas();
				    },
				    methods:
				    {	
				    	showEditCaixa: function(){
				    	    let that = this
				    		
				    		this.isEditing = true;
				    	    
				    	},

				    	getCaixas: function(){
				    	    let that = this
				    	
					    	var self = this;	
					      	// GET request
					      	this.$http.post('/admin/financeiro/historico/caixa/fetchByTime', {init: moment(self.init, 'DD/MM/YYYYY').format('YYYY-MM-DD'), end: moment(self.end, 'DD/MM/YYYYY').format('YYYY-MM-DD')}).then(function (response) {
					          	self.caixas = response.data.caixas;
					          	self.retorno = response.data.retorno;
					          	console.log('Caixas carregados com sucesso.');
					          	that.checkInsights();

							}, function (response) {

						      	console.log('Erro ao tentar carregar caixas.');

						    });
				    	    
				    	},

				    	checkInsights: function(){
				    	    let that = this
				    		
				    		var insights = {
				    			sell_total: 0,
				    			sell_medium: 0,
				    			sell_min: 2000,
				    			sell_max: 0,
				    			numbers_of_caixas: 0,
				    			total_sell_money: 0,
				    			total_sell_cards: 0,
				    			total_by_cards: [],
				    			sell_by_dow: [],
				    			sell_by_week: [],
				    			sell_by_month: [],
				    			bigger_negative_diff: {
				    				user_name: '',
				    				total: 0
				    			},
				    			bigger_positive_diff: {
				    				user_name: '',
				    				total: 0
				    			},

				    		}
				    	    
				    	    that.caixas.forEach( function(caixa, index, array){

				    	    	insights.numbers_of_caixas++;
				    	    	insights.sell_total+= parseFloat(caixa.vendas);
				    	    	insights.total_sell_money+= parseFloat(caixa.payments.total_money);
				    	    	insights.total_sell_cards+= parseFloat(caixa.payments.total_cards);


				    	    	caixa.payments.items.forEach( function(payment_type){

				    	    		var index = insights.total_by_cards.indexFromAttr('label', payment_type.label);

				    	    		if(index > -1){
				    	    			insights.total_by_cards[index].value +=parseFloat(payment_type.value);
				    	    		} else {
				    	    			payment_type.value = parseFloat(payment_type.value)
				    	    			insights.total_by_cards.push(payment_type);
				    	    		}

				    	    	})


				    	    	if(insights.sell_max < parseFloat(caixa.vendas)){
				    	    		insights.sell_max = parseFloat(caixa.vendas);
				    	    	}

				    	    	if(insights.sell_min > parseFloat(caixa.vendas)){
				    	    		insights.sell_min = parseFloat(caixa.vendas);
				    	    	}

				    	    	if(insights.bigger_positive_diff.total < parseFloat(caixa.diferenca_final)){
				    	    		insights.bigger_positive_diff.total = parseFloat(caixa.diferenca_final);
				    	    		insights.bigger_positive_diff.user_name = caixa.usuario_fechamento.name;
				    	    	}

				    	    	if(insights.bigger_negative_diff.total > parseFloat(caixa.diferenca_final)){
				    	    		insights.bigger_negative_diff.total = parseFloat(caixa.diferenca_final);
				    	    		insights.bigger_negative_diff.user_name = caixa.usuario_fechamento.name;
				    	    	}

				    	    	//Sell by day of week
				    	    	var indexMaxDayOfWeek = insights.sell_by_dow.indexFromAttr('dow', moment(caixa.created_at).format('dddd'))

				    	    	if(indexMaxDayOfWeek > -1){
				    	    		
				    	    		var dow = insights.sell_by_dow[indexMaxDayOfWeek];

				    	    		if(dow.max < parseFloat(caixa.vendas)){
				    	    			dow.max = parseFloat(caixa.vendas);
				    	    		}

				    	    		if(dow.min > parseFloat(caixa.vendas)){
				    	    			dow.min = parseFloat(caixa.vendas);
				    	    		}

				    	    		dow.total_sell+= parseFloat(caixa.vendas);

				    	    		dow.total_caixas++;
				    	    	} else {

				    	    		var data = {
				    	    			dow: moment(caixa.created_at).locale('pt-BR').format('dddd'),
				    	    			dow_number: moment(caixa.created_at).locale('pt-BR').day(),
				    	    			max: parseFloat(caixa.vendas),
				    	    			min: parseFloat(caixa.vendas),
				    	    			med: parseFloat(caixa.vendas),
				    	    			total_caixas: 1,
				    	    			total_sell: parseFloat(caixa.vendas)
				    	    		}

				    	    		insights.sell_by_dow.push(data)
				    	    	}

				    	    	//Sells by week of the months
				    	    	var indexSellByWeek = insights.sell_by_week.indexFromAttr('week', Math.ceil(moment(caixa.created_at).format('DD') / 7) )

				    	    	if(indexSellByWeek > -1){
				    	    		
				    	    		var week = insights.sell_by_week[indexSellByWeek];

				    	    		if(week.max < parseFloat(caixa.vendas)){
				    	    			week.max = parseFloat(caixa.vendas);
				    	    		}

				    	    		if(week.min > parseFloat(caixa.vendas)){
				    	    			week.min = parseFloat(caixa.vendas);
				    	    		}

				    	    		week.total_sell+= parseFloat(caixa.vendas);

				    	    		week.total_caixas++;

				    	    	} else {

				    	    		var data = {
				    	    			week: Math.ceil(moment(caixa.created_at).format('DD') / 7),
				    	    			max: parseFloat(caixa.vendas),
				    	    			min: parseFloat(caixa.vendas),
				    	    			med: parseFloat(caixa.vendas),
				    	    			total_caixas: 1,
				    	    			total_sell: parseFloat(caixa.vendas)
				    	    		}

				    	    		insights.sell_by_week.push(data)
				    	    	}


				    	    	//Sells by month
				    	    	var indexSellByMonth = insights.sell_by_month.indexFromAttr('month', moment(caixa.created_at).format('MMMM') )

				    	    	if(indexSellByMonth > -1){
				    	    		
				    	    		var month = insights.sell_by_month[indexSellByMonth];

				    	    		if(month.max < parseFloat(caixa.vendas)){
				    	    			month.max = parseFloat(caixa.vendas);
				    	    		}

				    	    		if(month.min > parseFloat(caixa.vendas)){
				    	    			month.min = parseFloat(caixa.vendas);
				    	    		}

				    	    		month.total_sell+= parseFloat(caixa.vendas);

				    	    		month.total_caixas++;

				    	    	} else {

				    	    		var data = {
				    	    			month: moment(caixa.created_at).format('MMMM'),
				    	    			max: parseFloat(caixa.vendas),
				    	    			min: parseFloat(caixa.vendas),
				    	    			med: parseFloat(caixa.vendas),
				    	    			total_caixas: 1,
				    	    			total_sell: parseFloat(caixa.vendas)
				    	    		}

				    	    		insights.sell_by_month.push(data)
				    	    	}


				    	    	//Se for o ultimo item chama as funções que calculam a media e pusha os dados
				    	    	if(index+1 == array.length){
				    	    		insights.sell_medium = insights.sell_total / insights.numbers_of_caixas;

				    	    		insights.sell_by_dow.forEach( function(dow){
				    	    			dow.med = dow.total_sell / dow.total_caixas;
				    	    		})

				    	    		insights.sell_by_week.forEach( function(week){
				    	    			week.med = week.total_sell / week.total_caixas;
				    	    		})

				    	    		insights.sell_by_month.forEach( function(month){
				    	    			month.med = month.total_sell / month.total_caixas;
				    	    		})

				    	    		insights.sell_by_dow.sort( function(a, b){return a.dow_number-b.dow_number});
				    	    		insights.sell_by_week.sort( function(a, b){return a.week-b.week});
				    	    		insights.sell_by_month.sort( function(a, b){return a.month-b.month});

				    	    		that.pushInsights(insights)
				    	    	}

				    	    });
				    	},

				    	pushInsights: function(insights){
				    	    let that = this
				    	
				    		that.insights = insights;
				    	    
				    	},



				    	mostraVendas: function(caixa, index){
					    	var self = this;	
					      	// GET request
					      	
					      	if(caixa.usuario_fechamento){

					      		self.loading = true;

					      		self.caixaSelected.caixa = caixa;
					      		self.$set('caixaAnterior', this.caixas[index+1]);

						      	$('#modalCaixaSelected').modal('show');

						      	this.$http.post('/admin/financeiro/historico/caixa/fetchVendasResume', caixa).then(function (response) {

						          	self.caixaSelected.fetched = response.data;

						          	console.log(self.caixaSelected);
						          	self.loading = false;
						          	self.calcula();

								}, function (response) {
									self.loading = false;
							      	console.log('Erro ao tentar carregar caixas.');

							    });
					      	}
					      	
				    	},
				    	calcula: function(ev) {
				    		var that = this
				    		this.substracted = false;

				    		var totalPayments = 0;

				    		that.caixaSelected.caixa.payments.items.forEach(function(payment){
				    			if(isNaN(payment.value) || !payment.value){
				    				payment.value = 0;
				    			}
				    			totalPayments += parseFloat(payment.value);

				    		});

				    		if (!that.caixaSelected.caixa.payments.register_end_value || isNaN(that.caixaSelected.caixa.payments.register_end_value)) that.caixaSelected.caixa.payments.register_end_value = 0;

				    		that.caixaSelected.caixa.payments.total_cards = totalPayments;
				    		that.caixaSelected.caixa.payments.total_money = parseFloat(that.caixaSelected.caixa.payments.register_end_value) + 
				    			parseFloat(that.caixaSelected.caixa.total_retirada) -
				    			parseFloat(that.caixaSelected.caixa.payments.register_init_value);
				    		that.caixaSelected.caixa.payments.total_accounts = parseFloat(that.caixaSelected.caixa.contas.total) - parseFloat(that.caixaAnterior.contas.total);

				    		var conferencia1 = 
				    			( parseFloat( that.caixaSelected.caixa.payments.register_end_value )
				    			+ parseFloat( that.caixaSelected.caixa.total_retirada ) 
				    			- (parseFloat( that.caixaSelected.caixa.payments.register_init_value) + parseFloat( that.caixaAnterior.contas.total ) ) );

				    		var conferencia2 = parseFloat( that.caixaSelected.fetched.vendaBruta.replace(',', '') ) - (totalPayments + parseFloat( that.caixaSelected.caixa.contas.total )); 

				    		var diferenca = (conferencia1) - (conferencia2);

				    		console.log('Conferencia 1: ' + conferencia1);
				    		console.log('Conferencia 2: ' + conferencia2);
				    		console.log(': ' + diferenca);

					    	that.caixaSelected.caixa.diferenca_final = diferenca.toFixed(2);
					    	that.caixaSelected.caixa.vendas = that.caixaSelected.fetched.vendaBruta.replace(',', '');
				    	},

				    	salva: function() {
				    		var that = this;

				    		if(!this.loading){

				    			this.loading = true;

					    		this.calcula();

					    		this.$http.post('/admin/financeiro/caixa/update', this.caixaSelected.caixa).then(function (response) {
								       swal(response.data.retorno.title, response.data.retorno.message, response.data.retorno.type);

								       setTimeout(function()
									    {
									    	location.reload();
									    }, 3000);
								       that.isEditing = false;
								       that.loading = false;

								    }, function (response) {

								      	console.log('Erro ao tentar fechar o caixa.');

								      	swal('ERRO', 'ERRO AO SALVAR O CAIXA! TENTE NOVAMENTE E VERIFIQUE SE O CAIXA FOI FECHADO. INFORME AO ASSISTÊNCIA.', 'error');
								      	that.authorization = false;
								      	that.loading = false;
								    });
				    		}

				    	},

					},
				});


			</script>

	    @stop

@stop