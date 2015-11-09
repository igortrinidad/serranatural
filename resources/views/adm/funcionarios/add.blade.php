@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Adiciona funcionários</h2><br>

	@if(Session::has('msg_retorno'))
	<div class="alert alert-{{Session::get('tipo_retorno')}}">
	     {{Session::get('msg_retorno')}}
	 </div>
	@endif

<div class="row">

	<div class="col-md-6">
		
		<div class="panel panel-default">
			<div class="panel-heading">Teste</div>
			<div class="panel-body">

				<form action="" class="" method="POST">
					
					{!! csrf_field() !!}

					<div class="form-group">
						<label>Nome completo</label>
						<input type="text" name="nome" class="form-control" />
					</div>

					<div class="form-group">
						<label>CPF</label>
						<input type="text" name="cpf" class="form-control" />
					</div>

					<div class="form-group">
						<label>Identidade</label>
						<input type="text" name=" identidade" class="form-control" />
					</div>




				</form>


			</div>

			</div>

		</div>

	</div>


</div>


    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/funcionarios.js') !!}"></script>

<script type="text/javascript">

</script>

	@stop

@stop