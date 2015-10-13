@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Pratos da semana</h1>

@if(Session::has('msg_retorno'))
<div class="alert alert-{{Session::get('tipo_retorno')}}">
     {{Session::get('msg_retorno')}}
 </div>
@endif

<div class="panel panel-default">
	<div class="panel-heading"><h5>Agendar Pratos</h5></div>
		<div class="panel-body">
      <div class="row">
        <div class="col-md-8">
    		  <form action="/admin/produtos/salvaPratoSemana" class="form-inline" method="POST">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
    		    <div class="form-group">
    		      <label>Prato:</label>
    					<select name="pratos_id" class="form-control">
    						@foreach($pratos as $prato)
    							<option value="{{$prato->id}}">{{$prato->prato}}</option>
    						@endforeach
    					</select>
    		    </div>
    		    <div class="form-group">
    		      <label>Data:</label>
    		      <input type="text" name="dataStr" class="form-control datepicker" placeholder="dd/mm/aaaa">
    		    </div>
    		    <button type="submit" class="btn btn-default">Agendar Prato</button>
    		  </form>
        </div>
        <div class="col-md-4">

          <a class="btn btn-default pull-right" href="/admin/produtos/enviaPratoDoDia">Enviar prato do dia</a>
        </div>
      </div>
	  </div>
  </div>

  <div class="panel panel-default">
  	<div class="panel-heading"><h5>Próximos pratos</h5></div>
  	<div class="panel-body">

  		<table class="table table-hover">
  			<thead>
  				<tr><strong>
  					<td>Data programada</td>
            <td>Prato</td>
  					<td>Acompanhamentos</td>
  					<td>Exclui</td>
  				</tr></strong>
  			</thead>

@foreach($agenda as $a)
  			<tr>
  				<td>{{ dataMysqlParaDateTime($a->dataStamp) }}, {{ dataMysqlParaPtBr($a->dataStamp) }}</td>
          <td>{{ $a->pratos['prato'] }}</td>
  				<td>{{ $a->pratos['acompanhamentos'] }}</td>
  				<td><a href="/admin/produtos/excluiPratoSemana/{{$a->id}}"><i class="fa fa-trash"></i></a></td>
  			</tr>
@endforeach

  		</table>
    </div>
  </div>


  <div class="panel panel-default">
    <div class="panel-heading"><h5>Pratos Mais Votados da Semana</h5></div>
    <div class="panel-body">

      <table class="table table-hover">
        <thead>
          <tr class="text-center">
            <td class="col-md-3">Prato</td>
            <td class="col-md-4">%</td>
            <td class="col-md-3">Data</td>
            <td class="col-md-2 text-center">Adicionar</td>
          </tr>
        </thead>

@foreach($votos as $voto)
<form class="form-inline" method="POST">
<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
        <tr>
          <td>{{$voto->pratos['prato']}}</td>
          <td><div class="progress">
                              <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:{{calculaPorcentagem($totalVotos->total, $voto->qtdVoto)}}%;color:black;"><strong>{{calculaPorcentagem($totalVotos->total, $voto->qtdVoto)}}%</strong>
                                </div>
                            </div></td>
          <td>
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-calendar fa-1x"></i></span>
              <input type="text" name="dataStr" class="form-control datepicker" placeholder="dd/mm/aaaa">
            </div>
          </td>
          <td class="col-md-2 text-center"><button type="submit" onclick="this.form.action='/admin/produtos/addPratoSemana/{{$voto->pratos['id']}}'"><i class="fa fa-floppy-o"></i></button></td>
        </tr>
</form>
@endforeach

      </table>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading"><h5>Pratos Mais Votados</h5></div>
    <div class="panel-body">

      <table class="table table-hover">
        <thead>
          <tr class="text-center">
            <td class="col-md-3">Prato</td>
            <td class="col-md-4">%</td>
            <td class="col-md-3">Data</td>
            <td class="col-md-2 text-center">Adicionar</td>
          </tr>
        </thead>

@foreach($votosGeral as $voto)
<form class="form-inline" method="POST">
<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
        <tr>
          <td>{{$voto->pratos['prato']}}</td>
          <td><div class="progress">
                              <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:{{calculaPorcentagem($totalVotos->total, $voto->qtdVoto)}}%;color:black;"><strong>{{calculaPorcentagem($totalVotosGeral->total, $voto->qtdVoto)}}%</strong>
                                </div>
                            </div></td>
          <td>
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-calendar fa-1x"></i></span>
              <input type="text" name="dataStr" class="form-control datepicker" placeholder="dd/mm/aaaa">
            </div>
          </td>
          <td class="col-md-2 text-center"><button type="submit" onclick="this.form.action='/admin/produtos/addPratoSemana/{{$voto->pratos['id']}}'"><i class="fa fa-floppy-o"></i></button></td>
        </tr>
</form>
@endforeach

      </table>
    </div>
  </div>




@stop