@extends('layout/emailBasico')

@section('conteudo')

<style>
body{
background-color: rgb(243, 243, 243);
}

.panel
{
margin: auto;
padding-right: 20px;
padding-left: 20px;
margin-top: 30px;
margin-bottom: 30px;
}

</style>

<div class="col-md-3"></div>
	<div class="col-md-6">
		<div class="panel">
		<div class="panel-heading text-center">
			<img src="http://45.55.224.49/img/logo_fundobranco.png" alt="Serra Natural - Almoço"/>
		</div>
		<div class="panel-body">
			<h3>Cardápio de hoje: <span style="color: rgb(43, 172, 25)">{{isset($prato) ? $prato : ''}}</span></h3>

			<br /><p>Olá {{isset($nomeCliente) ? $nomeCliente : ''}},</p>

			<p>Acabei de lembrar que você gosta de <strong>{{isset($prato) ? $prato : ''}}</strong>, não é mesmo?</p>

			<p>Venha almoçar com a gente e aproveite para escolher os pratos da próxima semana.</p>

			<p>Lembranças,</p>
			<strong><p>Equipe Serra Natural</p></strong>

			<br />
			<span class="text-center"><i class="fa fa-clock-o"></i> 11:30 às 02:30</span>


		</div>
	</div>
</div>

@stop