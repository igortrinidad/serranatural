@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Produtos</h1>

	@include('errors.messages')

<div id="elProduto">

	<div class="panel panel-default">
		<div class="panel-heading"><h5>Cadastrar Produto</h5></div>
		<div class="panel-body">

				<form action="/admin/produtos/storeProduto" method="POST" class="form-group">

					<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Nome</label>
								<input type="text" name="nome_produto" class="form-control">
							</div>
						</div>
						<div class="col-md-3 text-center">
							<label>Controlar estoque?</label><br>
							{!! Form::checkbox('tracked', 1) !!}
						</div>
						<div class="col-md-3 text-center">
							<label>Ativo?</label><br>
							{!! Form::checkbox('is_ativo', 1) !!}
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-6">

							<div class="form-group">
								<label>Preço médio</label>
								<input type="text" name="preco" class="form-control"/>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Descrição</label>
								<input type="text" name="descricao" class="form-control">
							</div>
						</div>
					</div>

					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Categoria</label>
			              		{!! Form::select('categoria_id', $categorias, null, ['class' => 'form-control', 'single' => 'single', 'id' => 'categoria'])   !!}
			        		</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Fornecedores</label>
			              		{!! Form::select('fornecedor_id[]', $fornecedoresForSelect, null, ['class' => 'form-control', 'multiple' => 'multiple', 'id' => 'fornecedores'])   !!}
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

					

					<button type="submit" class="btn btn-primary">Cadastrar Ingrediente</button>
	                               
				</form>

		</div>
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

				Vue.config.debug = true;
				Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#_tokenLaravel').getAttribute('value');
				var vm = new Vue({
				    el: '#elProduto',
				    data: 
				    {
				    	produto: {
				    		id: '',
				    		square_id: '',
				    		square_name: '',
				    		is_tracked: '',
				    		is_ativo: ''
				    	}
				    }
				});

			</script>

		@stop


@stop