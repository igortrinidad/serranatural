@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Detalhes</h2>

	@if(Session::has('msg_retorno'))
	<div class="alert alert-{{Session::get('tipo_retorno')}}">
	     {{Session::get('msg_retorno')}}
	 </div>
	@endif

	<div class="panel panel-default">
		<div class="panel-heading"><h5>Dados</h5></div>
		<div class="panel-body">


		<div class="form-group">
			<label>Nome</label>
			<p>{{$cliente->nome}}</p>
		</div>
		<div class="form-group">
			<label>Telefone</label>
			<p>{{$cliente->telefone}}</p>
		</div>
				
			
		<div class="form-group">
			<label>E-mail</label>
			<p>{{$cliente->email}}</p>
		</div>

		<div class="form-group">
			<label>Newsletter</label>

			@if($cliente->opt_email == 1)
			<a href="/admin/clientes/sairEmail/{{$cliente->id}}"><i class="fa fa-check-square-o"></i></a>
			@else
			<a href="/admin/clientes/entrarEmail/{{$cliente->id}}"><i class="fa fa-square-o"></i></a>
			@endif
		</div>

		<a href="/admin/clientes/edita/{{$cliente->id}}" class="btn btn-primary">Editar<i class="fa fa-pencil"></i></a>

	</div>
</div>


	<div class="panel panel-default">
		<div class="panel-heading"><h5>Preferências</h5></div>
		<div class="panel-body">
			@foreach($preferencias as $preferencia)

			{{$preferencia->prato}}, 

			@endforeach
			
		</div>
	</div>


@stop