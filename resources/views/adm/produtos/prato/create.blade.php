@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Pratos</h1>

	@include('errors.messages')

<div class="panel panel-default">
	<div class="panel-heading"><h5>Cadastrar Pratos</h5></div>
	<div class="panel-body">

			<form action="/admin/produtos/salvaPratos" method="POST" class="form-group" enctype="multipart/form-data">

				<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

				<div class="form-group">
					<label>Nome</label>
					<input type="text" name="prato" class="form-control">
				</div>

				<div class="form-group">
					<label>Acompanhamentos</label>
					<textarea type="textarea" name="acompanhamentos" class="form-control"></textarea>
				</div>

				<div class="form-group">
					<label>Foto</label>
					<input type="file" name="foto" class="form-control">
				</div>

				<div class="form-group">
					<label>Titulo foto</label>
					<input type="text" name="titulo_foto" class="form-control">
				</div>

				<button type="submit" class="btn btn-primary">Cadastrar Prato</button>
                               

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