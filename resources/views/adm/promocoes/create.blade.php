@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Criar promoção</h1>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"><h5></h5></div>
			<div class="panel-body">
				
				<form method="POST" action="/admin/promocoes/store" enctype="multipart/form-data">
					
					{!! csrf_field() !!}

					<div class="form-group">
						<label>Título</label>
						<input type="text" class="form-control" name="titulo">
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Data ínicio</label>
								<input type="text" class="form-control dataCompleta datepicker" name="inicio">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Data fim</label>
								<input type="text" class="form-control dataCompleta datepicker" name="fim">
							</div>
						</div>
						
					</div>

					<div class="form-group">
						<label>Foto</label>
						<input type="file" name="foto" class="form-control">
					</div>

					<div class="form-group">
						<label>Descrição</label>
						<textarea name="descricao" class="form-control"></textarea>
					</div>

					<div class="form-group">
						<label>Regulamento</label>
						<textarea name="regulamento" class="form-control"></textarea>
					</div>

					<button class="btn btn-primary" type="submit">Cadastrar</button>

				</form>

			</div>
		</div>
	</div>

</div>


    @section('scripts')
	    @parent


		@stop


@stop