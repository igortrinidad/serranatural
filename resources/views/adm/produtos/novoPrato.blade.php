@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Adiciona novo prato</h1>

	@if(Session::has('msg_retorno'))
	<div class="alert alert-{{Session::get('tipo_retorno')}}">
	     {{Session::get('msg_retorno')}}
	 </div>
	@endif


<div class="panel panel-default">
	<div class="panel-heading"><h5>Cadastrar Pratos</h5></div>
	<div class="panel-body">

			<form action="/admin/produtos/salvaPratos" method="POST" class="form-group">

				<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

				<div class="form-group">
					<label>Nome</label>
					<input type="text" name="prato" class="form-control">
				</div>

				<div class="form-group">
					<label>Acompanhamentos</label>
					<textarea type="textarea" name="acompanhamentos" class="form-control"></textarea>
				</div>

				<button type="submit" class="btn btn-primary">Cadastrar Prato</button>
                               

			</form>

	</div>
</div>

 <div class="panel panel-default">
	<div class="panel-heading"><h5>Lista Pratos</h5></div>
	<div class="panel-body">

		<table class="table table-hover">
			<thead>
				<tr>
					<td>Nome</td>
					<td>Acompanhamentos</td>
					<td>Edita</td>
					<td>Ativo</td>
				</tr>
			</thead>
			@foreach($listaPratos as $p)
			<tr>
				<td>{{isset($p) ? $p->prato : ''}}</td>
				<td>{{isset($p) ? $p->acompanhamentos : ''}}</td>
				<td><a href="/admin/produtos/pratos/edita/{{$p->id}}"><i class="fa fa-pencil"></i></a></td>
				<td>
					@if($p->ativo == 1)
						<a href="/admin/produtos/pratos/desativar/{{$p->id}}"><i class="fa fa-check-square-o"></i></a>
					@else
						<a href="/admin/produtos/pratos/ativar/{{$p->id}}"><i class="fa fa-square-o"></i></a>
					@endif
				</td>
			</tr>
			@endforeach
		</table>
		{!! $listaPratos->render() !!}
	</div>
</div>




@stop