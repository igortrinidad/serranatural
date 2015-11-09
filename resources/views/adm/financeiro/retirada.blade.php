@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Fluxo de caixa</h2><br>

	@if(Session::has('msg_retorno'))
	<div class="alert alert-{{Session::get('tipo_retorno')}}">
	     {{Session::get('msg_retorno')}}
	 </div>
	@endif

<div class="row">

		<div class="panel panel-default">
			<div class="panel-heading"></div>
			<div class="panel-body">
			
				<div class="form-group">

					{!! Form::select('id', $funcionarios, null, ['class' => 'form-control', 
					'single' => 'single', 'id' => 'funcionarios', 'placeholder' => 'Selecione um funcionario'])   !!}
				</div>

			</div>
			
</div>


    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/financeiro.js') !!}"></script>

<script type="text/javascript">

var $funcionarios = $('#funcionarios')

	$funcionarios.select2();

</script>

	    @stop

@stop