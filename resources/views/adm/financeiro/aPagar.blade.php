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
			            <th>Situação</th>
			            <th>Vencimento</th>
			            <th>Descrição</th>
			            <th>Valor</th>
			            <th>Responsável Cadastro</th>
			            <th>Arq pagamento</th>
			            <th>Arq nota</th>
			            <th>Excluir</th>
			        </tr>
			    </thead>
			    <tbody>
			    @foreach($pagamentos as $pag)
			        <tr>
			            <td class="text-center">
			            	<a href="{{route('admin.financeiro.detalhes', $pag->id)}}">
			            		@if($pag->is_liquidado == 0)
			            			<strong style="color:red">Pendente</strong> 
			            		@else Liquidado - ({{$pag->data_pgto}}) 
			            		@endif 
			            	</a>
			            </td>
			            <td class="text-center">{{$pag->vencimento}}</td>
			            <td><a href="{{route('admin.financeiro.detalhes', $pag->id)}}">{{$pag->descricao}}</a></td>
			            <td>R$ {{$pag->valor}}</td>
			            <td>{{$pag->usuarioCadastro->name}}</td>
			            <td class="text-center" width="10%">
			            @if($pag->pagamento != '')
			            	<a href="{!! $pag->arquivo_pagamento !!}" data-lightbox="property"><i class="fa fa-search" ></i>
			            @endif
			            	</a>
			            </td>
			            <td class="text-center" width="10%">
			            @if($pag->notaFiscal != '')
			            	<a href="{!! $pag->arquivo_nota !!}" data-lightbox="property"><i class="fa fa-search">
			            @endif 
			            </td>
			            <td class="text-center">
							<a href="{!! route('admin.financeiro.apagarPagamento', $pag->id) !!}" ><i class="fa fa-trash" ></i>
			            </td>
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