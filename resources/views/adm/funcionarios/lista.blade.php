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
			<tr>
				<td colspan="7" class="text-center"><h4>Funcionários ativos</h4></td>
			</tr>
	        <tr class="text-center">
	            <th>Nome</th>
	            <th>Cargo</th>
	            <th>Horario</th>
	            <th>Telefone</th>
	            <th>Vr transporte por dia util</th>
	            <th>Ações</th>
	        </tr>
	    </thead>
	    <tbody>
		@foreach($funcionarios as $funcionario)
			
	    	@if($funcionario->is_ativo)
	        <tr>
	            <td>{{$funcionario->nome}}</td>
	            <td>{{$funcionario->cargo}}</td>
	            <td>{{$funcionario->horario_trabalho}}</td>
	            <td>{{$funcionario->telefone}}</td>
	            <td class="text-center" width="12%">{{$funcionario->vr_transporte}}</td>
	            <td class="text-center inline-block">
					<a class="btn btn-primary btn-xs" href="{{route('admin.funcionarios.detalhes', $funcionario->id)}}">Mostrar</a>
					<a class="btn btn-primary btn-xs" href="{{route('admin.funcionarios.edit', $funcionario->id)}}">Editar</a>
				</td>
	        @endif
	        </tr>
		@endforeach

			<tr>
				<td colspan="7" class="text-center"><h4>Funcionários inativos</h4></td>
			</tr>

			@foreach($funcionarios as $funcionario)
	    	@if(!$funcionario->is_ativo)
	        <tr>
	            <td>{{$funcionario->nome}}</td>
	            <td>{{$funcionario->cargo}}</td>
	            <td>{{$funcionario->horario_trabalho}}</td>
	            <td>{{$funcionario->telefone}}</td>
	            <td class="text-center" width="12%">{{$funcionario->vr_transporte}}</td>
				<td class="text-center inline-block">
					<a class="btn btn-primary btn-xs" href="{{route('admin.funcionarios.edit', $funcionario->id)}}">Editar</a>
					<a class="btn btn-danger btn-xs" href="{{route('admin.funcionarios.destroy', $funcionario->id)}}">Deletar</a>	
				</td>
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