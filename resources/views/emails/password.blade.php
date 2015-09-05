@extends('layout/emailBasico')

@section('conteudo')

<style>
body{
	background-color: grey;
}
.panel{
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
	<img src="https://lh5.googleusercontent.com/-EgbVX_pkBVc/VUfx53ls4-I/AAAAAAAAADc/7ny4hjr_G7s/s203-k-no/" />
</div>
<div class="panel-body">
<h3>E-mail de recuperação de senha</h3>

<p>Recebemos a sua solicitação de senha.</p>

<p>Utilize a nova senha para logar no sistema.</p>

<p><strong>Nova senha: <span class="btn btn-default btn-block">{{isset($pass) ? $pass : ''}}</span></strong></p>

<p>Lembranças,</p>
<p>Equipe Serra Natural</p>

</div>
</div>
</div>

@stop