@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Lista de Compras</h1>

	@include('errors.messages')

<h3>Data: {{dataMysqlParaPtBr($dataInicio)}} - {{dataMysqlParaPtBr($dataFim)}} Quantidade de pratos: {{$quantidadePratos}} </h3><br>


	@foreach($agendados as $agenda)
		<div class="panel panel-default">
			<div class="panel-heading"><h5>{{$agenda->pratos->prato}} | Data: {{ dataMysqlParaPtBr($agenda->dataStamp) }}</h5></div>
			<div class="panel-body">
			<label>Acompanhamentos</label>
			<p>{{$agenda->pratos->acompanhamentos}}</p>
			<label>Modo de preparo</label>
			<p>{{$agenda->pratos->modo_preparo}}</p>
			
			<label>Custo estimado do prato para: <strong>{{$quantidadePratos}}</strong> unidades</label>
			<h3>{{ moneyBR($agenda->pratos->total) }}</h3>

			<label>Lista de compras</label>
			<table class="table table-bordered table-hover table-striped">
			    <thead>
			        <tr>
			            <td>Produto</td>
			            <td>Quantidade</td>
			            <td>Preço médio</td>
			            <td>Unidade medida</td>
			            <td>Custo produto</td>
			        </tr>
			    </thead>
			    <tbody>
			    	@foreach($agenda->pratos->produtos as $produto)
			    		<tr>
			    			<td>{{$produto->nome_produto}}</td>
			    			<td>{{$produto->pivot->quantidade}}</td>
			    			<td>{{ moneyBR($produto->preco) }}</td>
			    			<td>{{$produto->pivot->unidade}}</td>
			    			<td>{{ moneyBR($produto->custo) }}</td>
				        <tr>
				            <td></td>
				        </tr>
			        @endforeach
			    </tbody>
			</table>
	

			</div>
		</div>
	@endforeach

		<div class="panel panel-default">
			<div class="panel-heading"><h5>Total de produtos</h5></div>
			<div class="panel-body">

				@foreach (array_chunk($produtosTotais, 1, true) as $rows)
					<div class="row">

						@foreach ($rows as $key => $value)
							
							<div class="col-md-4">
								<label>Produto</label>
								<p>{{ $key }}</p>
							</div>
							<div class="col-md-4">
								<label>Total</label>
								<p>{{$value['quantidade']}}</p>
							</div>
							<div class="col-md-4">
								<label>Unidade</label>
								<p>{{$value['unidade']}}</p>
							</div>

						@endforeach
					</div>
				@endforeach

			</div>
		</div>

    @section('scripts')
	    @parent

			<script type="text/javascript">

			</script>

		@stop


@stop