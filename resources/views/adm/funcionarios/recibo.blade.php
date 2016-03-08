@extends('layout/admin')

@section('conteudo')

<br><br>
<h2 class="text-center">Recibo</h2><br>

<div class="row">
	<div class="col-md-1 col-sm-1">
	</div>
	<div class="col-md-10 col-sm-10">
		<p style="font-size:18px">Declaro para os devidos fins que recebi da empresa Serra Natural, CNPJ 20.699.074/0001-75, situada na Alameda do Ingá, 754 - Vila da Serra - Nova Lima os valores abaixo descriminados;</p>

		<br>


					<table class="table table-bordered table-hover table-striped">
					    <thead>
					        <tr>
					            <th>Periodo</th>
					            <th>Descrição</th>
					            <th>Crédito</th>
					            <th>Débito</th>
					        </tr>
					    </thead>
					    <tbody>
					    	@foreach($pagamentos as $pagamento)
					        <tr>
								<td class="text-center" widtd="20%">{{$pagamento->motivo}}</td>
								<td class="text-center" widtd="15%">{{substr($pagamento->descricao, 0, -10)}}</td>
								<td class="text-center" widtd="35%">@if($pagamento->valor > 0) R$ {{$pagamento->valor}} @endif</td>
								<td class="text-center">@if($pagamento->valor < 0) R$ {{$pagamento->valor}} @endif</td>
					        </tr>
					        @endforeach
					        
					        <tr>
					        	<td colspan="3" class="text-right"><strong>Total</strong></td>
					        	<td colspan="1" class="text-center"><strong>R$ {{$total}}</strong></td>
					        </tr>
					        
					    </tbody>
					</table>

					<br>

					<p style="font-size:18px">Belo Horizonte,  <strong>{{date('d/m/Y')}}</strong></p>

					<p style="font-size:18px">Nome completo: <strong>{{$funcionario->nome}}</strong></p>
					<p style="font-size:18px">CPF: <strong>{{$funcionario->cpf}}</strong></p>

					<br>

					<hr style="width: 80%; color: black; height: 1px; background-color:black;" />
					<p class="text-center">Assinatura</p>

		<br>



	</div>

	<div class="col-md-1 col-sm-1">
		
	</div>
</div>



<div class="row">

</div>


    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/funcionarios.js') !!}"></script>

<script type="text/javascript">

</script>

	@stop

@stop