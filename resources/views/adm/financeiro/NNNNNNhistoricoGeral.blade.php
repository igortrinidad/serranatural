@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Boletos a pagar</h2><br>

	@if(Session::has('msg_retorno'))
	<div class="alert alert-{{Session::get('tipo_retorno')}}">
	     {{Session::get('msg_retorno')}}
	 </div>
	@endif

<div class="row">

	<form action="" method="post">
		
		{!! csrf_field() !!}
		<div class="form-group">
			<label>Selecione a data</label>
			<input type="text" name="dateRange" value="" class="form-control"/>
		</div>

		<input type="hidden" name="dataInicio" value="" class="form-control"/>
		<input type="hidden" name="dataFim" value="" class="form-control"/>

		<button type="submit" class="btn btn-block btn-primary">Pesquisar</button>

	</form>


</div>


    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/financeiro.js') !!}"></script>


			<script type="text/javascript">

			console.log(moment().startOf('month').format('DD/MM/YYYY'));
			console.log(moment().endOf('month').format('DD/MM/YYYY'));



				$('input[name="dateRange"]').daterangepicker({

					    locale: {
					      format: 'DD/MM/YYYY'
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

				var dataInicio = start.format('DD/MM/YYYY');
				var dataFim = end.format('DD/MM/YYYY');

				console.log(dataInicio + ' - ' + dataFim);

				});

			</script>

	@stop

@stop