@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Editar prato</h2>


<div class="panel panel-default">
	<div class="panel-heading"><h5>Nome: {{$p->prato}}</h5></div>
	<div class="panel-body">


	<form action="/admin/produtos/pratos/edita/{{$p->id}}" method="POST" class="form-group">
	
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>

	<div class="form-group">
		<label>Nome</label>
		<input type="text" name="prato" value="{{$p->prato}}" class="form-control"/>
	</div>

<div class="row">
	<div class="col-md-6">

		<div class="form-group">
			<label>Valor pequeno</label>
			<input type="text" name="valor_pequeno" value="{{$p->valor_pequeno}}" class="form-control moneySql"/>
		</div>
	</div>

	<div class="col-md-6">

	<div class="form-group">
		<label>Valor grande</label>
		<input type="text" name="valor_grande" value="{{$p->valor_grande}}" class="form-control moneySql"/>
	</div>
	</div>
</div>

	<div class="form-group">
		<label>Acompanhamentos</label>
		<textarea type="textarea" rows="5" name="acompanhamento" class="form-control">{!!$p->acompanhamentos!!}</textarea>
	</div>

	<div class="form-group">
		<label>Modo de preparo</label>
		<textarea type="textarea" rows="5" name="modo_preparo" class="form-control">{!!$p->modo_preparo!!}</textarea>
	</div>



	<button type="submit" class="btn btn-primary">Salvar</button>

	</form>
</div>

	@section('scripts')
	    @parent
		
		<script type="text/javascript">

			$('.moneySql').mask('00.00', {reverse: true});

		</script>

	@stop


@stop