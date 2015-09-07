@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Configurações</h1>

<div class="col-md-6">

	@if(Session::has('msg_retorno'))
	<div class="alert alert-{{Session::get('tipo_retorno')}}">
	     {{Session::get('msg_retorno')}}
	 </div>
	@endif

	<div class="panel panel-default">
		<div class="panel-heading"><h5>Alterar acesso</h5></div>
		<div class="panel-body">

			<form method="POST" action="/admin/usuarios/configuracoes/update">
			    {!! csrf_field() !!}

			    <div class="form-group">
			        Name
			        <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control">
			    </div>

			    <div class="form-group">
			        Email
			        <input type="email" name="email" value="{{ Auth::user()->email }}" class="form-control">
			    </div>
			    <div class="form-group">
			        Password
			        <input type="password" name="password" class="form-control">
			    </div>

			    <div class="form-group">
			        Confirm Password
			        <input type="password" name="password_confirmation" class="form-control">
			    </div>

			    <div class="form-group">
			        <button type="submit" class="btn btn-primary btn-block">Alterar</button>
			    </div>
			</form>
		</div>
		
	</div>
</div>


@stop