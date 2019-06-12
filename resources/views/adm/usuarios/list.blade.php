@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Lista de usuários</h1>

<div class="col-md-12">

	<div class="panel panel-default">
		<div class="panel-heading"><h5>Usuários</h5></div>
		<div class="panel-body">

			<table class="table table-bordered table-hover table-striped">
			    <thead>
			        <tr>
			            <td>Nome</td>
			            <td>Email</td>
			            <td>Tipo</td>
			            <td class="text-center">Excluir</td>
			        </tr>
			    </thead>
			    <tbody>
			    	@foreach($users as $user)
			        <tr>
			            <td>{{$user->name}}</td>
			            <td>{{$user->email}}</td>
			            <td>{{$user->user_type}}</td>
			            <td class="text-center">
							<a class="btn btn-danger" href="{{route('admin.users.destroy', $user->id)}}">Deletar</a>	
						</td>
			        </tr>
			        @endforeach
			    </tbody>
			</table>
		</div>
		
	</div>
</div>


@stop