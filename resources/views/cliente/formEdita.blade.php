@extends('cliente.clienteMostra')

@section('formEditaOuMostra')

	<form id="votoForm" action="/me/selfChangeClient" class="form-group" method="POST">
	    <input form="votoForm" type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	   
	    <div class="form-group">
	        <label class="label_form primeiro_label_form pull-left">Nome</label>
	        <input form="votoForm" type="text" name="nome" value="{{ $cliente->nome }}" class="form-control"/>
	    </div>

	    <div class="form-group">
	        <label class="label_form pull-left">Email</label>
	        <input form="votoForm" type="email" name="email" value="{{ $cliente->email }}"class="form-control"/>
	    </div>

	    <div class="form-group">
	        <label class="label_form pull-left">Telefone</label>
	        <input form="votoForm" type="text" name="telefone" value="{{ $cliente->telefone }}"class="form-control phone_with_ddd"/>
	    </div>

	    <div class="form-group">
	        <input form="votoForm" type="hidden" name="opt_email" value="0" class="checkbox"/>
	        <input form="votoForm" type="checkbox" name="opt_email" value="1" class="checkbox" @if($cliente->opt_email == 1) checked @endif/>
	        <p class="texto_votacao">Aceito receber informações sobre promoções e novidades da Serra Natural.
	        <br>Ao desmarcar essa opção você <strong style="color:red">não</strong> receberá nossos e-mails.</p>
	    </div>
	    

	    <div class="form-group">
	        <button id="votoCadastro" form="votoForm" type="submit" class="btn btn-primary btn-block">Salvar</button>
	    </div>

	</form>

@stop