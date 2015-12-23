@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Lista de Compras</h1>

	@include('errors.messages')

<h3>Quantidade de pratos: {{$quantidadePratos}}</h3>


@foreach($pratos as $prato)
		<div class="panel panel-default">
			<div class="panel-heading"><h5>{{$prato->prato}}</h5></div>
			<div class="panel-body">
			<label>Acompanhamentos</label>
			<p>{{$prato->acompanhamentos}}</p>

			<div class="row">
			@foreach($prato->produtos as $produto)
				<div class="col-md-4">
					<label>Produtos</label>
					<p>	{{$produto->nome_produto}}</p>
				</div>
				<div class="col-md-4">
					<label>Quantidade</label>
					<p>{{$produto->pivot->quantidade}}</p>
				</div>

				<div class="col-md-4">
					<label>Unidade</label>
					<p>	{{$produto->pivot->unidade}}</p>
				</div>

			@endforeach
			</div>

			</div>
		</div>
@endforeach




    @section('scripts')
	    @parent

			<script type="text/javascript">

			</script>

		@stop


@stop