@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Boletos a pagar</h2><br>

	@if(Session::has('msg_retorno'))
	<div class="alert alert-{{Session::get('tipo_retorno')}}">
	     {{Session::get('msg_retorno')}}
	 </div>
	@endif

<div class="row">
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Boletos a pagar</h4>
		</div>
		<div class="panel-body">
			
			<table class="table table-bordered table-hover table-striped">
			    <thead>

			        <tr>
			            <th>Vencimento</th>
			            <th>Descrição</th>
			            <th>Valor</th>
			            <th>Responsável Cadastro</th>
			            <th>Arq pagamento</th>
			            <th>Arq nota</th>
			        </tr>
			    </thead>
			    <tbody>
			    @foreach($pagamentos as $pag)
			        <tr>
			            <th>{{$pag->vencimento}}</th>
			            <th>{{$pag->descricao}}</th>
			            <th>{{$pag->linha_digitavel}}</th>
			            <th>{{$pag->user_id_cadastro}}</th>
			            <th><img src="{{route('admin.financeiro.arquivos', $pag->pagamento)}}" width="100" />
			            </th>
			            <th><a href="{{route('admin.financeiro.arquivos', $pag->notaFiscal)}}"><img src="{{route('admin.financeiro.arquivos', $pag->notaFiscal)}}" width="100" /></a></th>
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


	@stop

@stop