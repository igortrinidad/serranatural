@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Produtos</h1>

	@include('errors.messages')


 <div class="panel panel-default">
	<div class="panel-heading"><h5>Lista Produtos</h5></div>
	<div class="panel-body">

		<table class="table table-bordered table-hover table-striped">
		    <thead>
		        <tr>
		            <th width="30%">Nome</th>
		            <th width="20%">Descrição</th>
		            <th width="20%">Categoria</th>
		            <th width="10%">Quantidade em estoque</th>
		            <th width="10%">Fornecedores</th>
		        </tr>
		    </thead>
		    <tbody>
		    @foreach($produtos as $produto)
		        <tr>
		            <td>{{$produto->nome_produto}}</td>
		            <td>{{$produto->descricao}}</td>
		            <td>{{$produto->categoria['nome']}}</td>
		            <td class="text-center">{{$produto->quantidadeEstoque}}</td>
		            <td>@foreach($produto->fornecedores as $fornecedor) {{$fornecedor->nome}} , @endforeach</td>
		        </tr>
		    @endforeach
		    </tbody>
		</table>

	</div>
</div>




    @section('scripts')
	    @parent

			<script type="text/javascript">

			</script>

		@stop


@stop