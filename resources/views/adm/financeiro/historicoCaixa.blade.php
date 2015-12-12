@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Histórico de caixa</h2>

	@include('errors.messages')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-6">
						<h4>Histórico</h4>
					</div>
					<div class="col-md-6">
						<div class="inline text-right">
							<ul class="pagination">
								<li>
									<a href="{!! $caixas->previousPageUrl() !!}" rel="prev">«</a>
								</li>
								<li>
									<a href="{{ route('admin.financeiro.historico').'/?page=1' }}">1</a>
								</li>
								<li class="active">
									<a href="#">{!! $caixas->currentPage() !!}</a>
								</li>
								<li>
									<a href="{{ route('admin.financeiro.historico').'/?page='.$caixas->lastPage() }}" rel="prev">{!! $caixas->lastPage() !!}</a>
								</li>
								<li>
									<a href="{!! $caixas->nextPageUrl() !!}" rel="prev">»</a>
								</li>
							</ul>	
						</div>

					</div>
				</div>
			</div>
			<div class="panel-body">

				<table class="table table-bordered table-hover table-striped">
				    <thead>
				        <tr>
				            <th width="15%">Data abertura</th>
				            <th width="15%">Data fechamento</th>
				            <th width="13%">Usuario abertura</th>
				            <th width="13%">Usuario fechamento</th>
				            <th width="10%">Vr Abertura</th>
				            <th width="10%">Fundo de caixa</th>
				            <th width="10%">Diferença final</th>
				            <th width="10%">Detalhes</th>
				        </tr>
				    </thead>
				    <tbody>
				    @foreach($caixas as $c)
				        
					        <tr>
					            <th>{{$c->dt_abertura->format('d/m/Y H:i:s')}}</th>
					            <th>{{ $c->dt_fechamento->format('d/m/Y H:i:s') }}</th>
					            <th>{{$c->usuarioAbertura->name}}</th>
					            <th>@if($c->is_aberto == 1) -- @else{{$c->usuarioFechamento->name}}@endif</th>
					            <th>R$ {{ number_format($c->vr_abertura, 2, ',', '.') }}</th>
					            <th>{{$c->vr_emCaixa}}</th>
					            <th>{{$c->diferenca_final}}</th>
					            <th><button type="button" class="btn btn-default btn-xs btn_caixa_detalhes" data-toggle="modal" data-target="#modalCaixa" onclick="idCaixa({{$c->id}})">Detalhes</button></th>
					        </tr>
				        
				      @endforeach
				    </tbody>
				</table>
			</div>

		</div>
	</div>
</div>



<!-- INICIO MODAL PRATO -->

    <div class="modal inmodal fade" id="modalCaixa" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="tituloModal">Caixa: <span id="id_caixa_titulo"></span></h4>
                </div>
                <div class="modal-body text-center">
                  
                  <div id="loader">
                    <img src="/assets/loading-ring.gif" width="80px">
                    <div style="background:url(/assets/loading-ring.gif) no-repeat center center;width:25px;height:25px;"></div>
                  </div>

                  <div id="div_caixa">

                    <table class="table table-hover">
                        
                        <tbody>
                        	<tr>
                            	<td width="50%">Abertura</td>
                                <td width="50%" id="dt_abertura"></td>
                            </tr>
                            <tr>
                            	<td width="50%">Fechamento</td>
                                <td width="50%" id="dt_fechamento"></td>
                            </tr>
                            <tr>
                            	<td width="50%">Total de vendas</td>
                                <td width="50%" id="total_vendas"></td>
                            </tr>
                            <tr>
                            	<td>Resp. Abertura</td>
                                <td id="user_abertura"></td>
                            </tr>
                            <tr>
                            	<td>Resp. fechamento</td>
                                <td id="user_fechamento"></td>
                            </tr>
                            <tr>
                            	<td>Valor abertura</td>
                                <td id="vr_abertura"></td>
                            </tr>
                            <tr>
                            	<td>Vendas dinheiro (sist)</td>
                                <td id="vendas_cash"></td>
                            </tr>
                            <tr>
                            	<td>Vendas cartão (sist)</td>
                                <td id="vendas_card"></td>
                            </tr>
                            <tr>
                            	<td>Vendas REDE</td>
                                <td id="vendas_rede"></td>
                            </tr>
                            <tr>
                            	<td>Vendas Cielo</td>
                                <td id="vendas_cielo"></td>
                            </tr>
                            <tr>
                            	<td>Total retirada</td>
                                <td id="total_retirada"></td>
							</tr>
							<tr>
                                <td>Fundo caixa</td>
                                <td id="vr_emCaixa"></td>
                            </tr>
                            <tr>
                            	<td>Diferença final</td>
                                <td id="diferenca_final"></td>
                            </tr>
                        </tbody>
                    </table>

<h5>Retiradas</h5>

                    <table class="table table-bordered table-hover table-striped" id="retiradas-table">
                        <thead>
                            <tr>
                                <th>Descrição</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    <div class="row">
                      <div class="col-md-6">
                        <a id="btnEditar" href="" class="btn btn-default btn-block">
                        Editar</a>
                      </div>

                      <form action="/admin/produtos/salvaPratoSemana" class="form-inline" method="POST">
                        <div class="col-md-6">
                          <input type="hidden" name="pratos_id" />
                          <input type="hidden" name="dataStr"/> 
                          <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                          <button type="submit" class="btn btn-default btn-block">Confirma</button>
                        </div>
                      </form>


                    </div>


                  </div>

                    
                </div>
            </div>
        </div>
    </div>

<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/financeiro.js') !!}"></script>

<script type="text/javascript">

$('#div_caixa').hide();

function idCaixa( idDado )
{
	var id = idDado;
	$('#loader').show();
	consultaCaixa( id );
}

function consultaCaixa(id_parametro)
{
  formData = {
    '_token' : $("#token").val(),
    'id' : id_parametro,
  };

  var url = "/admin/financeiro/consultaCaixaAjax";

  $.ajax(
  {
      type: "POST",
      url : url,
      data : formData,
      success : function(data)
      {

        $('#loader').hide();
        $('#div_caixa').fadeIn();

        $('#dt_abertura').text(data['dt_abertura']);
        $('#dt_fechamento').text(data['dt_fechamento']);
        $('#total_vendas').text(data['total_vendas']);
        $('#user_abertura').text(data['user_abertura']);
        $('#user_fechamento').text(data['user_fechamento']);
        $('#vr_abertura').text(data['vr_abertura']);
        $('#vendas_cash').text(data['vendas_cash']);
        $('#vendas_card').text(data['vendas_card']);
        $('#vendas_rede').text(data['vendas_rede']);
        $('#vendas_cielo').text(data['vendas_cielo']);
        $('#total_retirada').text(data['total_retirada']);
        $('#vr_emCaixa').text(data['vr_emCaixa']);
        $('#diferenca_final').text(data['diferenca_final']);
        $('#id_caixa_titulo').text(data['id']);

        var retiradas = data['retiradas'];

        $.each(retiradas, function(index, value) {

		    var newRow = $("<tr>");
		    var cols = "";
		    cols += '<td>' + index + '</td>';
		    cols += '<td>' + value + '</td>';
		    cols += '</tr>';

		    newRow.append(cols);
		    $("#retiradas-table").append(newRow);

		}); 


      }
  },"json");

};

$('#modalCaixa').on('hidden.bs.modal', function () {
	$('#loader').show();
	$('#div_caixa').fadeOut();
	$('#retiradas-table tr').remove();
})

</script>

	    @stop

@stop