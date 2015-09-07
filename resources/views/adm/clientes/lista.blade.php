@extends('layout/admin')

@section('conteudo')

<div class="panel panel-default">
	<div class="panel-heading"><h5>Lista de clientes</h5></div>
	<div class="panel-body">

	<table class="table table-bordered">
		<thead>
			<tr>
				<td>Nome</td>
				<td>E-mail</td>
				<td>Telefone</td>
				<td>Edita</td>
				<td>Excluir</td>
				<td>Lista Email</td>
			</tr>
		</thead>

@foreach($lista as $li)
		<tr>
			<td>{{$li->nome}}</td>
			<td>{{$li->email}}</td>
			<td>{{$li->telefone}}</td>
			<td>--</td>
			<td>--</td>
			<td>--</td>
		</tr>	
@endforeach
	</table>

</div>


@stop