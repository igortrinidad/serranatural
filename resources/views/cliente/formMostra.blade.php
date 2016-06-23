@extends('cliente.clienteMostra')

@section('formEditaOuMostra')


	    <div class="form-group text-left">
			<label>Nome</label>
			<p>{{$cliente->nome}}</p>
		</div>
		<div class="form-group text-left">
			<label>Telefone</label>
			<p>{{$cliente->telefone}}</p>
		</div>
				
			
		<div class="form-group text-left">
			<label>E-mail</label>
			<p>{{$cliente->email}}</p>
		</div>

	    <div class="form-group text-left">
			<label>Mailling Serra Natural</label> <br>
			@if($cliente->opt_email == 1)
			<a href="/admin/clientes/sairEmail/{{$cliente->id}}"><i class="fa fa-check-square-o"></i></a>
			@else
			<a href="/admin/clientes/entrarEmail/{{$cliente->id}}"><i class="fa fa-square-o"></i></a>
			@endif

	        <p class="texto_votacao">Aceito receber informações sobre promoções e novidades da Serra Natural.
	        <br>Ao desmarcar essa opção você <strong style="color:red">não</strong> receberá nossos e-mails do prato do dia.</p>
	    </div>
	    

	    <div class="form-group">
	        <a href="/admin/clientes/reenviaSenha/{{$cliente->id}}" class="btn btn-default btn-block">Reenviar senha de resgate </a>
	    </div>

	    <div class="form-group">
	        <a href="/admin/clientes/excluir/{{$cliente->id}}" class="btn btn-warning btn-block">Retirar da lista de email </a>
	        <br>
	        <p class="texto_votacao text-left">Ao clicar em retirar da lista você não receberá nossos emails e perderá os pontos e vouchers do programa fidelidade vinculados ao seu email e cadastro.</p>
	    </div>


@stop