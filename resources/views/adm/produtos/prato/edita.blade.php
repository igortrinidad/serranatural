@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Editar prato</h1>


<div class="panel panel-default">
	<div class="panel-heading"><h5>Pratos</h5></div>
	<div class="panel-body">


	<form action="/admin/produtos/pratos/edita/{{$p->id}}" method="POST" class="form-group">
	
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
	<div class="form-group">
		<input type="text" name="prato" value="{{$p->prato}}" class="form-control"/>
	</div>
	<div class="form-group">
		<textarea type="textarea" rows="5" name="acompanhamento" class="form-control">{!!$p->acompanhamentos!!}</textarea>
	</div>
	<button type="submit" class="btn btn-primary btn-block">Salvar</button>

	</form>


@stop