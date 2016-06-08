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
	        <br>Ao desmarcar essa opção você <strong style="color:red">não</strong> receberá nossos e-mails.</p>
	    </div>
	    

	    <div class="form-group">
	        <a href="/admin/clientes/reenviaSenha/{{$cliente->id}}" class="btn btn-default btn-block">Reenviar Senha <i class="fa fa-share"></i></a>
	    </div>


@stop