@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Detalhes pagamento</h2><br>

	@if(Session::has('msg_retorno'))
	<div class="alert alert-{{Session::get('tipo_retorno')}}">
	     {{Session::get('msg_retorno')}}
	 </div>
	@endif

<div class="row">
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Detalhes pagamento</h4>
		</div>
		<div class="panel-body">
			
			<div class="row">

				<div class="col-md-7">

					<label>Data de vencimento</label>
					<p>{{$pagamento->vencimento}}</p>

					<label>Descrição</label>
					<p>{{$pagamento->descricao}}</p>

					<label>Valor</label>
					<p>{{$pagamento->valor}}</p>

					<label>Linha digitavel</label>
					<p>{{$pagamento->linha_digitavel}}</p>

					<label>Observações</label>
					<p>{{$pagamento->observacoes}}</p>

					<label>Documento</label>
					<p><a href="{{ route('arquivos.pagamentos', $pagamento->pagamento)}}"><img src="{{ route('arquivos.pagamentos', $pagamento->pagamento)}}" width="300" /></a></p>

					<label>Nota Fiscal</label>
					<p><a href="{{ route('arquivos.pagamentos', $pagamento->notaFiscal)}}"><img src="{{ route('arquivos.pagamentos', $pagamento->notaFiscal)}}" width="300" /></a></p>

					<label>Data de pagamento</label>
					<p>{{$pagamento->data_pgto}}</p>

					<label>Data de pagamento</label>
					<p>{{$pagamento->user_id_pagamento}}</p>

					<label>Origem do pagamento</label>
					<p>{{$pagamento->fonte_pgto}}</p>

					<label>Comprovante</label>
					<p><a href="{{ route('arquivos.pagamentos', $pagamento->comprovante)}}"><img src="{{ route('arquivos.pagamentos', $pagamento->comprovante)}}" width="300" /></a></p>
				</div>
				<div class="col-md-5">
					
					@if($pagamento->is_liquidado == 0)
					<form action="{{route('admin.financeiro.liquidar')}}" method="POST" enctype="multipart/form-data">

						{!! csrf_field() !!}

						<input type="hidden" name="pagamento_id" value="{{$pagamento->id}}" />

						<input type="hidden" class="checkbox" name="is_liquidado" value="0" checked="checked"/>
								
						<label>Liquidado?</label>
						<input type="checkbox" class="checkbox" name="is_liquidado" value="1" checked="checked"/>

						<div class="form-group">
							<label>Data Pagamento</label>
							<input type="text" name="data_pgto" class="form-control datepicker dataCompleta" />
						</div>

						<div class="form-group">
							<label>Fonte pagamento</label>
							<input type="text" name="fonte_pgto" class="form-control" />
						</div>

						<div class="form-group">
							<label>Comprovante</label>
							<input type="file" name="comprovante" class="form-control" />
						</div>

						<button type="submit" class="btn btn-primary">Liquidar</button>
					</form>

					@else
					<div id="alteraPagamento" class="btn btn-primary pull-right">Alterar pagamento</div>

					<div id="formAltera2" hidden="true">
					
						<form action="{{route('admin.financeiro.liquidar')}}" method="POST" enctype="multipart/form-data">
							{!! csrf_field() !!}

							<input type="hidden" name="pagamento_id" value="{{$pagamento->id}}" />
							
							<div class="form-group">
								
								<input type="hidden" class="checkbox" name="is_liquidado" value="0" checked="checked"/>

								<label>Liquidado?</label>
								<input type="checkbox" class="checkbox" name="is_liquidado" value="1" checked="checked"/>
							</div>
							<div class="form-group">
								<label>Data Pagamento</label>
								<input type="text" name="data_pgto" class="form-control datepicker dataCompleta" />
							</div>

							<div class="form-group">
								<label>Fonte pagamento</label>
								<input type="text" name="fonte_pgto" class="form-control" />
							</div>

							<div class="form-group">
								<label>Comprovante</label>
								<input type="file" name="comprovante" class="form-control" />
							</div>

							<button type="submit" class="btn btn-primary">Liquidar</button>
						</form>
					</div>

					@endif

					



				</div>

			</div>
		</div>
	</div>

</div>


    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/financeiro.js') !!}"></script>

	        <script type="text/javascript">
 	
	        	$('#alteraPagamento').on("click", function(e)
	        	{
	        		e.preventDefault();

	        		$('#formAltera2').show();
	        		$('#alteraPagamento').hide();

	        	});

	        
	        </script>

	@stop

@stop