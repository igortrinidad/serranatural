@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Detalhes</h2>

	@if(Session::has('msg_retorno'))
	<div class="alert alert-{{Session::get('tipo_retorno')}}">
	     {{Session::get('msg_retorno')}}
	 </div>
	@endif

<div class="row">
	<div class="col-md-6">

		<div class="panel panel-default">
			<div class="panel-heading"><h5>Dados</h5></div>
			<div class="panel-body">


			<div class="form-group">
				<label>Nome</label>
				<p>{{$cliente->nome}}</p>
			</div>
			<div class="form-group">
				<label>Telefone</label>
				<p>{{$cliente->telefone}}</p>
			</div>
					
				
			<div class="form-group">
				<label>E-mail</label>
				<p>{{$cliente->email}}</p>
			</div>

			<div class="form-group">
				<label>Newsletter</label>

				@if($cliente->opt_email == 1)
				<a href="/admin/clientes/sairEmail/{{$cliente->id}}"><i class="fa fa-check-square-o"></i></a>
				@else
				<a href="/admin/clientes/entrarEmail/{{$cliente->id}}"><i class="fa fa-square-o"></i></a>
				@endif
			</div>

			<a href="/admin/clientes/edita/{{$cliente->id}}" class="btn btn-primary">Editar<i class="fa fa-pencil"></i></a>

			</div>
		</div>
	</div>

	<div class="col-md-6">

		<div class="panel panel-default">
			<div class="panel-heading"><h5>Preferências</h5></div>
			<div class="panel-body">

				<p>
					<form action="/admin/clientes/addPreferencia" class="form-inline" method="POST">
				        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
				        <input type="hidden" name="clienteId" value="{{$cliente->id}}" />
						    <div class="form-group">
						      <label>Prato:</label>
									<select name="pratos_id" class="form-control">
										@foreach($pratos as $prato)
											<option value="{{$prato->id}}">{{$prato->prato}}</option>
										@endforeach
									</select>
						    </div>
						    <div class="form-group">
						    	<button type="submit" class="btn btn-default">Salvar preferência</button>
						  	</div>
						  </form>
				</p>

				<span class="divisor"></span>
				@foreach($preferencias as $preferencia)

					<div class="btn btn-default inline">{{$preferencia->prato}}<a href="/admin/clientes/retiraPreferencias/{{$cliente->id}}/{{$preferencia->preferencias}}"> <i class="fa fa-times"></i></a>
					</div>
				@endforeach

			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">

			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-6">
							<h4>Pontos coletados</h4> <br>Pontos totais: {{$pontosTotal}}
						</div>
						<div class="col-md-6">
							<div class="inline text-right">
								<ul class="pagination">
									<li>
										<a href="{!! $pontos->previousPageUrl() !!}" rel="prev">«</a>
									</li>
									<li>
										<a href="{!! $pontos->nextPageUrl() !!}" rel="prev">»</a>
									</li>
								</ul>	
							</div>
						</div>
					</div>
				</div>

				<div class="panel-body">

					<table class="table table-bordered text-center">
						<thead>
							<tr style="font-weight:700">
								<td>Codigo</td>
								<td>Produto</td>
								<td>Data coletado</td>
								<td>Vencimento</td>
							</tr>
						</thead>

					@foreach($pontos as $ponto)
						<tr>
							<td style="width:20%;">{{$ponto->id}}</td>
							<td style="width:30%;">{{$ponto->produto}}</td>
							<td style="width:30%;">{{$ponto->data_coleta}}</td>
							<td style="width:18%;">{{$ponto->vencimento}}</td>
						</tr>	
					@endforeach
					</table>

				</div>
			</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">

			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-6">
							<h4>Vouchers</h4>
						</div>
						<div class="col-md-6">
							<div class="inline text-right">
								<ul class="pagination">
									<li>
										<a href="{!! $vouchers->previousPageUrl() !!}" rel="prev">«</a>
									</li>
									<li>
										<a href="{!! $vouchers->nextPageUrl() !!}" rel="prev">»</a>
									</li>
								</ul>	
							</div>
						</div>
					</div>


				</div>
				<div class="panel-body">

					<table class="table table-bordered text-center">
						<thead>
							<tr style="font-weight:700">
								<td>Codigo</td>
								<td>Produto</td>
								<td>Vencimento</td>
								<td>Data utilização</td>
								<td>Valido</td>
								<td>Usar</td>
							</tr>
						</thead>

					@foreach($vouchers as $voucher)
						<tr>
							<td style="width:8%;">{{$voucher->id}}</td>
							<td style="width:20%;">{{$voucher->produto}}</td>
							<td style="width:13%;">{{$voucher->vencimento}}</td>
							<td style="width:13%;">{{$voucher->data_utilizado}}</td>
							<td style="width:10%;">@if($voucher->is_valido == 1)Sim @else Não @endif</td>
							<td style="width:10%;">@if($voucher->is_valido == 1)<button type="button" class="btn btn-default btn-xs btn_voucher" data-toggle="modal" data-target="#modalVoucher" onclick="idVoucher({{$voucher->id}}, '{{$voucher->produto}}')">Usar Voucher</button> @else -- @endif </td>
						</tr>	
					@endforeach
					</table>

				</div>
			</div>
	</div>
</div>


	<div class="panel panel-default">
		<div class="panel-heading"><h5>Summernote Teste</h5></div>
		<div class="panel-body">
				<form id="formAjax" action="/teste/summernote" method="POST" enctype="multipart/form-data" onsubmit="return postForm()">
			        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
			        <input type="hidden" name="cliente_id" value="{{$cliente->id}}" />
					    <div class="form-group">
					    	<input type="text" name="testeAjax" class="form-control" />
					    </div>

					    <div class="form-group">
	                    	<label class="label_form primeiro_label_form">Nome</label>
	                     	<input type="text" name="nome" value="{{ old('nome') }}" class="form-control"/>
                        </div>

                    	<input name="senha_resgate" value="{{ rand(1000, 9999)}}" />

                        <div class="form-group">
                            <label class="label_form">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label class="label_form">Telefone</label>
                            <input type="text" name="telefone" value="{{ old('telefone') }}"class="form-control phone_with_ddd"/>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="opt_email" value="1" class="checkbox" checked/>
                            <p class="texto_votacao">Aceito receber informações sobre promoções e novidades da Serra Natural.</p>
                        </div>
					    <div class="form-group">
					    	<button type="submit" class="btn btn-primary btn-block">Ir</button>
					  	</div>
				</form>
		</div>
	</div>


	                            <!-- Modal editar atividade -->              
                            <div class="modal inmodal fade" id="modalVoucher" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title">Vouchers</h4>
                                        </div>
                                        <div class="modal-body text-center">
										<div class="row">

											<div class="col-md-6">
		                                        <label>Código voucher</label>
		                                        <p id="voucher_codigo"></p>
                                        	</div>

											<div class="col-md-6">
		                                        <label>Produto</label>
		                                        <p id="voucher_produto"></p>
		                                    </div>
		                                    
                                        </div>
	

                                            <p>Insira a senha de resgate do cliente:</p>
                                           	
                                        </div>
                                        <div class="modal-footer inline">
                                        	<form id="formUsaVoucher" method="post" action="{{ route('admin.client.usesVoucher')}}"> 
                                        	<input type="hidden" name="cliente_id" value="{{$cliente->id}}" />
                                        	<input type="hidden" id="voucher_id" name="voucher_id" />
                                        	{!! csrf_field() !!}
											
											<div class="form-group">
                                        		<input type="password" id="senha" name="senha_resgate" class="form-control"/>
											</div>

	                                            <button type="button" class="btn btn-white btn-sm" data-dismiss="modal">Cancela</button>
	                                            
	                                            <button type="submit" class="btn btn-danger btn-sm" data-toggle="confirmation" >Confirma</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


     <div class="row">
     	<div class="col-md-8">
	<label>total</label>
	<input id="total" class="form-control" />
	<label>parcela</label>
	<input id="parcela" class="form-control" />

<table id="products-table" class="table table-bordered">
	<tbody>
		 <tr>
		   <th>Valor total</th>
		   <th>Parcela</th>
		   <th>Forma de pagamento</th>
		   <th>Preço</th>
		   <th>Ações</th>
		 </tr>
	</tbody>
<tfoot>
 <tr>
   <td colspan="5" style="text-align: left;">
     <button onclick="AddTableRow()" type="button">Calcular parcelas</button>
   </td>
 </tr>
</tfoot>
</table>

</div>
</div>





    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/clientes.js') !!}"></script>

<script type="text/javascript">
	function idVoucher (idDado, prod){
	    var id = idDado;
	    var produto = prod;
	    //adiciona o valor do id recebido como parametro na funcao
	    $('#voucher_id' ).val( id );
	    $('#voucher_codigo' ).text( id );
	    $('#voucher_produto' ).text( produto );
	}

	$( ".btn_voucher" ).click(function() {
	  setTimeout(function(){
	  	$( "#senha" ).focus();
	  	window.console.log('Foco on haha');
	  }, 500);
	});

AddTableRow = function() {

	var total = parseFloat($('#total').val());
	var parcelas = parseInt($('#parcela').val());
	var valorAtual = total / parcelas;

 

for (i=0 ; i < parcelas ; i++){

	var newRow = $("<tr>");
    var cols = "";

    cols += '<td  data-mask="#.##0,00" data-mask-reverse="true">R$ '+ valorAtual.toFixed(2) + '</td>';
    cols += '<td>&nbsp;</td>';
    cols += '<td>&nbsp;</td>';
    cols += '<td>&nbsp;</td>';
    cols += '<td>';
    cols += '<button onclick="RemoveTableRow(this)" type="button">Remover</button>';
    cols += '</td>';
    cols += '</tr>';

    newRow.append(cols);
    $("#products-table").append(newRow);
}
    return false;
  };

  RemoveTableRow = function(handler) {
    var tr = $(handler).closest('tr');

    tr.fadeOut(400, function(){ 
      tr.remove(); 
    }); 

    return false;
  };


	$('#formUsaVoucher button[type=submit]').click(function(e){
		    e.preventDefault();

		var form = jQuery(this).parents("form:first");
		var dataString = form.serialize();

		var formAction = form.attr('action');

		$.ajax({
		    type: "POST",
		    url : formAction,
		    data : dataString,
		    success : function(data){

		    	var msg = data['msg_retorno'];
		    	var tipo = data['tipo_retorno'];

		        $.notify(msg, tipo);
		        $('#formUsaVoucher')[0].reset();
		        $('#modalVoucher').modal('hide');

		    if(tipo == 'success')
		    {

			    setTimeout(function()
			    {
			    	location.reload();
			    }, 1500);
			}

		    }
		    },"json");

	});

</script>

	    @stop

@stop