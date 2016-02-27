@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Produtos</h1>

	@include('errors.messages')

<div class="panel panel-default">
	<div class="panel-heading"><h5>Cadastrar Produto</h5></div>
	<div class="panel-body">

			<form action="{{route('produtos.produtos.update', $produto->id)}}" method="POST" class="form-group">

				<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

				<div class="form-group">
					<label>Nome</label>
					<input type="text" name="nome_produto" value="{{$produto->nome_produto}}" class="form-control">
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

				<div class="form-group">
						<label>Fornecedores</label>
		              {!! Form::select('fornecedor_id[]', $fornecedoresForSelect, $fornecedores, ['class' => 'form-control', 
		              'multiple' => 'multiple', 'id' => 'fornecedores'])   !!}
		        </div>

				<button type="submit" class="btn btn-primary">Salvar produto</button>
                               
			</form>

	</div>
</div>


    @section('scripts')
	    @parent

			<script type="text/javascript">
			$('#fornecedores').select2();
			</script>

		@stop


@stop