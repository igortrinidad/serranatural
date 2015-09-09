@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Clientes</h1>

		<div class="panel panel-default">
			<div class="panel-heading"><h5>Lista</h5></div>
			<div class="panel-body">
				<div class="inline text-right">
					<a href="{!! $lista->previousPageUrl() !!}" class="btn btn-primary"><i class="fa fa-chevron-left"></i></a>
					<a href="{!! $lista->nextPageUrl() !!}" class="btn btn-primary"><i class="fa fa-chevron-right"></i></a>
				</div><br />

			<table class="table table-bordered">
				<thead>
					<tr>
						<td>Nome</td>
						<td>E-mail</td>
						<td>Telefone</td>
						<td>Mostra</td>
						<td>Excluir</td>
						<td>Lista Email</td>
					</tr>
				</thead>

		@foreach($lista as $li)
				<tr>
					<td>{{$li->nome}}</td>
					<td>{{$li->email}}</td>
					<td>{{$li->telefone}}</td>
					<td class="text-center"><a href="/admin/clientes/edita/{{$li->id}}"><i class="fa fa-search"></i></a></td>
					<td>--</td>
					<td>
					@if($li->opt_email == 1)
						<a href="/admin/clientes/sairEmail/{{$li->id}}"><i class="fa fa-check-square-o"></i></a>
					@else
						<a href="/admin/clientes/entrarEmail/{{$li->id}}"><i class="fa fa-square-o"></i></a>
					@endif

					</td>
				</tr>	
		@endforeach
			</table>
			
			</div>
		</div>



@stop