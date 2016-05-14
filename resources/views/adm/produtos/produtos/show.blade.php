@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Detalhes produto</h1>

<div class="row">
	<div class="col-md-9">
		<div class="panel panel-default">
			<div class="panel-heading"><h5>{{$produto->nome_produto}}</h5></div>
			<div class="panel-body">
				<p>Produto</p>
				<p><strong>{{$produto->nome_produto}}</strong></p>
				<p>Quantidae em estoque</p>
				<p><strong>{{$produto->quantidadeEstoque}}</strong></p>
				<p>Descrição</p>
				<p><strong>{{$produto->descricao}}</strong></p>
				<p>Categoria</p>
				<p><strong>{{$produto->categoria['nome']}}</strong></p>
				<p>Fornecedores</p>
				<p><strong>
					@foreach($produto->fornecedores as $fornecedor)
						{{$fornecedor->nome}}, 
					@endforeach
				</strong></p>

			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><h5>Ações</h5></div>
			<div class="panel-body">
				<a href="{{route('produtos.produtos.edit', $produto->id)}}"class="btn btn-default btn-block">Editar</a>

			</div>
		</div>
		
	</div>

	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><h5>Aplicativo</h5></div>
			<div class="panel-body">
				<label>Nome produto</label>
				<p><strong>{{$produto->square_name}}</strong></p>
			</div>
		</div>
		
	</div>

</div>

<div class="row">
	<div class="col-md-9">
		<div class="panel panel-default">
			<div class="panel-heading"><h5>Movimentações de estoque</h5></div>
			<div class="panel-body">
				<table class="table table-bordered table-hover table-striped">
				    <thead>
				        <tr>
				            <th>Data</th>
				            <th>Saida/Entrada</th>
				            <th>Quantidade</th>
				            <th>Valor</th>
				            <th>Motivo</th>
				            <th>Usuario</th>
				        </tr>
				    </thead>
				    <tbody>
				    	@foreach($movimentacoes as $movimentacao)
				        <tr>
				            <td>{{$movimentacao->created_at->format('d/m/Y')}}</td>
				            <td>@if($movimentacao->is_saida == 1)Saida @else Entrada @endif</td>
				            <td>{{$movimentacao->quantity}}</td>
				            <td>{{$movimentacao->valor}}</td>
				            <td>{{$movimentacao->motivo}}</td>
				            <td>{{$movimentacao->usuario['name']}}</td>
				        </tr>
				        @endforeach
				    </tbody>
				</table>

				{!! $movimentacoes->render() !!}




			</div>
		</div>

	</div>
</div>


    @section('scripts')
	    @parent


		@stop


@stop