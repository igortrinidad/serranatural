@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Produtos</h1>

	@include('errors.messages')


 <div class="panel panel-default">
	<div class="panel-heading"><h5>Lista Produtos Rastreados</h5></div>
	<div class="panel-body">

		<table class="table table-bordered table-hover table-striped">
		    <thead>
		        <tr>
		            <th width="30%">Nome</th>
		            <th width="10%">Categoria</th>
		            <th width="8%">Quantidade em estoque</th>
		            <th width="8%">Rastrear?</th>
		            <th width="8%">Ativo?</th>
		            <th width="35%">Fornecedores</th>
		        </tr>
		    </thead>
		    <tbody>
		    @foreach($produtosRastreados as $produto)
		        <tr>
		            <td>
		            	<a href="{{ route('produtos.produtos.show', $produto->id)}}">{{$produto->nome_produto}}
		            	</a>
		            </td>
		            <td>{{$produto->categoria['nome']}}</td>
		            <td class="text-center">{{$produto->quantidadeEstoque}}</td>
		            <td class="text-center">@if($produto->tracked == 1) Sim @else @endif</td>
		            <td class="text-center">@if($produto->is_ativo == 1) Sim @else @endif</td>
		            <td>@foreach($produto->fornecedores as $fornecedor) {{$fornecedor->nome}} , @endforeach</td>
		        </tr>
		    @endforeach
		    </tbody>
		</table>

	</div>
</div>

 <div class="panel panel-default">
	<div class="panel-heading"><h5>Lista Produtos não rastreados</h5></div>
	<div class="panel-body">

		<table class="table table-bordered table-hover table-striped">
		    <thead>
		        <tr>
		            <th width="30%">Nome</th>
		            <th width="10%">Categoria</th>
		            <th width="8%">Quantidade em estoque</th>
		            <th width="8%">Rastrear?</th>
		            <th width="8%">Ativo?</th>
		            <th width="35%">Fornecedores</th>
		        </tr>
		    </thead>
		    <tbody>
		    @foreach($produtosNaoRastreados as $produto)
		        <tr>
		            <td>
		            	<a href="{{ route('produtos.produtos.show', $produto->id)}}">{{$produto->nome_produto}}
		            	</a>
		            </td>
		            <td>{{$produto->categoria['nome']}}</td>
		            <td class="text-center">{{$produto->quantidadeEstoque}}</td>
		            <td class="text-center">@if($produto->tracked == 1) Sim @else @endif</td>
		            <td class="text-center">@if($produto->is_ativo == 1) Sim @else @endif</td>
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