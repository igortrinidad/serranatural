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
			$('#square').select2();
			$('.money').mask("0000.00", {reverse: true});
			$('.unity').mask("000.000", {reverse: true});
		
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