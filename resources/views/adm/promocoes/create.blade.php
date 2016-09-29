@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Criar promoção</h1>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"><h5></h5></div>
			<div class="panel-body">
				
				<form enctype="multipart/form-data" method="POST" action="/admin/promocoes/store">
	
					<div class="form-group">
						<label>Titulo</label>
						<input type="text" class="form-control" name="titulo">
					</div>

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

					<div class="form-group">
						<label>Foto</label>
						<input type="file" class="form-control" name="fim">
					</div>

					<div class="form-group">
						<label>Descrição</label>
						<textarea name="descricao" class="form-control"></textarea>
					</div>



				</form>

			</div>
		</div>
	</div>

</div>


    @section('scripts')
	    @parent


		@stop


@stop