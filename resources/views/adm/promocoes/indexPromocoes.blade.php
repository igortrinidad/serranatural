@extends('layout/admin')

@section('conteudo')
			
<h1 class="page-header">Promoções</h1>

			<div class="col-lg-2"></div>

				<div class="col-lg-8">


					<div class="panel panel-default painel-sorteio">
						<div class="panel-heading"><strong>Votação</strong></div>
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


@stop