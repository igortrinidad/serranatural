@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Lista de Compras</h1>

	@include('errors.messages')

<h3>Quantidade de pratos: {{$quantidadePratos}} </h3><br>


@foreach($agendados as $agenda)
		<div class="panel panel-default">
			<div class="panel-heading"><h5>{{$agenda->pratos->prato}} | Data: {{ dataMysqlParaPtBr($agenda->dataStamp) }}</h5></div>
			<div class="panel-body">
			<label>Acompanhamentos</label>
			<p>{{$agenda->pratos->acompanhamentos}}</p>
		
			@foreach ($agenda->pratos->produtos->chunk(1) as $rows)
				<div class="row">

					@foreach($rows as $produto)
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
			@endforeach

			</div>
		</div>
@endforeach




    @section('scripts')
	    @parent

			<script type="text/javascript">

			</script>

		@stop


@stop