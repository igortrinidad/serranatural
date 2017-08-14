@extends('layout/admin')

@section('conteudo')

<style>


</style>

<h1 class="text-right">Produtos</h1>

	@include('errors.messages')

<div class="panel panel-default">
	<div class="panel-heading"><h5>Cadastrar Produto</h5></div>
	<div class="panel-body">

			<form action="{{route('produtos.produtos.update', $produto->id)}}" method="POST" class="form-group">

				<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />


				@include('adm.produtos.produtos.product-form')				

				<button type="submit" class="btn btn-block btn-primary">Salvar Produto</button>
                               
			</form>

	</div>
</div>


    @section('scripts')
	    @parent

			<script type="text/javascript">

				$('.money').mask("0000.00", {reverse: true});
				$('.unity').mask("000.000", {reverse: true});

				$('#fornecedores').select2();

			</script>

		@stop


@stop