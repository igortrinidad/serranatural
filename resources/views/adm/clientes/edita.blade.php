@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Detalhes</h2>

	<div class="panel panel-default">
		<div class="panel-heading"><h5>Dados</h5></div>
		<div class="panel-body">
	
	<form action="{{route('admin.client.update', $c->id)}}" method="POST">

		<input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>

		<div class="form-group">
			<label>Nome</label>
			<input type="text" class="form-control" name="nome" value="{{$c->nome}}"></p>
		</div>
		<div class="form-group">
			<label>Telefone</label>
			<input type="text" class="form-control" name="telefone" value="{{$c->telefone}}"></p>
		</div>
				
			
		<div class="form-group">
			<label>E-mail</label>
			<input type="text" class="form-control" name="email" value="{{$c->email}}"></p>
		</div>

		<div class="form-group">
			<label>Newsletter</label>

			@if($c->opt_email == 1)
			<a href="/admin/clientes/sairEmail/{{$c->id}}"><i class="fa fa-check-square-o"></i></a>
			@else
			<a href="/admin/clientes/entrarEmail/{{$c->id}}"><i class="fa fa-square-o"></i></a>
			@endif
		</div>

		<button type="submit" class="btn btn-primary">Salvar<i class="fa fa-pencil"></i></button>
	
	</form>

	</div>
</div>



@stop