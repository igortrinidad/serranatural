@extends('layout/adm')

@section('conteudo')

<div class="container">
	<div class="row">
		<div class="col-mg-12">
			
			<div class="col-lg-2"></div>

				<div class="col-lg-8">

					<h2 class="text-right">Promoções</h2>


					<div class="panel painel-sorteio">
						<div class="panel-heading panel-info"><strong>Votação</strong></div>
						<div class="panel-body">
						<div class="col-md-1"></div>
						<div class="col-md-8">
							<h5 class="h5-sorteio">Número promoção:</h5>
							<h5 class="h5-sorteio">Total de tickets válidos:</h5>
							<h5 class="h5-sorteio">Total de participantes:</h5>
							<h5 class="h5-sorteio">Média de tickets válidos por dia:</h5>

				<form action="adm/promocoes/sorteioVotacao" method="POST">

					<button type="submit" class="btn btn-primary">Sortear ganhador</button>

				</form>

				<h4>Sorteado: </h4>

				<button class="btn btn-success btn-sorteio">Nome: <br />Telefone:</button>
</div>

				</div>
			</div>
		</div>
    </div>
</div>


@stop