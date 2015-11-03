@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Fluxo de caixa</h2><br>

	@if(Session::has('msg_retorno'))
	<div class="alert alert-{{Session::get('tipo_retorno')}}">
	     {{Session::get('msg_retorno')}}
	 </div>
	@endif

<div class="row">

@if( isset($caixa))

<div class="col-md-6">

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-6">
						<h4>Caixa do dia</h4>
					</div>
					<div class="col-md-6">
						<h4 class="pull-right">Codigo: {{$caixa->id}}</h4>
					</div>

				</div>
			</div>
			<div class="panel-body">

				<form id="caixaDia" action="" method="POST">


					<div class="form-group">
						<label>Total de vendas em dinheiro (sistema)</label>
						<input type="text" name="vendas_cash" value="{{$caixa->vendas_cash}}" class="form-control" />
					</div>

					<div class="form-group">
						<label>Total de vendas em cartão (sistema)</label>
						<input type="text" name="vendas_card" value="{{$caixa->vendas_card}}" class="form-control" />
					</div>

					<div class="form-group">
						<label>Total de vendas maquina <b>REDE</b></label>
						<input type="text" name="vendas_rede" value="{{$caixa->vendas_rede}}" class="form-control" />
					</div>

					<div class="form-group">
						<label>Total de vendas maquina <b>CIELO</b></label>
						<input type="text" name="vendas_cielo" value="{{$caixa->vendas_cielo}}" class="form-control" />
					</div>

					<div class="form-group">
						<label>Total de retiradas</label>
						<input type="text" name="total_retirada" value="{{$caixa->total_retirada}}" class="form-control" />
					</div>


					<div class="form-group">
						<label>Valor em caixa</label>
						<input type="text" name="" id="fundo_caixa" value="{{$caixa->fundo_caixa}}" class="form-control" />
					</div>

					<div class="btn btn-primary btn-xl btn-block" id="calculaCaixa">Calcular caixa</div><br>

					<div class="btn btn-warning btn-xl btn-block" id="gravarCaixa">Gravar caixa</div><br>

					<button class="btn btn-danger btn-xl btn-block" id="btnFechaCaixa">Fechar caixa</button><br>


				</form>
			</div>
		</div>
	</div>

	<div class="col-md-6">

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-6">
						<h4>Informações caixa</h4>
					</div>

				</div>
			</div>
			<div class="panel-body">

				<div class="form-group">
					<label>Codigo</label>
					<div class="btn btn-default btn-block" id="id_caixa">{{$caixa->id}}</div>
				</div>

				<div class="form-group">
					<label>Valor abertura</label>
					<div class="btn btn-default btn-block" id="vr_abertura">{{$caixa->vr_abertura}}</div>
				</div>

				<div class="form-group">
					<label>Data abertura</label>
					<div class="btn btn-default btn-block">{{$caixa->dt_abertura}}</div>
				</div>

				<div class="form-group">
					<label>Responsavel Abertura</label>
					<div class="btn btn-default btn-block" >{{$caixa->usuarioAbertura->name}}</div>
				</div>

				<div class="form-group">
					<label>Valor esperado em caixa</label>
					<div class="btn btn-default btn-block" id="esperado_caixa">0</div>
				</div>

				<div class="form-group">
					<label>Responsavel Fechamento</label>
					<div class="btn btn-default btn-block">0</div>
				</div>

				<div class="form-group">
					<label>Diferença cartões (sistema e real)</label>
					<div class="btn btn-default btn-block" id="vr_diferenca_cartoes">0</div>
				</div>

				<div class="form-group">
					<label>Diferença caixa</label>
					<div class="btn btn-default btn-block" id="vr_diferenca_caixa">0</div>
				</div>

				<div class="form-group">
					<label>Diferença final</label>
					<div class="btn btn-default btn-block" id="vr_diferenca_final">0</div>
				</div>

			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-6">
						<h4>Retiradas</h4>
					</div>

				</div>
			</div>
			<div class="panel-body">

				<form id="retiradas" action="" method="POST">
					<div class="row">

						<div class="text-center" data-toggle="collapse" data-target="#retiradaArea"> Adicionar retirada <i class="fa fa-chevron-down"></i>
						</div>
					</div>
	                    <div id="retiradaArea" class="collapse">
					
						
							<div class="row">
								<div class="col-md-8">
									<div class="form-group">
										<label>Descrição</label>
										<input type="text" name="" class="form-control" />
									</div>
								</div>
								<div class="col-md-4">


									<div class="form-group">
										<label>Valor</label>
										<input type="text" name="" class="form-control" />
									</div>

								</div>
							</div>
							<button type="submit" class="btn btn-default btn-block">Gravar retirada</button>

						</div>
						<br>
						<div>
							<table class="table table-bordered table-hover table-striped">
							    <thead>
							        <tr>
							            <th>Descrição</th>
							            <th>Valor</th>
							            <th>Usuario</th>
							        </tr>
							    </thead>
							    <tbody>
							        <tr>
							            <th></th>
							            <th></th>
							            <th></th>
							        </tr>
							    </tbody>
							</table>

						</div>

				</form>
			</div>
			</div>
	</div>

@else
	<div class="col-md-12" id="divAbrir">

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-6">
						<h4>Abrir caixa</h4>
					</div>

				</div>
			</div>
			<div class="panel-body">

				<form id="formAbreCaixa" action="{{ route('admin.financeiro.abreCaixa')}}" method="POST">

					<input type="hidden" name="_token" value="{{ csrf_token() }}">

					<div class="form-group">
						<label>Valor em caixa</label>
						<input type="text" name="vr_abertura" class="form-control">
					</div>

					<button type="submit" class="btn btn-primary btn-xl" data-toggle="confirmation" >Abrir caixa</button>

				</form>
			</div>
		</div>
	</div>		
	
@endif	

<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

</div>

<div class="btn btn-block btn-primary" id="btnTesta"></div>
<div id="testa"></div>


    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/financeiro.js') !!}"></script>

<script type="text/javascript">

$('#formAbreCaixa button[type=submit]').click(function(e){
    e.preventDefault();

	var form = jQuery(this).parents("form:first");
	var dataString = form.serialize();

	window.console.log(dataString);

	var formAction = form.attr('action');

	$.ajax({
	    type: "POST",
	    url : formAction,
	    data : dataString,
	    success : function(data){

	    	var msg = data['msg_retorno'];
	    	var tipo = data['tipo_retorno'];

	        $.notify(msg, tipo);
	        $('#formAbreCaixa')[0].reset();
	        
	        setTimeout(function(){
	        	$('#divAbrir').fadeOut();
	        }, 600);

	    if(tipo == 'success')
	    {

		    setTimeout(function()
		    {
		    	location.reload();
		    }, 2500);
		}

	    }
	    },"json");

	});

$('#calculaCaixa').on("click", function(e)
	{
		e.preventDefault();
		calculaCaixa();
});

function calculaCaixa()
{
	var vendasCash = parseFloat($("input[name='vendas_cash']").val());
	var vendasCard = parseFloat($("input[name='vendas_card']").val());
	var vendasRede = parseFloat($("input[name='vendas_rede']").val());
	var vendasCielo = parseFloat($("input[name='vendas_cielo']").val());
	var vrAbertura = parseFloat($("#vr_abertura").text());
	var totalRetirada = parseFloat($("input[name='total_retirada']").val());
	var emCaixa = parseFloat($("#fundo_caixa").val());
	var vendasTotalCartao = vendasCielo + vendasRede;
	var diferencaCartoes = vendasTotalCartao - vendasCard;
	var esperadoCaixa = (vendasCash + vrAbertura) + ( - totalRetirada);
	var diferencaDinheiro = emCaixa - esperadoCaixa;
	var diferencaFinal = diferencaCartoes + (diferencaDinheiro);
	
	$('#esperado_caixa').text(esperadoCaixa);
	$('#vr_diferenca_cartoes').text(diferencaCartoes);
	$('#vr_diferenca_caixa').text(diferencaDinheiro);
	$('#vr_diferenca_final').text(diferencaFinal);


	$.notify('Diferença de caixa: ' + diferencaFinal + '.', 'warning')

};


$('#gravarCaixa').on("click", function(e)
{
    e.preventDefault();

    	calculaCaixa();
    	gravaCaixa();
});

$('#btnFechaCaixa').on("click", function(e)
{
    e.preventDefault();

    	calculaCaixa();
    	gravaCaixa();
    	fechaCaixa();
});

    function gravaCaixa()
    {

        var formData = {
        	'_token' : $("#token").val(),
        	'id' : $("#id_caixa").text(),
            'vendas_cash' : $("input[name='vendas_cash']").val(),
            'vendas_card' : $("input[name='vendas_card']").val(),
            'vendas_rede' : $('input[name="vendas_rede"]').val(),
            'vendas_cielo' : $('input[name="vendas_cielo"]').val(),
            'total_retirada' : $('input[name="total_retirada"]').val(),
            'vr_abertura' : $('#vr_abertura').text(),
            'fundo_caixa' : $("#fundo_caixa").val(),
            'diferenca_cartoes' : $($('#vr_diferenca_cartoes')).text(),
            'diferenca_caixa' : $('#vr_diferenca_caixa').text(),
            'diferenca_final' : $('#vr_diferenca_final').text(),
            'esperado_caixa' : $('#esperado_caixa').text(),
            'vr_emCaixa' : $('#fundo_caixa').val(),
        };

		var formAction = "{{ route('admin.financeiro.gravarCaixa') }}";

		$.ajax({
		    type: "POST",
		    url : formAction,
		    data : formData,
		    success : function(data){

		    	var msg = data['msg_retorno'];
		    	var tipo = data['tipo_retorno'];

		        $.notify(msg, tipo);

		    }
		},"json");
	};

	function fechaCaixa()
    {

        var formData = {
        	'_token' : $("#token").val(),
        	'id' : $("#id_caixa").text(),
        };

		var formAction = "{{ route('admin.financeiro.fecharCaixa') }}";

		$.ajax({
		    type: "POST",
		    url : formAction,
		    data : formData,
		    success : function(data){

		    	var msg = data['msg_retorno'];
		    	var tipo = data['tipo_retorno'];

		        $.notify(msg, tipo);

		    }
		},"json");
	};

$('#btnTesta').on("click", function(e)
{
    e.preventDefault();

	testa();
});

		function testa()
    {

        var formData = {
        	'Authorization': 'Bearer 5bDwfv16l7I02iePbc2GcQ',
			'Accept': 'application/json',
			'Content-Type': 'application/json'
        };

		var formAction = "https://connect.squareup.com/v1/L5LhCF4NPETn2IEevtahMQ/payments";

		$.ajax({
		    type: "POST",
		    url : formAction,
		    data : formData,
		    success : function(data){

		        $.notify(data);
		        $('#testa').text(data);

		    }
		},"json");
	};

</script>

	    @stop

@stop