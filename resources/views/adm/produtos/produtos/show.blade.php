@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Detalhes produto</h1>

<div class="row">
	<div class="col-md-9">
		<div class="panel panel-default">
			<div class="panel-heading"><h5>{{$produto->nome_produto}}</h5></div>
			<div class="panel-body">
				<div class="col-md-6">
					<p>Produto</p>
					<p><strong>{{$produto->nome_produto}}</strong></p>
					<p>Descrição</p>
					<p><strong>{{$produto->descricao}}</strong></p>
					<p>Categoria</p>
					<p><strong>{{$produto->categoria['nome']}}</strong></p>
					<p>Produto está ativo?</p>
					<p><strong>@if($produto->is_ativo) Sim @else Não @endif</strong></p>
					<p>Produto está ativo?</p>
					<p><strong>@if($produto->tracked) Sim @else Não @endif</strong></p>
				</div>
				<div class="col-md-6">
					<p>Nome produto correspondente no aplicativo</p>
					<p><strong>{{$produto->square_name}}</strong></p>
					<p>Quantidae em estoque</p>
					<p><strong>{{$produto->quantidadeEstoque}}</strong></p>		
					<p>Quantidade por porção</p>
					<p><strong>{{$produto->calc}}</strong></p>				
					<p>Fornecedores</p>
					<p><strong>
						@foreach($produto->fornecedores as $fornecedor)
							{{$fornecedor->nome}}, 
						@endforeach
					</strong></p>
				</div>
				

				

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

</div>

<div class="row">
	<div class="col-md-9">
		<div class="panel panel-default">
			<div class="panel-heading"><h5>Produtos de venda vinculados</h5></div>
			<div class="panel-body">

				<fieldset>
					<legend>Lista de produtos vinculados</legend>

					<table class="table table-bordered table-hover table-striped">
					    <thead>
					        <tr>
					            <th>Nome</th>
					            <th>Quantidade por venda</th>
					            <th>Remover</th>
					        </tr>
					    </thead>
					    <tbody>
					    	@foreach($produto->squareproducts as $square)
					        <tr>
					            <td>{{$square->square_name}}</td>
					            <td>{{$square->quantidade_por_venda}}</td>
					            <td>
					            	<form method="POST" action="/admin/produtos/removeSquareProduct">
					            	{!! csrf_field()!!}

					            	<input name="produto_id" type="hidden" value="{{$produto->id}}">
					            	<input name="square_id" type="hidden" value="{{$square->square_id}}">
					            	<button class="btn btn-danger" type="submit">Remover</button>
					            	</form>
					            </td>
					        </tr>
					        @endforeach
					    </tbody>
					</table>
				</fieldset>


				<div class="row">
					
					<div class="col-md-12">

					<fieldset>
						<legend>Adicionar novo vinculo de produto</legend>

						<form method="POST" action="/admin/produtos/addSquareProduct">
			            	{!! csrf_field()!!}

			            	<input name="produto_id" type="hidden" value="{{$produto->id}}">
							<div class="form-group">
								<label>Produto correspondente no aplicativo de venda</label>
			              		{!! Form::select('square_id', $squareItemsForSelect, null, ['class' => 'form-control', 'single' => 'single', 'id' => 'square', 'placeholder' => 'Selecione um produto'])   !!}
			              		<input type="hidden" value="" name="square_name" />
			        		</div>

			        		<div class="form-group">
			        			<label>Quantidade por venda</label>
			        			<input class="form-control" name="quantidade_por_venda" value="0">
			        		</div>

			        		<button class="btn btn-primary" type="submit">Adicionar</button>
			        	</form>
					</fieldset>

					</div>
				</div>


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
				            <td>@if($movimentacao->is_saida == 1)Saida @else <a href="{{route('admin.financeiro.detalhes', $movimentacao->pagamento_id)}}"> Entrada</a> @endif</td>
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

			<script type="text/javascript">
			$('#fornecedores').select2();
			$('#square').select2();
			$('.money').mask("0000.00", {reverse: true});
			$('.unity').mask("000.000", {reverse: true});
		
			$('#square').on('change', function(){
				$('input[name="square_name"]').val($("#square option:selected").text());
				console.log($('#square :selected').text());
			});

			</script>

		@stop


@stop