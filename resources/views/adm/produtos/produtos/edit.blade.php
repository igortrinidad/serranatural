@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Produtos</h1>

	@include('errors.messages')

<div class="panel panel-default">
	<div class="panel-heading"><h5>Cadastrar Produto</h5></div>
	<div class="panel-body">

			<form action="{{route('produtos.produtos.update', $produto->id)}}" method="POST" class="form-group">

				<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Nome</label>
							<input type="text" name="nome_produto" class="form-control" value="{{$produto->nome_produto}}">
						</div>
					</div>
					<div class="col-md-3 text-center">
						<label>Controlar estoque?</label><br>
						<input type="checkbox" 
	                    		class="form-control" 
	                    		name="tracked" 
	                    		value="1" 
	                    		data-toggle="toggle" 
	                    		data-onstyle="success" 
	                    		data-on="Sim" 
	                    		data-off="Não",
		                />
					</div>
					<div class="col-md-3 text-center">
						<label>Ativo?</label><br>
						<input type="checkbox" 
	                    		class="form-control" 
	                    		name="is_ativo" 
	                    		value="1" 
	                    		data-toggle="toggle" 
	                    		data-onstyle="success" 
	                    		data-on="Sim" 
	                    		data-off="Não",
		                />
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">

						<div class="form-group">
							<label>Preço médio</label>
							<input type="text" name="preco" value="{{$produto->preco}}" class="form-control"/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Descrição</label>
							<input type="text" name="descricao" value="{{$produto->descricao}}" class="form-control">
						</div>
					</div>
				</div>

				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Categoria</label>
		              		{!! Form::select('categoria_id', $categorias, null, ['class' => 'form-control', 'single' => 'single', 'id' => 'categoria', 'placeholder' => 'Selecione uma categoria'])   !!}
		        		</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Fornecedores</label>
		              		{!! Form::select('fornecedor_id[]', $fornecedoresForSelect, null,  ['class' => 'form-control', 'multiple' => 'multiple', 'id' => 'fornecedores'])   !!}
		        		</div>
					</div>	
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Produto correspondente aplicativo de venda</label>
		              		{!! Form::select('square_id', $squareItemsForSelect, null, ['class' => 'form-control', 'single' => 'single', 'id' => 'square', 'placeholder' => 'Selecione um produto'])   !!}
		              		<input type="hidden" value="" name="square_name" />
		        		</div>
					</div>
				</div>

				

				<button type="submit" class="btn btn-primary">Salvar Produto</button>
                               
			</form>

	</div>
</div>


    @section('scripts')
	    @parent

			<script type="text/javascript">
			$('#fornecedores').select2();
			$('#square').select2();

			$('#square').on('change', function(){
				$('input[name="square_name"]').val($("#square option:selected").text());
				console.log($('#square :selected').text());
			});
			</script>

		@stop


@stop