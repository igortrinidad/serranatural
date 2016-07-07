@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Ultimos emails enviados</h2>
{!! csrf_field() !!}
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"><h5>Logs</h5></div>
			<div class="panel-body">
				
				<table class="table table-bordered table-hover table-striped">
				    <thead>
				        <tr>
				            <th width="30%">Assunto</th>
				            <th width="50%">Email</th>
				            <th center width="20%">Contador</th>
				        </tr>
				    </thead>
				    <tbody>
				    	@foreach($logs as $log)
				        <tr>
				            <td>{{$log->assunto}}</td>
				            <td>{{$log->email}}</td>
				            <td> {{$log->contador}} </td>
				        </tr>
				        @endforeach
				    </tbody>
				</table>

			</div>
		</div>
	</div>


</div>



    @section('scripts')
	    @parent

			<script type="text/javascript">

			</script>

	    @stop

@stop