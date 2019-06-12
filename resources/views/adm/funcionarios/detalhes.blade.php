@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Detalhes funcionario</h2><br>

	@include('errors.messages')

	<div class="row">

		@yield('action')

		<div class="row">
			<div class="col-md-9">
				<div class="panel panel-default">
				<div class="panel-heading">Contato
				</div>
				<div class="panel-body">

					<div class="row">
						<div class="col-md-6">

							<div class="form-group">
								<label>Nome completo</label>
								<p>{{$funcionario->nome}}</p>
							</div>

							<div class="form-group">
								<label>Telefone</label>
								<p>{{$funcionario->telefone}}</p>
							</div>

							<div class="form-group">
								<label>Email</label>
								<p>{{$funcionario->email}}</p>
							</div>

							<div class="form-group">
								<label>Endereço</label>
								<p>{{$funcionario->endereco}}</p>
							</div>

							<div class="form-group">
								<label>Horario</label>
								<p>{{$funcionario->horario_trabalho}}</p>
							</div>
								

							<div class="form-group">
								<label>Cargo</label>
								<p>{{$funcionario->cargo}}</p>
							</div>


							<div class="form-group">
								<label>Observações</label>
								<p>{{$funcionario->observacoes}}</p>
							</div>

						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Transporte</label>
								<p>{{$funcionario->transporte}}</p>
							</div>

							<div class="form-group">
								<label>Valor Onibus</label>
								<p>{{$funcionario->vr_transporte}}</p>
							</div>

							<div class="form-group">
								<label>Identidade</label>
								<p>{{$funcionario->identidade}}</p>
							</div>

							<div class="form-group">
								<label>CPF</label>
								<p>{{$funcionario->cpf}}</p>
							</div>

							<div class="form-group">
								<label>Salario</label>
								<p>{{$funcionario->vr_salario}}</p>
							</div>

							<div class="form-group">
								<label>Data Inicio</label>
								<p>{{$funcionario->dt_inicio->format('d/m/Y')}}</p>
							</div>

							<div class="form-group">
								<label>Esta ativo?</label>
								<p>@if($funcionario->is_ativo) Sim @else Não @endif</p>
							</div>

						</div>

					</div>

				
				
				</div>

				</div>
			</div>

			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading">Açoes</div>
					<div class="panel-body">
						<a class="btn btn-default btn-block" href="{{route('admin.funcionarios.edit', $funcionario->id)}}">Editar</a>

					</div>

				</div>
			</div>
		</div>
			

			<div class="panel panel-default">
				<div class="panel-heading">Imprimir recibo</div>
				<div class="panel-body">

					<form action="{{route('admin.funcionarios.recibo', $funcionario->id)}}" method="POST">

					{!! csrf_field() !!}

					<button class="btn btn-primary" type="submit">Imprimir recibos selecionados</button>
					<br><br>

			    	
			    		<table class="table table-bordered table-hover table-striped">
			    		    <thead>
			    		        <tr>
			    		            <th>Selecionar</th>
			    		            <th>Data</th>
			    		            <th>Desconto?</th>
			    		            <th>Tipo</th>
			    		            <th>Observação</th>
			    		            <th>Valor</th>
			    		            <th>Quem fez?</th>
			    		            <th>Inicio</th>
			    		            <th>Término</th>
			    		            <th>Caixa?</th>
			    		            <th>Excluir?</th>
			    		        </tr>
			    		    </thead>
			    		    <tbody>
			    		    	@foreach($retiradas as $pagamento)
				    		        <tr>
				    		            <td class="text-center" width="3%">
				    		            	<label>
												<input type="checkbox" name="selected[]" value="{{$pagamento->id}}">
											</label>
										</td>
										<td>
											<a target="_blank" href="{{route('admin.financeiro.retiradaEdit', $pagamento->id) }}"/>{{$pagamento->created_at->format('d/m/Y')}}
											</a>
										</td>
										<td>{{$pagamento->is_debito ? 'Sim' : ''}}</td>
										<td>{{$pagamento->tipo}}</td>
										<td>{{substr($pagamento->descricao, 0, 10)}}</td>
										<td>R$ {{$pagamento->valor}}</td>

										@if(!$pagamento->usuario)
										<td>Usuário excluido</td>
										@else
										<td>{{$pagamento->usuario->name}}</td>
										@endif

										<td>{{$pagamento->init->format('d/m/Y')}}</td>
										<td>{{$pagamento->end->format('d/m/Y')}}</td>
										<td>{{$pagamento->retirado_caixa ? 'Sim' : ''}}</td>
										<td class="text-center">
											<a href="{{ route('admin.financeiro.deletaRetirada', $pagamento->id)}}"<i class="fa fa-trash "></i></a>
										</td>
				    		        </tr>
			    		        @endforeach
			    		    </tbody>
			    		</table>
				    	<div class="form-group">
							
				    	</div>							  
					
					

					<form>


				</div>

			</div>

			<div class="panel panel-default">
				<div class="panel-heading">Recibos gerados</div>
				<div class="panel-body">
					<table class="table table-bordered table-hover table-striped">
					    <thead>
					        <tr>
					            <td>Visualizar</td>
					            <td>Data</td>
					            <td>Total Debito</td>
					            <td>Total Credito</td>
					            <td>Excluir</td>
					        </tr>
					    </thead>
					    <tbody>
					    	@foreach($funcionario->recibos as $recibo)
					        <tr>
					        	<td>
									<a href="{{route('admin.funcionarios.reciboSalvo', $recibo->id) }}"/><i class="fa fa-search"></i>
									</a>
								</td>
					            <td>{{$recibo->created_at}}</td>
					            <td>R$ {{$recibo->total_debito}}</td>
					            <td>R$ {{$recibo->total_credito}}</td>
					            <td>
									<a href="{{route('admin.funcionarios.reciboSalvoDeleta', $recibo->id) }}" />
										<i class="fa fa-trash"></i>
									</td>
					            </td>
					        </tr>
					        @endforeach
					    </tbody>
					</table>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">Pagamentos</div>
				<div class="panel-body">

					<table class="table table-bordered table-hover table-striped">
					    <thead>
					        <tr>
					            <th>Data</th>
					            <th>Valor</th>
					            <th>Descrição</th>
					            <th>Responsável</th>
					        </tr>
					    </thead>
					    <tbody>
					    	@foreach($retiradas as $pagamento)
					        <tr>
								<td class="text-center" width="20%">{{$pagamento->created_at}}</td>
								<td class="text-center" width="15%">{{$pagamento->valor}}</td>
								<td width="35%">{{$pagamento->descricao}}</td>

								@if(!$pagamento->usuario)
									<td>Usuario excluido</td>
								@else
									<td>{{$pagamento->usuario->name}}</td>
								@endif
					        </tr>
					        @endforeach


					    </tbody>
					</table>


				</div>

			</div>


		</div>


    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/funcionarios.js') !!}"></script>

<script type="text/javascript">

</script>

	@stop

@stop