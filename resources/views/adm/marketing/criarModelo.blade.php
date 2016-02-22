@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Editar modelos email</h2>
<form method="post" action="{{route('admin.marketing.salvarModelo')}}">
{!! csrf_field() !!}
<div class="row">
	<div class="col-md-9">
		<div class="panel panel-default">
			<div class="panel-heading"><h5>Template</h5></div>
			<div class="panel-body">
				
				<div class="form-group">
					<label>Nome modelo</label>
					<input type="text" name="nome" class="form-control"/>
				</div>

				<div class="form-group">
					<label>Assunto</label>
					<input type="text" name="assunto" class="form-control"/>
				</div>
				
				<textarea id="summernote" name="code" height="500px"></textarea>

			</div>
		</div>
	</div>

	<div class="col-md-3">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading"><h5>Ações</h5></div>
				<div class="panel-body">
				
					<button type="submit" class="btn btn-default btn-block">Salvar modelo</button>

				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading"><h5>Variaveis</h5></div>
				<div class="panel-body">
				
					<p><strong>${nomeCliente}</strong></p>
					<p><strong>${emailCliente}</strong></p>

				</div>
			</div>
		</div>
	</div>

</div>

</form>




    @section('scripts')
	    @parent

			<script type="text/javascript">

				$('#summernote').summernote({
					  height: 400,                 // set editor height
					  minHeight: null,             // set minimum height of editor
					  maxHeight: null,             // set maximum height of editor
					  focus: true                  // set focus to editable area after initializing summernote
					});

			</script>

	    @stop

@stop