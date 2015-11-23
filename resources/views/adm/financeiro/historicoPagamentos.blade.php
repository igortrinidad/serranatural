@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Histórico de pagamentos</h2><br>

	@if(Session::has('msg_retorno'))
	<div class="alert alert-{{Session::get('tipo_retorno')}}">
	     {{Session::get('msg_retorno')}}
	 </div>
	@endif

<div class="row">

	<div class="panel panel-default">

		<div class="panel-body">
			<form action="{{route('admin.financeiro.dateRange')}}" method="post" class="form-inline" role="form">
				
				{!! csrf_field() !!}
				<input type="hidden" name="dataInicio" value="" class="form-control"/>
				<input type="hidden" name="dataFim" value="" class="form-control"/>

				<div class="form-group col-md-9">
					<input type="text" name="dateRange" value="" class="form-control" placeholder="Selecione o periodo da pesquisa" style="width: 100%;"/>
				</div>
				
				<div class="form-group col-md-3">
					<button type="submit" class="btn btn-primary btn-block">Pesquisar</button>
				</div>
				

			</form>
		</div>
	</div>
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Pagamentos</h4>
		</div>
		<div class="panel-body">
			
			<table class="table table-bordered table-hover table-striped">
			    <thead>

			        <tr>
			            <th>Situação</th>
			            <th>Vencimento</th>
			            <th>Descrição</th>
			            <th>Valor</th>
			            <th>Responsável Pagamento</th>
			            <th>Data pagamento</th>
			            <th>Arq comprovante</th>
			        </tr>
			    </thead>
			    <tbody>
			    @foreach($pagamentos as $pag)
			        <tr>
			            <th class="text-center">@if($pag->is_liquidado == 0)<strong style="color:red">Pendente</strong> @else Liquidado - ({{$pag->data_pgto}}) @endif </th>
			            <th class="text-center">{{$pag->vencimento}}</th>
			            <th><a href="{{route('admin.financeiro.detalhes', $pag->id)}}">{{$pag->descricao}}</a></th>
			            <th>{{$pag->valor}}</th>
			            <th>{{$pag->usuarioPagamento->name}}</th>
			            <th class="text-center" width="10%">
			            @if($pag->data_pgto != '')
			            	<a href="{!! route('arquivos.pagamentos', $pag->pagamento) !!}" data-lightbox="property"><i class="fa fa-search"></i></a>
			            @endif
			            	</a>
			            </th>
			            <th class="text-center" width="10%">
			            @if($pag->comprovante != '')
			            	<a href="{!! route('arquivos.pagamentos', $pag->notaFiscal) !!}" data-lightbox="property"><i class="fa fa-search"></i></a>
			            @endif 
			            </th>
			        </tr>
			    @endforeach
			    </tbody>
			</table>
			
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Total</h4>
		</div>
		<div class="panel-body">
	
			<label>Total periodo: R$ {{isset($totalPeriodo) ? $totalPeriodo : '--'}}</label>

		</div>

	</div>

</div>


    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/financeiro.js') !!}"></script>

			<script type="text/javascript">

			'use strict';

				var dataInicio = moment().format('YYYY-MM-DD');
				var dataFim = moment().format('YYYY-MM-DD');
				console.log(dataInicio + ' - ' + dataFim);

				$('input[name="dateRange"]').daterangepicker({

					    locale: {
					      format: 'DD/MM/YYYY',
					    },
				    "ranges": {
				        "Hoje": [
				            moment(),
				            moment()
				        ],
				        "Ontem": [
				            moment().subtract(1, 'days'),
				            moment().subtract(1, 'days')
				        ],
				        "Ultima semana": [
				            moment().subtract(7, 'days'),
				            moment()
				        ],
				        "Este mês": [
				            moment().startOf('month').format('DD/MM/YYYY'),
				            moment().endOf('month').format('DD/MM/YYYY')
				        ],
				        "Mês passado": [
				            moment().subtract(1, 'months').startOf('month').format('DD/MM/YYYY'),
				            moment().subtract(1, 'months').endOf('month').format('DD/MM/YYYY')
				        ],
				        "Este ano": [
				            moment().startOf('year').format('DD/MM/YYYY'),
				            moment().format('DD/MM/YYYY')
				        ]
				    },

				}, function(start, end, label) {

				dataInicio = start.format('YYYY-MM-DD');
				dataFim = end.format('YYYY-MM-DD');

				console.log(dataInicio + ' - ' + dataFim);

				$('input[name="dataInicio"').val(dataInicio);
				$('input[name="dataFim"').val(dataFim);

				});

			</script>


	@stop

@stop