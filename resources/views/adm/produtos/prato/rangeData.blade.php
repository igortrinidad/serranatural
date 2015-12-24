@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Calcular estoque necessário</h2><br>

	@include('errors.messages')

<div class="row">

	<div class="panel panel-default">

		<div class="panel-body">
			<form action="/admin/produtos/calcular/dateRange" method="post" class="form-inline" role="form">
				
				{!! csrf_field() !!}
				<input type="hidden" name="dataInicio" value="" class="form-control"/>
				<input type="hidden" name="dataFim" value="" class="form-control"/>

				
				<div class="form-group col-md-6">
					<input type="text" name="dateRange" value="" class="form-control" placeholder="Selecione o periodo da pesquisa" style="width: 100%;"/>
				</div>

				<div class="form-group col-md-3">
					<input type="text" name="quantidade" value="" class="form-control"/>
				</div>
				
				
				<div class="form-group col-md-3">
					<button type="submit" class="btn btn-primary btn-block">Pesquisar</button>
				</div>
				

			</form>
		</div>
	</div>
	


  <div class="panel panel-default">
  	<div class="panel-heading"><h5>Pratos agendados</h5></div>
  	<div class="panel-body">

  		<table class="table table-hover">
  			<thead>
  				<tr>
          <strong>
  					<td>Data programada</td>
            <td>Prato</td>
            <td>Acompanhamentos</td>
            <td>Pequeno</td>
            <td>Grande</td>
  					<td>Edita</td>
            <td>Exclui</td>
  					<td>Foto</td>
          </strong>
  				</tr>
  			</thead>

        <tbody>

        @foreach($agenda as $a)
  			<tr>
  				<td><b>{{ dataMysqlParaDateTime($a->dataStamp) }}</b>, {{ dataMysqlParaPtBr($a->dataStamp) }}</td>
          <td>{{ $a->pratos['prato'] }}</td>
          <td>{{ $a->pratos['acompanhamentos'] }}</td>
          <td>{{ $a->pratos['valor_pequeno'] }}</td>
  				<td>{{ $a->pratos['valor_grande'] }}</td>
          <td><a href="/admin/produtos/pratos/edita/{{$a->pratos->id}}"><i class="fa fa-pencil"></i>
              </a>
          </td>
          <td><a href="/admin/produtos/excluiPratoSemana/{{$a->id}}">
                <i class="fa fa-trash"></i>
              </a>
          </td>
          <td>
            <a href="/admin/produtos/pratos/mostra/{{$a->pratos->id}}"><img src="/arquivos/produtos/{{$a->pratos['foto']}}" width="80px" /></a>
          </td>
  			</tr>
        @endforeach

        </tbody>

  		</table>
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
				        "Próximos 7 dias": [
				            moment(),
				            moment().add(7, 'days')
				        ],
				        "Próximos 15 dias": [
				            moment(),
				            moment().add(15, 'days')
				        ],
				        "Próximos 30 dias": [
				            moment(),
				            moment().add(30, 'days')
				        ],
				       	"Próximos 60 dias": [
				            moment(),
				            moment().add(60, 'days')
				        ],
				        "Este mês": [
				            moment(),
				            moment().endOf('month').format('DD/MM/YYYY')
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