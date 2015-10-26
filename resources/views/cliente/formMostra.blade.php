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

	    <div class="form-group">
	        <input form="votoForms" type="hidden" name="opt_email" value="0" class="checkbox"/>
	        <input form="votoForms" type="checkbox" name="opt_email" value="1" class="checkbox" @if($cliente->opt_email == 1) checked @endif/>
	        <p class="texto_votacao">Aceito receber informações sobre promoções e novidades da Serra Natural.
	        <br>Ao desmarcar essa opção você <strong style="color:red">não</strong> receberá nossos e-mails.</p>
	    </div>
	    

	    <div class="form-group">
	        <a href="/me/edita/{{$cliente->email}}" class="btn btn-default pull-right">Editar</a>
	    </div>


@stop