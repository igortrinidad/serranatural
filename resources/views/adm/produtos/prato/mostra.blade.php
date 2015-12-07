@extends('layout/admin')

@section('conteudo')


<h2 class="text-right">Detalhes</h2>

	@include('errors.messages')

	<div class="panel panel-default">
		<div class="panel-heading">
		<h5>Prato</h5>
		</div>
		<div class="panel-body">
			
			<div class="col-md-6">
		
			<label>Nome</label>
			<p>{{$prato->prato}}</p>

			<label>Acompanhamentos</label>
			<p>{!!nl2br($prato->acompanhamentos)!!}</p>


			<label>Preço pequeno</label>
			<p>R$ {{number_format($prato->valor_pequeno, 2, ',', '.')}}</p>

			<label>Preço grande</label>
			<p>R$ {{number_format($prato->valor_grande, 2, ',', '.')}}</p>

			</div>

			<div class="col-md-6">

			<img class="img-polaroid" src="{{ route('arquivos.produtos', $prato->foto)}}" width="300" />
			<br><br>

			<label>Titulo foto</label>
			<p>{{$prato->titulo_foto}}</p>
			</div>

			
			<a href="/admin/produtos/pratos/edita/{{$prato->id}}" class="btn btn-primary">Editar<i class="fa fa-pencil"></i></a>
			<a href="/admin/produtos/pratos/excluir/{{$prato->id}}" class="btn btn-danger">Excluir<i class="fa fa-trash"></i></a>

		</div>
	</div>


	<div class="panel panel-default">
		<div class="panel-heading"><h5>Preparo</h5></div>
		<div class="panel-body">

			<label>Modo de preparo</label>
			<p>{!!nl2br($prato->modo_preparo)!!}</p>

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

	<div class="panel panel-default">
		<div class="panel-heading"><h5>Inserir ingredientes</h5></div>
		<div class="panel-body">

			<form action="/admin/produtos/pratos/ingredientes/add" method="POST" class="form-group">

				<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
				<input type="hidden" name="prato_id" value="{{$prato->id}}" />


				<div class="form-group">
					<label>Nome</label>
					<select name="produto_id" class="form-control">
						@foreach($produtos as $produto)
							<option value="{{$produto->id}}">{{$produto->nome_produto}}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group">
					<label>Quantidade</label>
					<input type="text" name="quantidade" class="form-control"/>
				</div>

				<div class="form-group">
					<label>Unidade</label>
					<select class="form-control" name="medida">
						<option>KG</option>
						<option>UNIDADE</option>
						<option>BANDEJA</option>
						<option>PACOTE</option>
						<option>LITROS</option>
					</select>
				</div>

				<button type="submit" class="btn btn-primary">Cadastrar ingrediente</button>
                               

			</form>

	</div>
</div>


@stop