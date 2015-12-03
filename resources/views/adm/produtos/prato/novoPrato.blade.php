@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Pratos do dia</h1>

	@if(Session::has('msg_retorno'))
	<div class="alert alert-{{Session::get('tipo_retorno')}}">
	     {{Session::get('msg_retorno')}}
	 </div>
	@endif

<div class="panel panel-default">
	<div class="panel-heading"><h5>Lista de pratos</h5></div>
		<div class="panel-body">
        <div class="row">
          <div class="col-md-10">
            <div class="form-group">
              {!! Form::select('pratos_id', $pratosForSelect, null, ['class' => 'form-control', 
              'single' => 'single', 'id' => 'pratos', 'placeholder' => 'Selecione um prato'])   !!}
            </div>
          </div>
          <div class="col-md-2">
            <a href="" class="btn btn-default" id="btnMostra" >Mostrar</a>
          </div>
    </div>
  </div>
</div>

 <div class="panel panel-default">
	<div class="panel-heading"><h5>Lista Pratos</h5></div>
	<div class="panel-body">

		<div class="inline text-right">
					<a href="{!! $listaPratos->previousPageUrl() !!}" class="btn btn-primary"><i class="fa fa-chevron-left"></i></a>
					<a href="{!! $listaPratos->nextPageUrl() !!}" class="btn btn-primary"><i class="fa fa-chevron-right"></i></a>
				</div><br />

		<table class="table table-bordered">
			<thead><strong>
				<tr>
					<td>Nome</td>
					<td>Acompanhamentos</td>
					<td>Pequeno</td>
					<td>Grande</td>
					<td>Edita</td>
					<td>Ativo</td>
				</tr>
			</thead></strong>
			@foreach($listaPratos as $p)
			<tr>
				<td>{{isset($p) ? $p->prato : ''}}</td>
				<td>{{isset($p) ? $p->acompanhamentos : ''}}</td>
				<td>{{isset($p) ? $p->valor_pequeno : ''}}</td>
				<td>{{isset($p) ? $p->valor_grande : ''}}</td>
				<td><a href="/admin/produtos/pratos/mostra/{{$p->id}}"><i class="fa fa-pencil"></i></a></td>
				<td>
					@if($p->ativo == 1)
						<a href="/admin/produtos/pratos/desativar/{{$p->id}}"><i class="fa fa-check-square-o"></i></a>
					@else
						<a href="/admin/produtos/pratos/ativar/{{$p->id}}"><i class="fa fa-square-o"></i></a>
					@endif
				</td>
			</tr>
			@endforeach
		</table>

	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading"><h5>Cadastrar Pratos</h5></div>
	<div class="panel-body">

			<form action="/admin/produtos/salvaPratos" method="POST" class="form-group" enctype="multipart/form-data">

				<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

				<div class="form-group">
					<label>Nome</label>
					<input type="text" name="prato" class="form-control">
				</div>

				<div class="form-group">
					<label>Acompanhamentos</label>
					<textarea type="textarea" name="acompanhamentos" class="form-control"></textarea>
				</div>

				<div class="form-group">
					<label>Foto</label>
					<input type="file" name="foto" class="form-control">
				</div>

				<div class="form-group">
					<label>Titulo foto</label>
					<input type="text" name="titulo_foto" class="form-control">
				</div>

				<button type="submit" class="btn btn-primary">Cadastrar Prato</button>
                               

			</form>

	</div>
</div>


    @section('scripts')
      @parent

      <script type="text/javascript">

      $('#pratos').select2();

      $("#pratos").change(function() 
      {
        var id = $(this).val();
        var href = '/admin/produtos/pratos/mostra/' + id;

        $('#btnMostra').prop("href", href);

      });

      </script>

      @stop


@stop