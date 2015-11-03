@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Histórico de caixa</h2>

	@if(Session::has('msg_retorno'))
	<div class="alert alert-{{Session::get('tipo_retorno')}}">
	     {{Session::get('msg_retorno')}}
	 </div>
	@endif


<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-6">
						<h4>Histórico</h4>
					</div>
					<div class="col-md-6">
						<div class="inline text-right">
							<ul class="pagination">
								<li>
									<a href="" rel="prev">«</a>
								</li>
								<li>
									<a href="" rel="prev">»</a>
								</li>
							</ul>	
						</div>
					</div>
				</div>
			</div>
			<div class="panel-body">

				<table class="table table-bordered table-hover table-striped">
				    <thead>
				        <tr>
				            <th width="15%">Data abertura</th>
				            <th width="15%">Data fechamento</th>
				            <th width="13%">Usuario abertura</th>
				            <th width="13%">Usuario fechamento</th>
				            <th width="10%">Vr Abertura</th>
				            <th width="10%">Fundo de caixa</th>
				            <th width="10%">Diferença final</th>
				        </tr>
				    </thead>
				    <tbody>
				    @foreach($caixas as $c)
				        <tr>
				            <th>{{$c->dt_abertura}}</th>
				            <th>{{$c->dt_fechamento}}</th>
				            <th>{{$c->usuarioAbertura->name}}</th>
				            <th>@if($c->is_aberto == 1) -- @else{{$c->usuarioFechamento->name}}@endif</th>
				            <th>R$ {{ number_format($c->vr_abertura, 2, ',', '.') }}</th>
				            <th>{{$c->vr_emCaixa}}</th>
				            <th>{{$c->diferenca_final}}</th>
				        </tr>
				      @endforeach
				    </tbody>
				</table>
			</div>

		</div>
	</div>
</div>


    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/financeiro.js') !!}"></script>

<script type="text/javascript">
</script>

	    @stop

@stop