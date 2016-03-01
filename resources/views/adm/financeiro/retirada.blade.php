@extends('layout/admin')

@section('conteudo')

<div id="elRetirada">
<h2 class="text-right">Retiradas</h2><br>

	@include('errors.messages')

	<div class="row">
		<div class="col-md-6">

			<div class="panel panel-default">
				<div class="panel-heading">Detalhes retirada</div>
				<div class="panel-body">

				<form action="{{ route('admin.financeiro.retiradaPost')}}" method="POST">

					{{ csrf_field() }}

						<div class="form-group">
							<label>Descrição</label>
							<input type="text" name="descricao" class="form-control" />
						</div>

						<div class="form-group">
							<label>Valor</label>
							<input type="text" name="valor" class="form-control maskValor" />
						</div>

		                <div class="form-group">
		                	<input type="hidden" name="retirado_caixa" value="0" />
		                	<label>Valor retirado do caixa?</label><br>
		                    <input type="checkbox" class="form-control" name="retirado_caixa" value="1" data-toggle="toggle" data-onstyle="danger" data-on="Sim" data-off="Não"/>
		                  
		                </div>
					
						<div class="form-group">
							{!! Form::select('funcionario_id', $funcionarios, null, ['class' => 'form-control', 
							'single' => 'single', 'id' => 'funcionarios', 'placeholder' => 'Selecione um funcionario'])   !!}
						</div>

						<button type="submit" class="btn btn-block btn-primary">Dar retirada</button>

				</form>
		</div>
	</div>

</div>


    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/financeiro.js') !!}"></script>

			<script type="text/javascript">

				var $funcionarios = $('#funcionarios')

				$funcionarios.select2();

				$('.maskValor').mask("0000.00", {reverse: true});

				Vue.config.debug = true;
				Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#_tokenLaravel').getAttribute('value');
				var vm = new Vue({
				    el: '#elRetirada',
				    data: 
				    {
				    	teste: 'Teste',
				    },
				});


			</script>

	    @stop

@stop