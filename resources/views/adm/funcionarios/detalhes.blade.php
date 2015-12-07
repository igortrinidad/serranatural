@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Detalhes funcionario</h2><br>

	@include('errors.messages')

	<div class="row">

		@yield('action')

			<div class="panel panel-default">
				<div class="panel-heading">Contato
					<div class="pull-right">
						<a href="{{route('admin.funcionarios.edit', $funcionario->id)}}"><i class="fa fa-pencil fa-2x"></i></a>
					</div>
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
								<p>{{$funcionario->dt_inicio}}</p>
							</div>

							<div class="form-group">
								<label>Foto</label>
								<p>{{$funcionario->foto}}</p>
							</div>

						</div>

					</div>

				
				
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
					    	@foreach($funcionario->retirada as $pagamento)
					        <tr>
								<th class="text-center" width="20%">{{$pagamento->created_at}}</th>
								<th class="text-center" width="15%">{{$pagamento->valor}}</th>
								<th width="35%">{{$pagamento->descricao}}</th>
								<th>{{$pagamento->usuario->name}}</th>
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