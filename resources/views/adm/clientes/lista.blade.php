@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Clientes</h1>

	@if(Session::has('msg_retorno'))
	<div class="alert alert-{{Session::get('tipo_retorno')}}">
	     {{Session::get('msg_retorno')}}
	 </div>
	@endif

		<div class="panel panel-default">
			<div class="panel-heading">

			<div class="row">
				<div class="col-md-6">
					<h4>Lista de clientes</h4>
				</div>
					<div class="col-md-6">
						<div class="inline text-right">
							<ul class="pagination">
								<li>
									<a href="{!! $lista->previousPageUrl() !!}" rel="prev">«</a>
								</li>
								<li>
									<a href="{!! $urlPagination.'1' !!}">1</a>
								</li>
								<li class="active">
									<a href="#">{!! $lista->currentPage() !!}</a>
								</li>
								<li>
									<a href="{!! $urlPagination.$lista->lastPage() !!}" rel="prev">{!! $lista->lastPage() !!}</a>
								</li>
								<li>
									<a href="{!! $lista->nextPageUrl() !!}" rel="prev">»</a>
								</li>
							</ul>	
						</div>
					</div>
			</div>
			</div>

			<div class="panel-body">

				<div class="row">
					<div class="col-md-7">
						
						<div class="form-group">
							{!! Form::select('id', $clientesForSelect, null, ['class' => 'form-control', 
							'single' => 'single', 'id' => 'clientes', 'placeholder' => 'Selecione um cliente'])   !!}
						</div>

					</div>
					<div class="col-md-2">
						<div class="form-group">
							<a class="btn btn-default btn-sm" id="linkCliente"> Detalhes</a>
						</div>
					</div>

				
					<div class="col-md-3">

					</div>
				</div>


			<table class="table table-bordered">
				<thead>
					<tr>
						<td>Nome</td>
						<td>E-mail</td>
						<td>Telefone</td>
						<td>Mostra</td>
						<td>Excluir</td>
						<td>Lista Email</td>
						<td>Envia prato</td>
					</tr>
				</thead>

		@foreach($lista as $li)
				<tr>
					<td>{{$li->nome}}</td>
					<td>{{$li->email}}</td>
					<td>{{$li->telefone}}</td>
					<td class="text-center"><a href="/admin/clientes/{{$li->id}}/mostra"><i class="fa fa-search"></i></a></td>
					<td class="text-center"><a href="/admin/clientes/excluir/{{$li->id}}"><i class="fa fa-trash"></i></a></td>
					<td>
					@if($li->opt_email == 1)
						<a href="/admin/clientes/sairEmail/{{$li->id}}"><i class="fa fa-check-square-o"></i></a>
					@else
						<a href="/admin/clientes/entrarEmail/{{$li->id}}"><i class="fa fa-square-o"></i></a>
					@endif

					</td>
					<td class="text-center"><a href="/admin/clientes/enviaPrato/{{$li->id}}"><i class="fa fa-envelope-o"></i></a></td>
				</tr>	
		@endforeach
			</table>
			
			</div>
		</div>


    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/clientes.js') !!}"></script>

			<script type="text/javascript">

			$("#clientes").change(function() 
			{
				var id = $(this).val();
			 	var href = '/admin/clientes/' + id + '/mostra';
			    //adiciona o valor do id recebido como parametro na funcao
				$('#linkCliente').prop("href", href);
			});

			</script>



	    @stop



@stop