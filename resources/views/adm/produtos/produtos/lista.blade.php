@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Produtos</h1>

	@include('errors.messages')


 <div class="panel panel-default">
	<div class="panel-heading"><h5>Lista Produtos Rastreados</h5></div>
	<div class="panel-body">

		<div class="row">
			<div class="col-md-7">
				
				<div class="form-group">
					{!! Form::select('id', $produtosForSelect, null, ['class' => 'form-control', 
					'single' => 'single', 'id' => 'produtos', 'placeholder' => 'Selecione um produto'])   !!}
				</div>

			</div>
			<div class="col-md-2">
				<div class="form-group">
					<a class="btn btn-primary btn-sm" id="linkCliente">Mostrar produto</a>
				</div>
			</div>

		
			<div class="col-md-3">

			</div>
		</div>

		<table class="table table-bordered table-hover table-striped">
		    <thead>
		        <tr>
		            <th width="20%">Nome</th>
		            <th width="10%">Categoria</th>
		            <th width="8%">Qtde em estoque</th>
		            <th width="8%">Preço médio</th>
		            <th width="8%">Rastrear?</th>
		            <th width="8%">Ativo?</th>
		            <th width="15%">Produto referente</th>
		            <th width="20%">Fornecedores</th>
		            <th width="8%">Deletar</th>
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
		            <td class="text-center">{{ moneyBR($produto->preco) }}</td>
		            <td class="text-center">@if($produto->tracked == 1) Sim @else @endif</td>
		            <td class="text-center">@if($produto->is_ativo == 1) Sim @else @endif</td>
		            <td class="text-center">{{$produto->square_name}}</td>
		            <td>@foreach($produto->fornecedores as $fornecedor) {{$fornecedor->nome}} , @endforeach</td>
		            <td><a href="{{route('produtos.produtos.destroy', $produto->id)}}"><i class="fa fa-trash"></i></td>
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
		            <th width="20%">Nome</th>
		            <th width="10%">Categoria</th>
		            <th width="8%">Qtde em estoque</th>
		            <th width="8%">Preço</th>
		            <th width="8%">Rastrear?</th>
		            <th width="8%">Ativo?</th>
		            <th width="15%">Produto referente</th>
		            <th width="20%">Fornecedores</th>
		            <th width="8%">Deletar</th>
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
		            <td class="text-center">{{ moneyBR($produto->preco) }}</td>
		            <td class="text-center">@if($produto->tracked == 1) Sim @else @endif</td>
		            <td class="text-center">@if($produto->is_ativo == 1) Sim @else @endif</td>
		            <td class="text-center">{{$produto->square_name}}</td>
		            <td>@foreach($produto->fornecedores as $fornecedor) {{$fornecedor->nome}} , @endforeach</td>
		           	<td><a href="{{route('produtos.produtos.destroy', $produto->id)}}"><i class="fa fa-trash"></i></td>
		        </tr>
		    @endforeach
		    </tbody>
		</table>

	</div>
</div>




    @section('scripts')
	    @parent

			<script type="text/javascript">

			$('#produtos').select2();

			$("#produtos").change(function() 
				{
					var id = $(this).val();
				 	var href = '/admin/produtos/show' + id;
				    //adiciona o valor do id recebido como parametro na funcao
					$('#buttonProdutos').prop("href", href);
				});
			</script>

		@stop


@stop