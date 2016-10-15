@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Lista promoções</h1>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"><h5></h5></div>
			<div class="panel-body">
			
				<table class="table table-bordered table-hover table-striped">
				    <tbody>
				    @foreach($promocoes as $promo)
				    	<tr>
				    		<th>Titulo</th>
				    		<th>Inicio</th>
				    		<th>Fim</th>
				    		<th>Editar</th>
				    		<th>Ativar?</th>
				    	</th>
				        <tr>
				            <td width="70%">{{$promo->titulo}}</td>
				            <td>{{$promo->inicio}}</td>
				            <td>{{$promo->fim}}</td>
				            <td class="text-center">
				            	<a href="/admin/promocoes/edita/{{$promo->id}}">
				            		<i class="fa fa-pencil fa-2x"></i>
				            	</a>
				            </td>
				            @if($promo->is_ativo)
				            	<td class="text-center">
				            		<a href="/admin/promocoes/status/{{$promo->id}}">
				            			<i class="fa fa-check-square fa-2x"></i>
				            		</a>
				            	</td>
				            @else
				            	<td class="text-center">
				            		<a href="/admin/promocoes/status/{{$promo->id}}">
				            			<i class="fa fa-square-o fa-2x"></i>
				            		</a>
				            	</td>
				            @endif
				        </tr>
				        <tr>
				        	<td colspan="5"><strong>Descrição</strong> <br>{{$promo->descricao}}</td>
				        </tr>

				        <tr>
				        	<td colspan="5"><strong>Regulamento</strong> <br>{{$promo->descricao}}</td>
				        </tr>
				        <tr>
							<td colspan="5"><strong>Foto</strong><br><img width="100%" src="/uploads/promocoes/{{$promo->foto}}" /></td>
				        </tr>
				        <tr><td colspan="5"></td></tr>
				      @endforeach
				    </tbody>
				</table>

			</div>
		</div>
	</div>

</div>


    @section('scripts')
	    @parent


		@stop


@stop