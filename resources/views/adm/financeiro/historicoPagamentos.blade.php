@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Histórico de pagamentos</h2><br>

	@include('errors.messages')

<div class="row" id="historicoPagamentos">

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
			            <th>Fonte pgto</th>
			            <th>Responsável Pagamento</th>
			            <th>Arquivo pagamento</th>
			            <th>Arq comprovante</th>
			        </tr>
			    </thead>
			    <tbody>
			    @foreach($pagamentos as $pag)
			        <tr>
			            <td class="text-center">@if($pag->is_liquidado == 0)<strong style="color:red">Pendente</strong> @else Liquidado - ({{$pag->data_pgto}}) @endif </td>
			            <td class="text-center">{{$pag->vencimento}}</td>
			            <td><a href="{{route('admin.financeiro.detalhes', $pag->id)}}">{{$pag->descricao}}</a></td>
			            <td>{{$pag->valor}}</td>
			            <td>{{$pag->fonte_pgto}}</td>
			            <td>
			            	@if(!$pag->user_id_pagamento or $pag->user_id_pagamento == 0) 
			            		Não informado 
			            	@elseif(!$pag->usuarioPagamento)
								Usuário excluído
			            	@else 
			            		{{ $pag->usuarioPagamento->name }} 
			            	@endif
			            </td>
			            <td class="text-center" width="10%">
			            @if($pag->pagamento != '')
			            	<a href="{!! route('arquivos.pagamentos', $pag->pagamento) !!}" data-lightbox="property"><i class="fa fa-search" ></i>
			            @endif
			            	</a>
			            </td>
			            <td class="text-center" width="10%">
			            @if($pag->comprovante != '')
			            	<a href="{!! route('arquivos.pagamentos', $pag->comprovante) !!}" data-lightbox="property"><i class="fa fa-search">
			            @endif 
			            </td>
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
	
			<p><b>Periodo<b></p>
			<p>{{isset($dataInicio) ? $dataInicio : '--'}} - {{isset($dataFim) ? $dataFim : '--'}} 
			<p><b>Total</b></p>
			<p>R$ {{isset($totalPeriodo) ? $totalPeriodo : '--'}}</p>


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

				$('input[name="dataInicio"').val(dataInicio);
				$('input[name="dataFim"').val(dataFim);
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


			<script type"text/javascript">


				Vue.config.debug = true;
				Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#_tokenLaravel').getAttribute('value');
				var vm = new Vue({
				    el: '#historicoPagamentos',
				    data: 
				    {	
				    	
				    },
				    ready: function(){
				    	console.log('Estou ready!');
				    },
				    methods:
				    {
				    },
				});

			</script>


	@stop

@stop