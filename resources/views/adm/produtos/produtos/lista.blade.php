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
		            <th>Nome</th>
		            <th>Preço Medio</th>
		            <th>Descrição</th>
		            <th>Fornecedores</th>
		        </tr>
		    </thead>
		    <tbody>
		    @foreach($produtos as $produto)
		        <tr>
		            <td>{{$produto->nome_produto}}</td>
		            <td>{{$produto->preco}}</td>
		            <td>{{$produto->descricao}}</td>
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