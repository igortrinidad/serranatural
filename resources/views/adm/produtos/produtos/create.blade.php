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

					@include('adm.produtos.produtos.product-form')

					<button type="submit" class="btn btn-primary btn-block">Cadastrar produto ou ingrediente</button>
	                               
				</form>

		</div>
	</div>

</div>

    @section('scripts')
	    @parent

			<script type="text/javascript">
			$('#fornecedores').select2();
			$('.money').mask("0000.00", {reverse: true});
			$('.unity').mask("000.000", {reverse: true});
		

			</script>

		@stop


@stop