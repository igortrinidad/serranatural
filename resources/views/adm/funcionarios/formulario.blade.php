@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">@yield('title')</h2><br>

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


							{!! csrf_field() !!}
							<input type="hidden" name="id" value="{{isset($funcionario) ? $funcionario->id : ''}}" />

							<div class="form-group">
								<label>Nome completo</label>
								<input type="text" name="nome" value="{{isset($funcionario) ? $funcionario->nome : ''}}" class="form-control" />
							</div>

							<div class="form-group">
								<label>Telefone</label>
								<input type="text" name="telefone" value="{{isset($funcionario) ? $funcionario->telefone : ''}}" class="form-control" />
							</div>

							<div class="form-group">
								<label>Email</label>
								<input type="text" name="email" value="{{isset($funcionario) ? $funcionario->email : ''}}" class="form-control" />
							</div>

							<div class="form-group">
								<label>Endereço</label>
								<input type="text" name="endereco" value="{{isset($funcionario) ? $funcionario->endereco : ''}}" class="form-control" />
							</div>

							<div class="form-group">
								<label>Horario</label>
								<input type="text" name="horario_trabalho" value="{{isset($funcionario) ? $funcionario->horario_trabalho : ''}}" class="form-control" />
							</div>

							<div class="form-group">
								<label>Cargo</label>
								<input type="text" name="cargo" value="{{isset($funcionario) ? $funcionario->cargo : ''}}" class="form-control" />
							</div>

							<div class="form-group">
								<label>Observações</label>
								<textarea 
								name="observacoes" type="textarea" 
								class="form-control">
								{{isset($funcionario) ? $funcionario->observacoes : ''}}
								</textarea>
							</div>

						</div>
						<div class="col-md-6">


							<div class="form-group">
								<label>Transporte</label>
								<input type="text" name="transporte" value="{{isset($funcionario) ? $funcionario->transporte : ''}}" class="form-control" />
							</div>

							<div class="form-group">
								<label>Valor Onibus</label>
								<input type="text" name="vr_transporte" value="{{isset($funcionario) ? $funcionario->vr_transporte : ''}}" class="form-control" />
							</div>

							<div class="form-group">
								<label>Identidade</label>
								<input type="text" name="identidade" value="{{isset($funcionario) ? $funcionario->identidade : ''}}" class="form-control" />
							</div>

							<div class="form-group">
								<label>CPF</label>
								<input type="text" name="cpf" value="{{isset($funcionario) ? $funcionario->cpf : ''}}" class="form-control .cpf" />
							</div>

							<div class="form-group">
								<label>Salario</label>
								<input type="text" name="vr_salario" value="{{isset($funcionario) ? $funcionario->vr_salario : ''}}" class="form-control" />
							</div>

							<div class="form-group">
								<label>Data Inicios</label>
								<input type="text" name="dt_inicio" value="{{isset($funcionario) ? $funcionario->dt_inicio->format('Y-m-d') : ''}}" class="form-control dataMysql" />
							</div>

							<div class="form-group">
								<label>Foto</label>
								<input type="text" name="foto" value="{{isset($funcionario) ? $funcionario->foto : ''}}" class="form-control" />
							</div>

						</div>

					</div>

				<button type="submit" class="btn btn-primary btn-block">Salvar</button>
				
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