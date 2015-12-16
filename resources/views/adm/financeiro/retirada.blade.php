@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Fluxo de caixa</h2><br>

	@include('errors.messages')

<div class="row">

		<div class="panel panel-default">
			<div class="panel-heading"></div>
			<div class="panel-body">

			<form action="{{ route('admin.financeiro.retiradaPost')}}" method="POST">

				{{ csrf_field() }}

				<div class="col-md-6">

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
	                    <input type="checkbox" name="retirado_caixa" value="1" class="checkbox" checked/>
	                    <p>Valor retirado do caixa?</p>
	                </div>
				
					<div class="form-group">
						{!! Form::select('funcionario_id', $funcionarios, null, ['class' => 'form-control', 
						'single' => 'single', 'id' => 'funcionarios', 'placeholder' => 'Selecione um funcionario'])   !!}
					</div>

					<button type="submit" class="btn btn-block btn-primary">Dar retirada</button>
				</div>

			</form>
			
</div>


    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/financeiro.js') !!}"></script>

<script type="text/javascript">

var $funcionarios = $('#funcionarios')

	$funcionarios.select2();

	$('.maskValor').mask("0000.00", {reverse: true});

</script>

	    @stop

@stop