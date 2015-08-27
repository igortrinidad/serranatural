@extends('layout/adm')

@section('conteudo')

@if(Session::has('msg_retorno'))
<div class="alert alert-{{Session::get('tipo_retorno')}}">
     {{Session::get('msg_retorno')}}
 </div>
@endif

	<div class="row">
	<h1 class="text-right">Adiciona novo prato</h1>

		<div class="col-lg-2"></div>

			<div class="col-lg-8">

				<form action="/adm/produtos/salvaPratos" method="POST" class="form-group">

					<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	
					<div class="form-group">
						<label>Nome Prato</label>
						<input type="text" name="prato" class="form-control">
					</div>
	
					<div class="form-group">
						<label>Acompanhamentos</label>
						<textarea type="textarea" name="acompanhamentos" class="form-control"></textarea>
					</div>
	
					<button type="submit" class="btn btn-primary">Cadastrar Prato</button>
                                   

				</form>

		</div>
	</div>



@stop