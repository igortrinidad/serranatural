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
	            <th>Vr transporte</th>
	            <th>Mostrar</th>
	            <th>Edita</th>
	        </tr>
	    </thead>
	    <tbody>
	    @foreach($funcionarios as $funcionario)
	    	@if($funcionario->is_ativo)
	        <tr>
	            <th>{{$funcionario->nome}}</th>
	            <th>{{$funcionario->cargo}}</th>
	            <th>{{$funcionario->horario_trabalho}}</th>
	            <th>{{$funcionario->telefone}}</th>
	            <th class="text-center" width="12%">{{$funcionario->vr_transporte}}</th>
	            <th class="text-center" width="8%"><a href="{{route('admin.funcionarios.detalhes', $funcionario->id)}}"><i class="fa fa-search"></i></a></th>
	            <th class="text-center" width="8%"><a href="{{route('admin.funcionarios.edit', $funcionario->id)}}"><i class="fa fa-pencil"></i></a></th>
	        @endif
	        </tr>
		@endforeach

			<tr><td colspan="7">Usuários inativos</td></tr>

			@foreach($funcionarios as $funcionario)
	    	@if(!$funcionario->is_ativo)
	        <tr>
	            <th>{{$funcionario->nome}}</th>
	            <th>{{$funcionario->cargo}}</th>
	            <th>{{$funcionario->horario_trabalho}}</th>
	            <th>{{$funcionario->telefone}}</th>
	            <th class="text-center" width="12%">{{$funcionario->vr_transporte}}</th>
	            <th class="text-center" width="8%"><a href="{{route('admin.funcionarios.detalhes', $funcionario->id)}}"><i class="fa fa-search"></i></a></th>
	            <th class="text-center" width="8%"><a href="{{route('admin.funcionarios.edit', $funcionario->id)}}"><i class="fa fa-pencil"></i></a></th>
	        @endif
	        </tr>
		@endforeach
	        
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