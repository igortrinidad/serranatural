@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Fidelidade</h1>

	@if(Session::has('msg_retorno'))
	<div class="alert alert-{{Session::get('tipo_retorno')}}">
	     {{Session::get('msg_retorno')}}
	 </div>
	@endif

		<div class="panel panel-default">
			<div class="panel-heading"><h5>Selecione um cliente</h5></div>
			<div class="panel-body">

				<div class="row">
					<div class="col-md-6">
						
						<div class="form-group">
							{!! Form::open(array('action' => 'ClienteController@salvaPonto')) !!}
							{!! Form::select('cliente_id', $clientesForSelect, null, ['class' => 'form-control', 
							'single' => 'single', 'id' => 'clientes'])   !!}
						</div>

					</div>

					<div class="col-md-3">
						<select class="form-control input-sm" name="produto">
							<option>Açaí</option>
							<option>Almoço</option>
						</select>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							{!! Form::submit('Salvar!', ['class' => 'btn btn-default btn-sm']) !!}
							{!! Form::close() !!}
						</div>
					</div>

				
				</div>


			
			</div>
		</div>


		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-8">
						<h5>Pontos coletados</h5>
					</div>
					<div class="col-md-4">
						<div class="inline text-right">

							{!! $pontosColetados->render() !!}
							
						</div>
					</div>
				</div>
			</div>	
			<div class="panel-body">


			<table class="table table-bordered">
				<thead>
					<tr>
						<td>Nome cliente</td>
						<td>E-mail</td>
						<td>Data coleta</td>
						<td>Produto</td>
						<td>Valido</td>
					</tr>
				</thead>

		@foreach($pontosColetados as $ponto)
				<tr>
					<td>{{$ponto->cliente->nome}}</td>
					<td>{{$ponto->cliente->email}}</td>
					<td>{{$ponto->data_coleta}}</td>
					<td>{{$ponto->produto}}</td>
					<td>{{$ponto->is_valido}}</td>
				</tr>	
		@endforeach
			</table>
			
			</div>
		</div>

    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/clientes.js') !!}"></script>

	    @stop



@stop