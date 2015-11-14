@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Cadastro de boleto</h2><br>

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
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Informe a linha digitavel do boleto</h4>
		</div>
		<div class="panel-body">
			
			<form action="{{route('admin.financeiro.pagamentosPost')}}" method="POST" enctype="multipart/form-data">

				{!! csrf_field() !!}

				<div class="form-group">
					<select id="tipo-boleto" class="form-control">
						<option value="1">Boleto</option>
						<option value="2">Agua, Luz, Telefone, Impostos</option>
					</select>
				</div>

				
				<div class="form-group">
					<label>Linha digitavel</label>
					<input type="text" name="linha_digitavel" class="form-control linha-digitavel"/>
				</div>
				<div class="row">
					<div class="col-md-8">
						<div class="form-group">
							<label>Valor</label>
							<input type="text" name="valor" class="form-control moneySql" required/>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Vencimento</label>
							<input type="text" name="vencimento" class="form-control datepicker dataCompleta" required/>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label>Descrição</label>
					<input type="text" name="descricao" class="form-control"/>
				</div>

				

				<div class="form-group">
					<label>Arquivo pagamento</label>
					<input type="file" name="pagamento" class="form-control"/>
				</div>

				<div class="form-group">
					<label>Arquivo Nota fiscal</label>
					<input type="file" name="notaFiscal" class="form-control"/>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-block">Cadastrar conta</button>
				</div>
			</form>

		</div>
	</div>

</div>


    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/financeiro.js') !!}"></script>

	        <script type="text/javascript">

	        $('.linha-digitavel').mask('00000.00000.00000.000000.00000.000000.0.00000000000000');
	        $('.moneySql').mask('000000.00', {reverse: true});
	        
	        $('#tipo-boleto').on('change', function() {
				  if($( "#tipo-boleto option:selected" ).val() == 2)
	        	{

	        	$('.linha-digitavel').mask('00000000000-0 00000000000-0 00000000000-0 00000000000-0');
		        } else if($( "#tipo-boleto option:selected" ).val() == 1)
		        {
		        $('.linha-digitavel').mask('00000.00000 00000.000000 00000.000000 0 00000000000000');
		    	}	
	        

			});

	        	
	        
	        </script>

	@stop

@stop