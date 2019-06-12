@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Produtos</h1>

	@include('errors.messages')

<div id="elProduto">

	<div class="panel panel-default">
		<div class="panel-heading"><h5>Cadastrar Produto</h5></div>
		<div class="panel-body">



		</div>
	</div>

</div>

    @section('scripts')
	    @parent

			<script type="text/javascript">
			$('#fornecedores').select2();
			$('#square').select2();
			$('#calc').mask("000000", {reverse: true});
		
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
				    	},
				    	squareItems: parse.JSON({{$squareItems}}) ,
				    },
				    ready: function(){


				    }
				});

			</script>

		@stop


@stop