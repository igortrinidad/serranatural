@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Despesa simples</h2><br>

	@if(Session::has('msg_retorno'))
		<div class="alert alert-{{Session::get('tipo_retorno')}}">
		     {{Session::get('msg_retorno')}}
		 </div>
	@endif

	@if($errors->any())
		<div class="alert alert-danger">
			<ul>
			@foreach($errors->all() as $message)
				<li> {{$message}}</li>
			@endforeach
			</ul>
		</div>
	@endif

<div class="row">

	<div class="col-md-7">

	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Informe os dados da despesa</h4>
		</div>
		<div class="panel-body">
			
			<form action="{{route('admin.financeiro.despesaStore')}}" method="POST" enctype="multipart/form-data">

				{!! csrf_field() !!}
			

				<div class="row">
					<div class="col-md-8">
						<div class="form-group">
							<label>Valor</label>
							<input type="text" name="valor" class="form-control moneySql" required/>
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group">
							<label>Data despesa</label>
							<input type="text" name="data_pgto" class="form-control datepicker dataCompleta" required/>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label>Descrição</label>
					<input type="text" name="descricao" class="form-control"/>
				</div>

				<div class="form-group">
					<label>Fonte pagamento</label>
					<input type="text" name="fonte_pgto" class="form-control"/>
				</div>

				<div class="form-group">
					<label>Observações</label>
					<textarea type="textarea" class="form-control" name="observacoes"></textarea>
				</div>

				<div class="form-group">
					<label>Comprovante</label>
					<input type="file" name="comprovante" class="form-control"/>
				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-block">Cadastrar despesa</button>
				</div>

				
			</form>

		</div>
	</div>

	</div>

</div>


    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/financeiro.js') !!}"></script>

			<script type="text/javascript">
				$('.moneySql').mask('000000.00', {reverse: true});
			
			</script>


	@stop

@stop