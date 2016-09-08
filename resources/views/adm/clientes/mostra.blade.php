@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Detalhes</h2>

	@if(Session::has('msg_retorno'))
	<div class="alert alert-{{Session::get('tipo_retorno')}}">
	     {{Session::get('msg_retorno')}}
	 </div>
	@endif

<div class="row">
	<div class="col-md-9">
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



			</div>
		</div>
	</div>

	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><h5>Ações</h5></div>
			<div class="panel-body">
				<div class="form-group">
					<label>Newsletter </label>
					@if($cliente->opt_email == 1)
					<a href="/admin/clientes/sairEmail/{{$cliente->id}}"><i class="fa fa-check-square-o"></i></a>
					@else
					<a href="/admin/clientes/entrarEmail/{{$cliente->id}}"><i class="fa fa-square-o"></i></a>
					@endif
				</div>

				<a href="/admin/clientes/edita/{{$cliente->id}}" class="btn btn-primary btn-block">Editar <i class="fa fa-pencil"></i></a>

				<a href="/admin/clientes/reenviaSenha/{{$cliente->id}}" class="btn btn-primary btn-block">Reenviar Senha <i class="fa fa-share"></i></a>

			</div>
		</div>
	</div>

</div>


<div class="row">
	<div class="col-md-12">

			<div class="panel panel-default">
				<div class="panel-heading">
					<h5>Vouchers</h5>
				</div>
				<div class="panel-body">

					
					<label>Adicionar voucher cortesia</label>


					<table class="table table-bordered text-center">
						<thead>
							<tr style="font-weight:700">
								<td>Codigo</td>
								<td>Produto</td>
								<td>Vencimento</td>
								<td>Data utilização</td>
								<td>Valido</td>
								<td>Uso autorizado por:</td>
								<td>Valor autorizado</td>
								<td>Usar</td>
							</tr>
						</thead>

					@foreach($vouchers as $voucher)
						<tr>
							<td style="width:8%;">{{$voucher->id}}</td>
							<td style="width:20%;">{{$voucher->produto}}</td>
							<td style="width:13%;">{{$voucher->vencimento}}</td>
							<td style="width:13%;">{{$voucher->data_utilizado}}</td>
							<td style="width:10%;">@if($voucher->is_valido)Sim @else Não @endif</td>
							<td style="width:10%;">@if(!$voucher->user_id) -- @else {{$voucher->usuario->name}} @endif</td>
							<td style="width:10%;">{{$voucher->valor}}</td>
							<td style="width:10%;">@if($voucher->is_valido)<button type="button" class="btn btn-default btn-xs btn_voucher" data-toggle="modal" data-target="#modalVoucher" onclick="idVoucher({{$voucher->id}}, '{{$voucher->produto}}')">Usar Voucher</button> @else -- @endif </td>
						</tr>	
					@endforeach
					</table>

					{!! $vouchers->render() !!}

					<hr size="3px" />
					<div class="row">
						<form method="post" action="{{route('admin.client.addVoucherCortesia', $cliente->id)}}">

						{!! csrf_field() !!}
						<div class="col-md-5">
							<div class="form-group">
								<select name="produto" class="form-control">
									<option value="Açaí">Açaí</option>
									<option value="Almoço">Almoço</option>
									<option value="Sandwich">Sandwich</option>
									<option value="Sandwich + Suco">Sandwich + Suco</option>
									<option value="Salada">Salada</option>
									<option value="Drink">Drink</option>
									<option value="Salada de Frutas">Salada de Frutas</option>
									<option value="Menu Degustação">Menu degustação</option>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<input type="password" name="senha" placeholder="Senha de administrador" class="form-control">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<button type="submit" class="btn btn-default btn-block">Adicionar</button>
							</div>
						</div>

						</form>

					</div>

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



	                            <!-- Modal editar atividade -->              
                            <div class="modal inmodal fade" id="modalVoucher" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-sm">
                                <form id="formUsaVoucher" method="post" action="{{ route('admin.client.usesVoucher')}}"> 

                                	<input type="hidden" name="cliente_id" value="{{$cliente->id}}" />
                                	<input type="hidden" id="voucher_id" name="voucher_id" />
                                	{!! csrf_field() !!}

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
                                        	<br>
	                                        <div class="row">
	                                        	<div class="col-md-12">
													<div class="form-group">
														<label>Valor do voucher</label>
		                                        		<input type="text" id="valor" name="valor" class="form-control"/>
													</div>
	                                        	</div>
	                                        	<div class="col-md-12">
	                                        	    <div class="form-group">
		                                        	    <label>Senha de resgate</label>
		                                        		<input type="password" id="senha" name="senha_resgate" class="form-control"/>
													</div>                                 		
	                                        	</div>                                       	
	                                        </div>
                                           	
                                        </div>
                                        <div class="modal-footer inline">
                                            <button type="button" class="btn btn-white btn-sm" data-dismiss="modal">Cancela</button>
                                            
                                            <button id="confirmVoucher" class="btn btn-danger btn-sm" data-toggle="confirmation" >Confirma</button>
                                        </div>
                                    </div>
                                </form>
                                </div>

                                
                            </div>


    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/clientes.js') !!}"></script>

			<script type="text/javascript">

				$('#valor').mask('00.00', {reverse: true});

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

				$('#confirmVoucher').click(function(e){
					    e.preventDefault();

					var form = $('#formUsaVoucher');
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