@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Histórico de Retiradas</h2><br>

	@include('errors.messages')

<div class="row">

			<div class="form-inline text-right">
				<ul class="pagination">
					<li>
						<a href="{!! $retiradas->previousPageUrl() !!}" rel="prev">«</a>
					</li>
					<li>
						<a href="{{ route('admin.financeiro.retiradasList').'/?page=1' }}">1</a>
					</li>
					<li class="active">
						<a href="#">{!! $retiradas->currentPage() !!}</a>
					</li>
					<li>
						<a href="{{ route('admin.financeiro.retiradasList').'/?page='.$retiradas->lastPage() }}" rel="prev">{!! $retiradas->lastPage() !!}</a>
					</li>
					<li>
						<a href="{!! $retiradas->nextPageUrl() !!}" rel="prev">»</a>
					</li>
				</ul>	
			</div>
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Retiradas</h4>
		</div>
		<div class="panel-body">
			
			<table class="table table-bordered table-hover table-striped">
			    <thead>

			        <tr>
			            <th width="15%" class="text-center">Data</th>
			            <th width="10%" class="text-center">Valor</th>
			            <th width="20%" class="text-center">Descrição</th>
			            <th width="15%" class="text-center">Quem fez?</th>
			            <th width="10%" class="text-center">Retirado caixa</th>
			            <th width="15%" class="text-center">Para quem?</th>
			            <th width="10%" class="text-center">Deleta</th>
			        </tr>
			    </thead>
			    <tbody>
			    @foreach($retiradas as $retirada)
			        <tr>
			            <td>
			            <a href="{{
			            	route('admin.financeiro.retiradaEdit', $retirada->id) }}" />{{$retirada->created_at->format('d/m/Y')}}
			            </a>
			            </td>
			            <td>{{$retirada->valor}}</td>
			            <td>{{$retirada->descricao}}</td>
			            <td>
			            	@if(!$retirada->usuario)
								Usuario excluído
							@else
			            		{{$retirada->usuario->name}}
			            	@endif
			            </td>
			            <td>@if($retirada->retirado_caixa == 1) Sim @else Não @endif</td>
			            <td>@if($retirada->funcionario_id != 0) {{$retirada->funcionario->nome}} @else -- @endif</td>
			            <td class="text-center"><a href="{{ route('admin.financeiro.deletaRetirada', $retirada->id)}}"<i class="fa fa-trash fa-2x"></i></a></td>
			        </tr>
			    @endforeach
			    </tbody>
			</table>
			
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


	@stop

@stop