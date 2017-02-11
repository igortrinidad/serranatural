@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Detalhes</h2>

@include('errors.messages')

<div class="row">
	<div class="col-md-7">

	
	<div class="panel panel-default">
		<div class="panel-heading">
		<h5>Prato</h5>
		</div>
		<div class="panel-body">
			
		
			<label>Nome</label>
			<p>{{$prato->prato}}</p>

			<label>Acompanhamentos</label>
			<p>{!!nl2br($prato->acompanhamentos)!!}</p>


			<label>Preço pequeno</label>
			<p>{{ moneyBR($prato->valor_pequeno) }}</p>

			<label>Preço grande</label>
			<p>{{ moneyBR($prato->valor_grande) }}</p>

		</div>
	</div>


	<div class="panel panel-default">
		<div class="panel-heading"><h5>Preparo</h5></div>
		<div class="panel-body">

			<div class="form-group">
				<label>Modo de preparo</label>
				<p>{!!nl2br($prato->modo_preparo)!!}</p>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading"><h5>Fica técnica</h5></div>
		<div class="panel-body">

			<table class="table table-bordered">
				<thead>
					<tr>
						<td class="text-center">Nome</td>
						<td class="text-center">Quantidade / prato</td>
						<td class="text-center">Unidade</td>
						<td class="text-center">Excluir</td>
						<td class="text-center">Custo</td>
					</tr>
				</thead>
				<tbody>
					
					@foreach($prato->produtos as $produto)
					<tr>
						<td><a href="/admin/produtos/show/{{$produto->id}}">{{$produto->nome_produto}}</a></td>
						<td>{{$produto->pivot->quantidade}}</td>
						<td>{{$produto->pivot->unidade}}</td>
						<td>
							<a href="/admin/produtos/ingredientes/excluir/{{$produto->id}}/{{$prato->id}}">Excluir</a>
						</td>
						<td width="20%">{{ moneyBR($produto->custo) }}</td>
					</tr>

					@endforeach
					<tr class="text-right">
						<td colspan="4">Custo total</td>
						<td>{{ moneyBR($prato->total) }}</td> 
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading"><h5>Simulação de custo para: {{$quantidade}} unidades</h5></div>
		<div class="panel-body">

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Quantidade</label>
						<input class="form-control" value="{{$quantidade}}" id="novaQuantidadeInput" />
					</div>
				</div>

				<div class="col-md-6">
					<button class="btn btn-primary m-t-25" id="buttonAlteraQuantidade">Alterar quantidade para simulação</button>
				</div>
			</div>

			<table class="table table-bordered">
				<thead>
					<tr>
						<td class="text-center">Nome</td>
						<td class="text-center">Quantidade / prato</td>
						<td class="text-center">Unidade</td>
						<td class="text-center">Excluir</td>
						<td class="text-center">Custo</td>
					</tr>
				</thead>
				<tbody>
					
					@foreach($prato->produtos as $produto)
					<tr>
						<td><a href="/admin/produtos/show/{{$produto->id}}">{{$produto->nome_produto}}</a></td>
						<td>{{$produto->quantidade_calculado}}</td>
						<td>{{$produto->pivot->unidade}}</td>
						<td>
							<a href="/admin/produtos/ingredientes/excluir/{{$produto->id}}/{{$prato->id}}">Excluir</a>
						</td>
						<td width="20%">{{ moneyBR($produto->custo_calculado) }}</td>
					</tr>

					@endforeach
					<tr class="text-right">
						<td colspan="4">Custo total</td>
						<td>R$ {{ moneyBR($prato->total_calculado) }}</td> 
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	</div>

	<div class="col-md-5">
		<div class="panel panel-default">
			<div class="panel-body">
				<a href="/admin/produtos/pratos/edita/{{$prato->id}}" class="btn btn-primary btn-block">Editar<i class="fa fa-pencil"></i></a>
				<a href="/admin/produtos/pratos/excluir/{{$prato->id}}" class="btn btn-danger btn-block">Excluir<i class="fa fa-trash"></i></a>
			</div>
		</div>

		@if($prato->foto)
		<div class="panel panel-default">
			<div class="panel-heading"><h5>Foto</h5></div>
			<div class="panel-body">
				<label>Titulo foto</label>
				<p>{{$prato->titulo_foto}}</p>
				<img class="img-polaroid" src="{{ route('arquivos.produtos', $prato->foto)}}" style="max-width: 100%" />
			</div>
		</div>
		@endif

		<div class="panel panel-default">
			<div class="panel-heading"><h5>Inserir ingredientes</h5></div>
			<div class="panel-body">

				<form action="/admin/produtos/pratos/ingredientes/add" method="POST" class="form-group">

					<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
					<input type="hidden" name="prato_id" value="{{$prato->id}}" />


					<div class="form-group">
						<label>Nome produto</label>
						<div class="form-group">
				              {!! Form::select('produtos_id[]', $produtosForSelect, null, ['class' => 'form-control', 
				              'single' => 'single', 'id' => 'produtos'])   !!}
				        </div>
					</div>

					<div class="form-group">
						<label>Quantidade</label>
						<input type="text" name="quantidade" class="form-control gramas"/>
					</div>

					<div class="form-group">
						<label>Unidade</label>
						<select class="form-control" name="unidade">
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

		
			
	</div>

</div>

		

	


	    @section('scripts')
	    @parent

			<script type="text/javascript">
				$('#produtos').select2();
				$('.gramas').mask('000.000', {reverse: true})

				$('#buttonAlteraQuantidade').on('click', function(){
					window.location.href='/admin/produtos/pratos/mostra/' + {{$prato->id}} + '/?quantidade=' + $('#novaQuantidadeInput').val();
				})
			</script>

		@stop

@stop