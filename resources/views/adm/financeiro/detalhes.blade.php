@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Detalhes pagamento</h2><br>

	@if(Session::has('msg_retorno'))
	<div class="alert alert-{{Session::get('tipo_retorno')}}">
	     {{Session::get('msg_retorno')}}
	 </div>
	@endif

<div class="row">
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Detalhes pagamento</h4>
		</div>
		<div class="panel-body">
			
			<label>Data de vencimento</label>
			<p>{{$pagamento->vencimento}}</p>

			<label>Descrição</label>
			<p>{{$pagamento->descricao}}</p>

			<label>Valor</label>
			<p>{{$pagamento->valor}}</p>

			<label>Linha digitavel</label>
			<p>{{$pagamento->linha_digitavel}}</p>

			<label>Documento</label>
			<p><a href="{{ route('imageApagar', $pagamento->pagamento)}}"><img src="{{ route('imageApagar', $pagamento->pagamento)}}" width="300" /></a></p>

			<label>Nota Fiscal</label>
			<p><a href="{{ route('imageApagar', $pagamento->notaFiscal)}}"><img src="{{ route('imageApagar', $pagamento->notaFiscal)}}" width="300" /></a></p>
			
		</div>
	</div>

</div>


    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/financeiro.js') !!}"></script>

	        <script type="text/javascript">
 	
	        
	        </script>

	@stop

@stop