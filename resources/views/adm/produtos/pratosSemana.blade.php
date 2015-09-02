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
  </div>

  <div class="panel panel-default">
  	<div class="panel-heading"><h5>Próximos pratos</h5></div>
  	<div class="panel-body">

  		<table class="table table-hover">
  			<thead>
  				<tr>
  					<td>Data programada</td>
            <td>Prato</td>
  					<td>Acompanhamentos</td>
  					<td>Edita</td>
  					<td>Exclui</td>
  				</tr>
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
    <div class="panel-heading"><h5>Pratos Mais Votados</h5></div>
    <div class="panel-body">

      <table class="table table-hover">
        <thead>
          <tr>
            <td>Prato</td>
            <td>%</td>
            <td>Data</td>
            <td>Adicionar</td>
          </tr>
        </thead>

@foreach($votos as $voto)
<form class="form-inline" method="POST">
<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
        <tr>
          <td>{{$voto->pratos['prato']}}</td>
          <td>{{calculaPorcentagem($totalVotos->total, $voto->qtdVoto)}}%</td>
          <td><input type="text" name="dataStr" class="form-control datepicker" placeholder="dd/mm/aaaa"></td>
          <td><button type="submit" onclick="this.form.action='/admin/produtos/addPratoSemana/{{$voto->pratos['id']}}'"><i class="fa fa-floppy-o"></i></button></td>
        </tr>
</form>
@endforeach

      </table>
    </div>
  </div>




@stop