@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Modelos de email</h2>
{!! csrf_field() !!}
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"><h5>Modelos</h5></div>
			<div class="panel-body">
				
				<table class="table table-bordered table-hover table-striped">
				    <thead>
				        <tr>
				            <th width="30%">Nome modelo</th>
				            <th width="50%">Assunto</th>
				            <th center width="10%">Editar</th>
				        </tr>
				    </thead>
				    <tbody>
				    	@foreach($modelos as $modelo)
				        <tr>
				            <td>{{$modelo->nome}}</td>
				            <td>{{$modelo->assunto}}</td>
				            <td class="text-center"><a href="{{ route('admin.marketing.editaModelo', $modelo->id) }}"><i class="fa fa-pencil"></i></a></td>
				        </tr>
				        @endforeach
				    </tbody>
				</table>

			</div>
		</div>
	</div>


</div>

<!-- Modal editar atividade -->              
    <div class="modal inmodal fade" id="modalEnvia" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="tituloModal">Confirma</h4>
                </div>
                <div class="modal-body text-center">

					<textarea id="preview"></textarea>

                </div>
                <div class="modal-footer inline">
					
					<input type="hidden" id="ids" value="">
					
					<form id="formAbreCaixa" method="POST">

						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						
					
					<div class="form-group">
						<label>Insira sua senha</label>
                		<input type="password" id="inputSenha" name="senha" class="form-control" value="" />
					</div>

                        <button type="button" class="btn btn-white btn-sm" data-dismiss="modal">Cancela</button>
                        
                        <button id="btnEnvia" class="btn btn-danger btn-sm">Confirma envio</button>

                    </form>
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