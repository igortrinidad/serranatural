@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Detalhes funcionario</h2><br>

	@if(Session::has('msg_retorno'))
	<div class="alert alert-{{Session::get('tipo_retorno')}}">
	     {{Session::get('msg_retorno')}}
	 </div>
	@endif

	<div class="row">

		@yield('action')

			<div class="panel panel-default">
				<div class="panel-heading">Contato</div>
				<div class="panel-body">

					<div class="row">
						<div class="col-md-6">

							<div class="form-group">
								<label>Nome completo</label>
								<label>{{$funcionario->nome}}
							</div>

							<div class="form-group">
								<label>Telefone</label>
								<label>{{$funcionario->telefone}}</label>
							</div>

							<div class="form-group">
								<label>Email</label>
								<label>{{$funcionario->email}}</label>
							</div>

							<div class="form-group">
								<label>Endereço</label>
								<label>{{$funcionario->endereco}}</label>
							</div>

							<div class="form-group">
								<label>Horario</label>
								<input type="text" name="horario_trabalho" class="form-control" />
							</div>

							<div class="form-group">
								<label>Cargo</label>
								<input type="text" name="cargo" class="form-control" />
							</div>

							<div class="form-group">
								<label>Observações</label>
								<textarea name="observacoes" type="textarea" class="form-control"></textarea>
							</div>

						</div>
						<div class="col-md-6">


							<div class="form-group">
								<label>Transporte</label>
								<input type="text" name="transporte" class="form-control" />
							</div>

							<div class="form-group">
								<label>Valor Onibus</label>
								<input type="text" name="vr_transporte" class="form-control" />
							</div>

							<div class="form-group">
								<label>Identidade</label>
								<input type="text" name="identidade" class="form-control" />
							</div>

							<div class="form-group">
								<label>CPF</label>
								<input type="text" name="cpf" class="form-control" />
							</div>

							<div class="form-group">
								<label>Salario</label>
								<input type="text" name="vr_salario" class="form-control" />
							</div>

							<div class="form-group">
								<label>Data Inicio</label>
								<input type="text" name="dt_inincio" class="form-control" />
							</div>

							<div class="form-group">
								<label>Foto</label>
								<input type="text" name="foto" class="form-control" />
							</div>

						</div>

					</div>

				<button type="submit" class="btn btn-primary btn-block">Adiciona</button>
				
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