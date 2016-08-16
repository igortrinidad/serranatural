@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Detalhes pagamento</h2>

@if(Session::has('msg_retorno'))
<div class="alert alert-{{Session::get('tipo_retorno')}}">
	{{Session::get('msg_retorno')}}
</div>
@endif

<div class="row">

	<div class="col-md-7">

		@if($pagamento->is_liquidado == 0)
		<div class="panel panel-default">
			@else
			<div class="panel panel-success">
				@endif

				<div class="panel-heading">
					<h4>Detalhes</h4>
				</div>
				<div class="panel-body">

					<label>Cadastrada quando</label>
					<p>{{$pagamento->created_at->format('d/m/Y H:i:s')}}</p>

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

					<label>Documento de pagamento</label>
					<p>
						@if(is_null($pagamento->pagamento) OR empty($pagamento->pagamento))
						--
						@elseif(substr($pagamento->pagamento, -3) == 'pdf' OR substr($pagamento->pagamento, -3) == 'PDF')
						<a target="_blank" href="{{ route('arquivos.pagamentos', $pagamento->pagamento)}}" >PDF
						</a>
						@else
						<a href="{{ route('arquivos.pagamentos', $pagamento->pagamento)}}" data-lightbox="property">
							<img class="img-polaroid" src="{{ route('arquivos.pagamentos', $pagamento->pagamento)}}" width="300" />
						</a>
						@endif
					</p>

					<label>Nota Fiscal</label>
					<p>
						@if(is_null($pagamento->notaFiscal) OR empty($pagamento->notaFiscal))
						--
						@elseif(substr($pagamento->notaFiscal, -3) == 'pdf' OR substr($pagamento->notaFiscal, -3) == 'PDF')
						<a target="_blank" href="{{ route('arquivos.pagamentos', $pagamento->notaFiscal)}}">PDF</a>
						@else
						<a href="{{ route('arquivos.pagamentos', $pagamento->notaFiscal)}}" data-lightbox="property">
							<img class="img-polaroid" src="{{ route('arquivos.pagamentos', $pagamento->notaFiscal)}}" width="300" />
						</a>
						@endif
					</p>
				</div>
			</div>
	</div>




	<div class="col-md-5">

		<div class="panel panel-default">
			<div class="panel-body">

				<h5>@if($pagamento->is_liquidado == 1)<P class="pull-right">Pagamento realizado em : {{$pagamento->data_pgto}}</P>@endif
				</h5><br>

				<a href="{{route('admin.financeiro.editPagamento', $pagamento->id)}}" class="btn btn-warning btn-block">Editar pagamento</a>

			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Liquidar pagamento</h4>
			</div>
			<div class="panel-body">
				
				@if($pagamento->is_liquidado == 0)
				<form action="{{route('admin.financeiro.liquidar')}}" method="POST" enctype="multipart/form-data">

					{!! csrf_field() !!}

					<input type="hidden" name="pagamento_id" value="{{$pagamento->id}}" />

					<input type="hidden" class="checkbox" name="is_liquidado" value="0" checked="checked"/>

					<label>Liquidado?</label>
					<input type="checkbox" class="checkbox" name="is_liquidado" value="1" checked="checked"/>

					<div class="form-group">
						<label>Data Pagamento</label>
						<input type="text" name="data_pgto" class="form-control datepicker dataCompleta" required/>
					</div>

					<div class="form-group">
						<label>Valor pago</label>
						<input type="text" name="fonte_pgto" class="form-control moneySql" />
					</div>

					<div class="form-group">
						<label>Fonte pagamento</label>
						<input type="text" name="fonte_pgto" class="form-control" />
					</div>

					<div class="form-group">
						<label>Comprovante</label>
						<input type="file" name="comprovante" class="form-control" />
					</div>

					<button type="submit" class="btn btn-primary btn-block">Liquidar</button>
				</form>

				<div class="row">

					@else
					<div id="alteraPagamento" class="btn btn-primary btn-block">Alterar comprovante</div>

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
								<input type="text" name="data_pgto" value="" class="form-control datepicker dataCompleta" required/>
							</div>

							<div class="form-group">
								<label>Fonte pagamento</label>
								<input type="text" name="fonte_pgto" class="form-control" />
							</div>

							<div class="form-group">
								<label>Comprovante</label>
								<input type="file" name="comprovante" class="form-control" />
							</div>

							<button type="submit" class="btn btn-primary btn-block">@if($pagamento->is_liquidado == 1)Alterar @else Liquidar @endif</button>
						</form>
					</div>

				</div>

			</div>



			@endif


		</div>
	</div>
</div>

	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Arquivo comprovante</h4>
			</div>
			<div class="panel-body">

				@if($pagamento->is_liquidado == 1)					

				<label>Data de pagamento</label>
				<p>{{$pagamento->data_pgto}}</p>

				<label>Usuário pagamento</label>
				<p>@if(!$pagamento->user_id_pagamento or $pagamento->user_id_pagamento == 0) Não informado @else {{ $pagamento->usuarioPagamento->name }} @endif</p>

				<label>Origem do pagamento</label>
				<p>{{$pagamento->fonte_pgto}}</p>

				<label>Comprovante</label>
				<p>
					@if(substr($pagamento->comprovante, -3) == 'pdf' OR substr($pagamento->comprovante, -3) == 'PDF')
					<a target="_blank" href="{{ route('arquivos.pagamentos', $pagamento->comprovante)}}"><STRONG>PDF</STRONG></a>
					@elseif(is_null($pagamento->comprovante) OR empty($pagamento->comprovante))
					--
					@else
					<a href="{{ route('arquivos.pagamentos', $pagamento->comprovante)}}" data-lightbox="property">
						<img src="{{ route('arquivos.pagamentos', $pagamento->comprovante)}}" width="300" />
					</a>
					@endif
				</p>

				@endif
			</div>
		</div>
	</div>
					

	<div class="col-md-12">

		<div class="panel panel-default">

			<div class="panel-heading">
				<h4>Produtos adquiridos</h4>
			</div>
			<div class="panel-body">
				@if($pagamento->produtos)

					<table class="table table-bordered table-striped">
					    <thead>
					    	
					        <tr>
					            <th>Produto</th>
					            <th>Quantidade</th>
					        </tr>
					    </thead>
					    <tbody>
					    	@foreach($pagamento->produtos as $p)
					        <tr>
					            <td>{{$p->produto->nome_produto}}</td>
					            <td>{{$p->quantity}}</td>
					        </tr>
					        @endforeach
					    </tbody>
					</table>

				@endif
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