@extends('layout/admin')

@section('conteudo')

<h2 class="text-center">Recibo</h2><br>

<div class="row" id="reciboss" style="font-size:15px !important; font-weight: 500 !important">

	<div class="col-md-10 col-md-offset-1">
		<p >Declaro para os devidos fins que recebi da empresa Serra Natural, CNPJ 20.699.074/0001-75, situada na Alameda do Ingá, 754 - Vila da Serra - Nova Lima os valores abaixo descriminados;</p>

		<br>

					<table class="table table-bordered table-hover table-striped">
					    <thead>
					    	<tr>
								<th colspan="5">Vale-transporte</th>
					    	</tr>
					        <tr>
					            <th>Periodo</th>
					            <th>Periodo</th>
					            <th>Descrição</th>
					            <th>Valor</th>
					        </tr>
					    </thead>
					    <tbody>
					    	@foreach($vts as $vt)
					        <tr>
								<td class="text-center" widtd="15%">{{$vt->init->format('d/m/Y')}}</td>
								<td class="text-center" widtd="15%">{{$vt->end->format('d/m/Y')}}</td>
								<td class="text-center" widtd="40%">{{$vt->tipo}}</td>
								<td class="text-center" widtd="15%">R$ {{number_format($vt->valor, 2, ',', '.')}}</td>
					        </tr>
					        @endforeach

					        
					        <tr>
					        	<td colspan="3" class="text-right"><strong>Total</strong></td>
					        	<td colspan="1" class="text-center"><strong>R$ {{number_format($vtTotal, 2, ',', '.')}}</strong></td>
					        </tr>
					        
					    </tbody>
					</table>

					<br>

					<table class="table table-bordered table-hover table-striped">
					    <thead>
					    	<tr>
					    		<th colspan="5">Pagamentos</th>
					    	</tr>
					        <tr>
					            <th>Periodo</th>
					            <th>Periodo</th>
					            <th>Descrição</th>
					            <th>Crédito</th>
					            <th>Débito</th>
					        </tr>
					    </thead>
					    <tbody>
					    	@foreach($pagamentos as $pagamento)
					        <tr>
								<td class="text-center" widtd="15%">{{$pagamento->init->format('d/m/Y')}}</td>
								<td class="text-center" widtd="15%">{{$pagamento->end->format('d/m/Y')}}</td>
								<td class="text-center" widtd="40%">
								@if(is_null($pagamento->tipo) or empty($pagamento->tipo)) {{substr($pagamento->descricao, 0, 30) }} 
								@elseif($pagamento->tipo == 'Pagamento') Pagamento {{substr($pagamento->descricao, 0, 30)}} 
								@elseif($pagamento->tipo == 'Outros') Outros {{substr($pagamento->descricao, 0, 30)}} 
								@else {{$pagamento->tipo}}
								@endif</td>
								<td class="text-center" widtd="15%">@if($pagamento->is_debito == 0) R$ {{$pagamento->valor}} @endif</td>
								<td class="text-center" widtd="15%">@if($pagamento->is_debito == 1) R$ {{$pagamento->valor}} @endif</td>
					        </tr>
					        @endforeach

					        <tr>
					        	<td colspan="3" class="text-right"><strong>Sub-total</strong></td>
					        	<td colspan="1" class="text-center"><strong>R$ {{number_format($totalCredito, 2, ',', '.')}}</strong></td>
					        	<td colspan="1" class="text-center"><strong>R$ {{number_format($totalDebito, 2, ',', '.')}}</strong></td>
					        </tr>
					        
					        <tr>
					        	<td colspan="4" class="text-right"><strong>Total</strong></td>
					        	<td colspan="1" class="text-center"><strong>R$ {{number_format($total, 2, ',', '.')}}</strong></td>
					        </tr>
					        
					    </tbody>
					</table>

					<br>

					<p>Belo Horizonte,  <strong>{{date('d/m/Y')}}</strong></p>

					<p>Nome completo: <strong>{{$funcionario->nome}}</strong></p>
					<p>CPF: <strong>{{$funcionario->cpf}}</strong></p>

					<br>

					<hr style="width: 80%; border: 1px solid; color: black; height: 2px; background-color:black;" />
					<p class="text-center">Assinatura</p>

					<strong>Observações</strong>
					<p>{{$funcionario->observacoes}}</p>

		<br>

	</div>

	<div class="col-md-1 col-sm-1">
		<div class="row">
			<button class="btn btn-default" @click="salva()">Salvar recibo</button>
		</div>
	</div>
</div>



<div class="row">

</div>

    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/funcionarios.js') !!}"></script>

			<script type="text/javascript">

				Vue.config.debug = true;
				Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#_tokenLaravel').getAttribute('value');
				var vm = new Vue({
				    el: '#reciboss',
				    data: {
				    	retiradas: {!! $recibo !!},
				    	id: {{ $func_id }},
				    	total_debito: {{ $totalDebito}},
				    	total_credito: {{ $totalCredito}}
				    },

					methods: {

						salva: function(){

							this.$http.post('/admin/funcionarios/recibo/salva/' + this.id, { 
									retiradas: this.retiradas,
									total_debito: this.total_debito,
									total_credito: this.total_credito
								}).then(function (response) {

								swal('OK', 'RECIBO GERADO COM SUCESSO.', 'success');


						    }, function (response) {

						      	swal('ERRO', 'PROBLEMA AO GERAR O RECIBO.', 'error');
						      	
						      	console.log(response)

						    });
						}
					},
				})

			</script>

	@stop

@stop