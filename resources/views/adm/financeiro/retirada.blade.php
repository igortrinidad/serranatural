@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Fluxo de caixa</h2><br>

	@if(Session::has('msg_retorno'))
	<div class="alert alert-{{Session::get('tipo_retorno')}}">
	     {{Session::get('msg_retorno')}}
	 </div>
	@endif

<div class="row">

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

<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">


    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/financeiro.js') !!}"></script>

<script type="text/javascript">

$('.maskValor').mask("0000.00", {reverse: true});

;(function($)
{
	'use strict';
	$(document).ready(function()
	{

		if($("#id_caixa").text() >= 1)
		{
			window.console.log('É maior');
			$('#btnAbreCaixaDefinitivo').remove();
			$('#btnFechaDefinitivo').show();

		} else if($("#id_caixa").text() == '')
		{
			$('#btnAbreCaixaDefinitivo').show();
			$('#btnFechaDefinitivo').remove();
			$('#valor_confirmation + span').remove();
		}

	});


})(window.jQuery);

$('#btnAbrir').on("click", function(e){

	e.preventDefault();

	var valor_informado = $('#valor_informado').val();

	window.console.log(valor_informado);

	$('#valor_confirmation').text('R$ ' + valor_informado);

});



$('#btnAbreCaixaDefinitivo').on("click", function(e){

	e.preventDefault();
	abreCaixa();

});



function abreCaixa()
{
    
	formData = {
		'_token' : $("#token").val(),
		'senha' : $("input[name='senha']").val(),
		'vr_abertura' : parseFloat($('#valor_informado').val()),
	};

	var url = "{{ route('admin.financeiro.abreCaixa')}}";

	$.ajax({
	    type: "POST",
	    url : url,
	    data : formData,
	    success : function(data){

	    	var msg = data['msg_retorno'];
	    	var tipo = data['tipo_retorno'];

	        $.notify(msg, tipo);

	    if(tipo == 'success')
	    {

	    	setTimeout(function(){
	        	$('#modalSenha').fadeOut();
	        }, 500);

		    setTimeout(function()
		    {
		    	location.reload();
		    }, 1200);
		}

	    }
	    },"json");

};

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
	window.esperadoCaixa = (vendasCash + vrAbertura) + ( - totalRetirada);
	var diferencaDinheiro = emCaixa - esperadoCaixa;
	var diferencaFinal = diferencaCartoes + (diferencaDinheiro);
	
	$('#esperado_caixa').text('R$ ' + esperadoCaixa.toFixed(2));
	$('#vr_diferenca_cartoes').text('R$ ' + diferencaCartoes.toFixed(2));
	$('#vr_diferenca_caixa').text('R$ ' + diferencaDinheiro.toFixed(2));
	$('#vr_diferenca_final').text(diferencaFinal.toFixed(2));

	if(diferencaFinal <= 0)
	{
		$.notify('Diferença de caixa: R$ ' + diferencaFinal.toFixed(2), 'error')
	} else {
		$.notify('Diferença de caixa: R$ ' + diferencaFinal.toFixed(2), 'success')
	}

	

};


$('#gravarCaixa').on("click", function(e)
{
    e.preventDefault();

    	calculaCaixa();
    	gravaCaixa();
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
            'esperado_caixa' : esperadoCaixa,
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

	$('#btnFechar').on("click", function(e){

		e.preventDefault();
		$('#valor_confirmation').text('R$ ' + $('#fundo_caixa').val());
		$('#valor_confirmation + span').show();
		$('#diferenca_caixa').text($('#vr_diferenca_final').text());

	});

	$('#btnFechaDefinitivo').on("click", function(e)
	{
		window.console.log('btnFechaDefinitivo');

	    e.preventDefault();
		calculaCaixa();
		gravaCaixa();
		fechaCaixa();
	});

	function fechaCaixa()
    {

        var formData = {
        	'_token' : $("#token").val(),
        	'id' : $("#id_caixa").text(),
        	'senha' : $("input[name='senha']").val(),
        };

        window.console.log(formData);

		var url = "{{ route('admin.financeiro.fecharCaixa') }}";

		$.ajax({
		    type: "POST",
		    url : url,
		    data : formData,
		    success : function(data){

		    	var msg = data['msg_retorno'];
		    	var tipo = data['tipo_retorno'];

		        $.notify(msg, tipo);


			    if(tipo == 'success')
			    {
			    	setTimeout(function(){
			        	$('#modalSenha').fadeOut();
			        }, 500);

				    setTimeout(function()
				    {
				    	location.reload();
				    }, 1200);

				    }
			}

		},"json");
	};


//funcoes de teste	

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