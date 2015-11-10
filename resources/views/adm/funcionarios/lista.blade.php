@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Lista funcionários</h2><br>

	@if(Session::has('msg_retorno'))
	<div class="alert alert-{{Session::get('tipo_retorno')}}">
	     {{Session::get('msg_retorno')}}
	 </div>
	@endif

<div class="row">

	<table class="table table-bordered table-hover table-striped">
	    <thead>
	        <tr class="text-center">
	            <th>Nome</th>
	            <th>Cargo</th>
	            <th>Horario</th>
	            <th>Telefone</th>
	            <th>Detalhes</th>
	        </tr>
	    </thead>
	    <tbody>
	    @foreach($funcionarios as $funcionario)
	        <tr>
	            <th>{{$funcionario->nome}}</th>
	            <th>{{$funcionario->cargo}}</th>
	            <th>{{$funcionario->horario_trabalho}}</th>
	            <th>{{$funcionario->telefone}}</th>
	            <th><a href="{{route('admin.funcionarios.detalhes', $funcionario->id)}}"><i class="fa fa-search"></i></a></th>
		@endforeach
	        </tr>
	    </tbody>
	</table>

</div>


</div>


    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/funcionarios.js') !!}"></script>

<script type="text/javascript">

</script>

	@stop

@stop