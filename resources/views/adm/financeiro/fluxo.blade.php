@extends('layout/admin')

@section('conteudo')

<h2 class="text-right">Fluxo de caixa</h2><br>

	@include('errors.messages')

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
						<input type="text" name="vendas_cash" value="{{$caixa->vendas_cash}}" class="form-control maskValor" />
					</div>

					<div class="form-group">
						<label>Total de vendas em cartão (sistema)</label>
						<input type="text" name="vendas_card" value="{{$caixa->vendas_card}}" class="form-control maskValor" />
					</div>

					<div class="form-group">
						<label>Total de vendas maquina <b>REDE</b></label>
						<input type="text" name="vendas_rede" value="{{$caixa->vendas_rede}}" class="form-control maskValor" />
					</div>

					<div class="form-group">
						<label>Total de vendas maquina <b>CIELO</b></label>
						<input type="text" name="vendas_cielo" value="{{$caixa->vendas_cielo}}" class="form-control maskValor" />
					</div>

					<div class="form-group">
						<label>Total de retiradas</label>
						<div class="btn btn-default btn-block" id="total_retirada">{{$caixa->total_retirada}}</div>
					</div>


					<div class="form-group">
						<label>Valor em caixa</label>
						<input type="text" name="vr_emCaixa" id="fundo_caixa" value="{{$caixa->vr_emCaixa}}" class="form-control maskValor" />
					</div>

					<div class="btn btn-primary btn-xl btn-block" id="calculaCaixa">Calcular caixa</div><br>

					<div class="btn btn-warning btn-xl btn-block" id="gravarCaixa">Gravar caixa</div><br>

					<a class="btn btn-danger btn-block btn-xl" id="btnFechar" data-toggle="modal" data-target="#modalSenha" >Fecha caixa</a>


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
					<div class="btn btn-default btn-block" id="esperado_caixa" value=""></div>
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
							    	@foreach($caixa->retiradas as $retirada)
							        <tr>
							            <th>{{$retirada->descricao}} 
							            	@if(isset($retirada->funcionario->nome))
							            		({{$retirada->funcionario->nome}})
							            	@endif
							            </th>
							            <th>{{$retirada->valor}}</th>
							            <th>{{$retirada->usuario->name}}</th>
							        </tr>
							        @endforeach
							    </tbody>
							</table>

						</div>

				</form>
			</div>
			</div>
	</div>

</div>

<div class="row">

	<div class="jumbotron">
			<h3>Instruções</h3>
			<h5>Total de vendas em dinheiro (sistema)</h5>
			<p style="font-size: 14px;">Inserir o valor de acordo com o registrado no aplicativo de vendas. Caminho: Acessar o menu no ícone: <i class="fa fa-bars"></i> <b> / REPORTS / SALES / CASH SALES: ( VALOR )</p>

			<h5>Total de vendas em cartão (sistema)</h5>
			<p style="font-size: 14px;">Inserir o valor de acordo com o registrado no aplicativo de vendas. Caminho: Acessar o menu no ícone: <i class="fa fa-bars"></i> <b> / REPORTS / SALES / THIRD PARTY SALES: ( VALOR )</p>

			<h5>Total de vendas maquina REDE</h5>
			<p style="font-size: 14px;">Inserir o valor de acordo com valor informado na máquina de cartão REDE através do caminho: <b>ADMINISTRA / RESUMO DE VENDAS / escolha da data do dia (HOJE) / RESUMIDO / DESCARTAR IMPRESSÃO: NÃO</b>. Obs. o valor a ser preenchido é o total no final da impressão.</p>

			<h5>Total de vendas maquina CIELO</h5>
			<p style="font-size: 14px;">Somar o valor total das vendas realizadas através da máquina CIELO. Obs. a máquina CIELO não permite a consulta diretamente pela máquina, portanto todos os comprovantes de vendas da máquina deverão ser guardados para o fechamento do caixa.</p>

			<h5>Total de retiradas</h5>
			<p style="font-size: 14px;">Este valor é preenchido automaticamente conforme for cadastrado as retiradas.</p>

			<h5>Valor em caixa</h5>
			<p style="font-size: 14px;">Contar todo dinheiro no caixa, incluindo dinheiro guardado em baixo da gaveta e vouchers.</p>

			<h5>Fechar caixa</h5>
			<p style="font-size: 14px;">Clicar em <b>Calcular caixa</b> e conferir se o valor bate com o esperado (positivo ou negativo), clicar em <b>Gravar caixa</b> e <b>Fechar caixa</b> inserindo a senha de operação (pessoal).</p>

		</div>


</div>

@else
	<div class="col-md-12" id="divAbrir">

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-6">
						<h4>Abrir caixa</h4>
						<p>Informe o valor em caixa para iniciar o sistema.</p>
					</div>

				</div>
			</div>
			<div class="panel-body">

				<div class="col-md-3"></div>
					<div class="col-md-6">

						<div class="form-group">
							<input id="valor_informado" value="" class="form-control maskValor" />
						</div>

						<div class="form-group">
							<button class="btn btn-primary btn-xl" id="btnAbrir" data-toggle="modal" data-target="#modalSenha" >Abrir caixa</button>
						</div>

					</div>

			</div>
		</div>

		<div class="jumbotron">
			<h3>Instruções</h3>
			<p style="font-size: 14px;">Contar todo dinheiro no caixa, incluindo dinheiro guardado em baixo da gaveta e vouchers. Inserir o valor e clicar em <b>"abrir caixa"</b>.</p>
		</div>
	</div>
	
@endif

<!-- Modal editar atividade -->              
                            <div class="modal inmodal fade" id="modalSenha" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title" id="tituloModal">Confirma</h4>
                                        </div>
                                        <div class="modal-body text-center">
											<h4>Valor em caixa:</h4>

                                            <p style="font-size: 25px;font-weight:700" id="valor_confirmation">??</p>
											<span >
	                                            <h4>Diferença final:</h4>

	                                            <p style="font-size: 25px;font-weight:700" id="diferenca_caixa"></p>
                                            </span>
                                    
                                        </div>
                                        <div class="modal-footer inline">

											<form id="formAbreCaixa" method="POST">

												<input type="hidden" name="_token" value="{{ csrf_token() }}">
											
											<div class="form-group">
												<label>Insira sua senha</label>
                                        		<input type="password" name="senha" class="form-control" value="" />
											</div>

	                                            <button type="button" class="btn btn-white btn-sm" data-dismiss="modal">Cancela</button>
	                                            
	                                            <button id="btnAbreCaixaDefinitivo" class="btn btn-danger btn-sm">Confirma abertura</button>

	                                            <button id="btnFechaDefinitivo" class="btn btn-danger btn-sm" style="display:none">Confirma fechamento</button>
                                            </form>
                                        </div>
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
	var totalRetirada = parseFloat($("#total_retirada").text());
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