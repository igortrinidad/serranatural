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
	<div class="col-md-6">

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

					<table class="table table-bordered">
						<thead>
							<tr>
								<td>Codigo</td>
								<td>Produto</td>
								<td>Vencimento</td>
							</tr>
						</thead>

					@foreach($pontos as $ponto)
						<tr>
							<td style="width:20%;">{{$ponto->id}}</td>
							<td style="width:30%;">{{$ponto->produto}}</td>
							<td style="width:18%;">{{$ponto->vencimento}}</td>
						</tr>	
					@endforeach
					</table>

				</div>
			</div>
	</div>

	<div class="col-md-6">

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

					<table class="table table-bordered">
						<thead>
							<tr>
								<td>Codigo</td>
								<td>Produto</td>
								<td>Vencimento</td>
								<td>Usar</td>
							</tr>
						</thead>

					@foreach($vouchers as $voucher)
						<tr>
							<td style="width:20%;">{{$voucher->id}}</td>
							<td style="width:30%;">{{$voucher->produto}}</td>
							<td style="width:18%;">{{$voucher->vencimento}}</td>
							<td style="width:15%;"><button type="button" class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#modalVoucher" onclick="idVoucher({{$voucher->id}}, '{{$voucher->produto}}')">Usar Voucher</button></td>
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

			<p>
				<form id="postForm" action="/teste/summernote" method="POST" enctype="multipart/form-data" onsubmit="return postForm()">
			        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
			        <input type="hidden" name="clienteId" value="{{$cliente->id}}" />
					    <div class="form-group">
					    	<textarea class="input-block-level" id="summernote" name="content" rows="12">
							</textarea>
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
                                        	<form method="post" action="{{ route('admin.client.usesVoucher')}}"> 
                                        	<input type="hidden" name="cliente_id" value="{{$cliente->id}}" />
                                        	<input type="hidden" id="voucher_id" name="voucher_id" />
                                        	{!! csrf_field() !!}
											
											<div class="form-group">
                                        		<input type="password" name="senha_resgate" class="form-control"/>
											</div>

	                                            <button type="button" class="btn btn-white btn-sm" data-dismiss="modal">Cancela</button>
	                                            
	                                            <button type="submit" class="btn btn-danger btn-sm" data-toggle="confirmation" >Confirma</button>
                                            </form>
                                        </div>
                                    </div>
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

</script>

	    @stop

@stop