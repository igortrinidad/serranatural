@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Histórico de Vouchers</h2><br>

	@include('errors.messages')

<div class="row">

			{!! $vouchers->render() !!}
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Vouchers</h4>
		</div>
		<div class="panel-body">
			
			<table class="table table-bordered table-hover table-striped">
			    <thead>

			        <tr>
			        	<th>Cliente</th>
			        	<th>Data recebido</th>
			        	<th>Vencimento</th>
						<th>Data utilizado</th>
						<th>É valido?</th>
						<th>Valor utilizado</th>
						<th>Produto cortesia</th>
						<th>Usuario autorização</th>
			        </tr>
			    </thead>
			    <tbody>
			    @foreach($vouchers as $voucher)
			        <tr>
						<td class="text-center">{{$voucher->cliente->nome}}</td>
						<td class="text-center">{{$voucher->data_voucher->format('d/m/Y')}}</td>
						<td class="text-center">{{$voucher->vencimento}}</td>
						<td class="text-center">{{$voucher->data_utilizado}}</td>
						<td class="text-center">@if($voucher->is_valido)Sim @else Não @endif</td>
						<td class="text-center">{{$voucher->valor}}</td>
						<td class="text-center">{{$voucher->produto}}</td>
						<td class="text-center">@if(!$voucher->user_id) -- @else {{$voucher->usuario->name}} @endif</td>

			        </tr>
			    @endforeach
			    </tbody>
			</table>
			
		</div>
	</div>


</div>


    @section('scripts')
	    @parent

			<script type="text/javascript">


			</script>


	@stop

@stop