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
			
			<div class="form-group">
			<label>E-mail</label>
			<p>{{$cliente->email}}</p>
			</div>

		<a href="/admin/clientes/edita/{{$cliente->id}}" class="btn btn-primary">Editar<i class="fa fa-pencil"></i></a>

	</div>
</div>

</div>


	<div class="panel panel-default">
		<div class="panel-heading"><h5>Preferências</h5></div>
		<div class="panel-body">

			<table class="table table-bordered">
				<thead>
					<tr>
						<td class="text-center">Nome</td>
						<td class="text-center">Quantidade / prato</td>
						<td class="text-center">Unidade</td>
						<td class="text-center">Editar</td>
						<td class="text-center">Excluir</td>
					</tr>
				</thead>

				@foreach($ingredientes as $ingrediente)
				<tr>
					<td>{{$ingrediente->produto->nome_produto}}</td>
					<td>{{$ingrediente->quantidade}}</td>
					<td>{{$ingrediente->medida}}</td>
					<td class="text-center"><a href="/admin/produtos/ingrediente/editar/{{$ingrediente->id}}"><i class="fa fa-pencil"></i></td>
					<td class="text-center"><a href="/admin/produtos/ingrediente/excluir/{{$ingrediente->id}}"><i class="fa fa-trash"></i></td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>


@stop