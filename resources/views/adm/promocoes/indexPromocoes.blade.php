@extends('layout/admin')

@section('conteudo')
			
<h1 class="page-header">Promoções</h1>

	<div class="col-md-6">

		<div class="panel panel-default painel-sorteio">
			<div class="panel-heading"><strong>Votação {{date('H:i:s')}}</strong></div>
			<div class="panel-body">
				<table class="table">

					<tr>
						<td>Número promoção
						</td>
						<td>{{ isset($sorteio) ? $sorteio->id : '' }}
						</td>
					</tr>
					<tr>
						<td>Total de tickets válidos
						</td>
						<td>{{isset($ticketsValidos) ? $ticketsValidos->total : ''}}
						</td>						
					</tr>
					<tr>
						<td>Participantes únicos
						</td>
						<td>{{isset($participantes) ? $participantes->total : ''}}
						</td>						
					</tr>
					<tr>
						<td>Média ticket's por dia
						</td>
						<td>{{isset($mediaTickets) ? $mediaTickets : ''}}
						</td>		

					</tr>

				</table>


				<form action="/admin/promocoes/sorteioVotacao" method="POST">
				<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
				<input type="text" name="sorteio" value="{{ isset($sorteio) ? $sorteio->id : '' }}" hidden=true/>
				<input type="text" name="ticketsValidos" value="{{ isset($ticketsValidos) ? $ticketsValidos->total : '' }}" hidden=true/>
				<input type="text" name="participantes" value="{{ isset($participantes) ? $participantes->total : '' }}" hidden=true/>
				<input type="text" name="mediaTickets" value="{{ isset($mediaTickets) ? $mediaTickets : '' }}" hidden=true/>
				<input type="text" name="sortudo" value="{{ isset($sortudo) ? $sortudo->nome : '' }}" hidden=true/>
				<input type="text" name="sortudoId" value="{{ isset($sortudo) ? $sortudo->id : '' }}" hidden=true/>

					<div class="col-md-6">
						<button type="submit" class="btn btn-primary">Sortear ganhador</button>
					</div>
					<div class="col-md-6">
						<button type="submit" class="btn btn-primary" onclick="this.form.action='/admin/promocoes/salvaSorteado'">Salvar ganhador</button>
					</div>
				</form>
				<br />

				<h4>Sorteado: </h4>

				<button class="btn btn-success btn-sorteio btn-block" onclick="this.form.action='/admin/promocoes/sorteioVotacao'">Nome: {{ isset($sortudo) ? $sortudo->nome : '' }}<br />Telefone: {{ isset($sortudo) ? $sortudo->telefone : '' }}</button>
			</div>

		</div>
	</div>

	<div class="col-md-6">
	<div class="panel panel-default painel-sorteio">
		<div class="panel-heading"><strong>Lista de ganhadores</strong></div>
		<div class="panel-body">
			<table class="table bordered">
			<thead>
				<tr>
					<td>Nome</td>
					<td>Telefone</td>
					<td>Data resgate</td>
				</tr>	
			</thead>

			@foreach($lista as $l)
			 <tr>
			 	<td>{{$l->nomeCliente}}</td>
			 	<td>31 3131</td>
			 	<td> 23/08/2015</td>
			 </tr>
			 @endforeach
			</table>

		</div>
		</div>
	</div>




@stop