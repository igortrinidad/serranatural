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


    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/clientes.js') !!}"></script>

	    @stop



@stop