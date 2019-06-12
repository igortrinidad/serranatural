@extends('layout/admin')

@section('conteudo')

<h3 class="text-right">Venda de pratos</h3>
	@include('errors.messages')

<div class="panel panel-default">
	<div class="panel-heading"><h5>Relatórios de pratos vendidos.</h5></div>
	<div class="panel-body">

			<table class="table table-bordered table-striped">
			    <thead>
			        <tr>
			            <th>Data</th>
			            <th>Prato</th>
			            <th>Quantidade vendida</th>
			            <th>Informa quantidade</th>
			        </tr>
			    </thead>
			    <tbody>
			    @foreach($pratos as $prato)
			    	@if($prato->pratos)
			        <tr>
			            <td>{{ dataMysqlParaPtBr($prato->dataStamp) }}</td>
			            <td>{{ $prato->pratos->prato}}</td>
			            <td>{{ $prato->quantidade_venda}}</td>
			            <td class="text-center">
			            	<a 
			            	onclick="
			            		$('input[name=id]').val( {{$prato->id}} );
			            		$('#nome_prato').text( '{{$prato->pratos->prato}}');
			            		if( {{$prato->quantidade_venda}} >= 1 ){
			            			$('input[name=quantidade_venda]').val( {{$prato->quantidade_venda}} );
			            		}
			            	" 
			            	data-toggle="modal" 
			            	data-target="#modal-venda" 
			            	>
			            		<i class="fa fa-pencil"></i>
			            	</a>
			            </td>
			        </tr>
			        @endif
			    @endforeach
			    </tbody>
			</table>

	</div>
</div>

    <div class="modal  fade" id="modal-venda" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4>Informa a quantidade de venda</h4>

                </div>
                <div class="modal-body">   

                    @include('errors.messages')
                    
                    <div class="row">
                        <div class="col-md-12" style="padding: 30px">
                        
                            <form action="/admin/produtos/quantidadeVendaPratoPost" class="form-group" method="POST">
                                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                <input type="hidden" name="id" value="" />
                               
                                <div class="form-group">
                                	<label>Produto</label>
                                    <p id="nome_prato"><strong></strong></p>
                                </div>

                                <div class="form-group">
                                    <label class="label_form primeiro_label_form">Quantidade vendida</label>
                                    <input type="text" name="quantidade_venda"  class="form-control"/>
                                </div>


                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Salvar quantidade</button>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @section('scripts')
	    @parent

		@stop


@stop