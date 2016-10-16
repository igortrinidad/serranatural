@extends('landing/template/landing')

@section('conteudo')

    <div class="row">
        <div class="box">
            <div class="col-lg-12 text-center">
                
                @include('flash::message')

            	<hr>
                <h2 class="intro-text text-center">
                    <strong>Bem vindo</strong>
                </h2>
                <hr>

                <div id="carousel-example-generic" class="carousel slide">
                    <!-- Indicators -->
                    <ol class="carousel-indicators hidden-xs">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="3"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="4"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <img class="img-responsive img-full" src="/landing/img/produtos/acai1.png" alt="">
                        </div>
                        <div class="item">
                            <img class="img-responsive img-full" src="/landing/img/produtos/popeye1.jpg" alt="">
                        </div>
                        <div class="item">
                            <img class="img-responsive img-full" src="/landing/img/produtos/decor2.png" alt="">
                        </div>
                        <div class="item">
                            <img class="img-responsive img-full" src="/landing/img/produtos/sand_fillet.jpg" alt="">
                        </div>
                        <div class="item">
                            <img class="img-responsive img-full" src="/landing/img/produtos/decor1.jpg" alt="">
                        </div>
                        
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                        <span class="icon-prev"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                        <span class="icon-next"></span>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="box">
            <div class="col-lg-12">
                <hr>
                <h2 class="intro-text text-center">
                    <strong>por Luiz Cabral - SuperDicas BH</strong>
                </h2>
                <hr>
                <img class="img-responsive img-border img-left" src="/landing/img/intro-pic.jpg" alt="">
                <hr class="visible-xs">
                <p>
                    Descobri o Serra Natural pelo Instagram (@serranatural). As fotos postadas são maravilhosas, e a gente realmente come com os olhos. Fui lá conferir essa pompa toda e, como se não bastasse, me surpreendi. O ambiente é lindo (todo em madeira, com gangorra nas mesas, quadrinhos descolados e decoração sustentável), a música é boa (estava tocando músicas antigas do Guns N’Roses, num clima ótimo!), e o atendimento e as comidinhas são perfeitos! Com uma pegada bem natural, a casa serve saladas de frutas, sucos cremosos, cafés, salgados, coquetéis, saladas, almoço executivo, mas foram o açaí e o sanduíche que ganharam meu coração. No Serra Natural, você pode montar tudo do seu jeito. Acrescentei no meu açaí banana, manga, leite em pó, granola e castanha. Nossa... Ficou sensacional! Poucos açaís na cidade são tão cremosos, viu?! E o que dizer sobre o sanduíche? Também nessa onda de montar, escolhi filé mignon, rúcula, muçarela de búfula, tomatinho cereja, tomate seco e molho de mostarda e mel, tudo num pão australiano bem crocante. Delícia demais! Não preciso nem dizer que virei cliente, né?
                </p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="box">
            <div class="col-lg-12">
                <hr>
                <h2 class="intro-text text-center">
                    <strong>Rádio Serra Natural</strong>
                </h2>
                <hr>
                <p>Se você é um dos nossos clientes que não param de balançar os pésinhos enquanto curte os quitutes no Serra Natural, montamos uma seleção dos nossos melhores sons para você! Curta nossa playlist no Spotify!</p>
                <hr class="visible-xs">
                <iframe src="https://embed.spotify.com/?uri=spotify%3Auser%3A12173842362%3Aplaylist%3A7vPafsb2CIxh2VtHLkFd8T" width="100%" height="300" frameborder="0" allowtransparency="true">
                </iframe>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="box">
            <div class="col-lg-12">
                <hr>
                <h2 class="intro-text text-center">
                    <strong>Horário de funcionamento</strong>
                </h2>
                <hr>
                <div class="row">
                    <table class="table">
                        <thead>
                            <tr>
                                <td class="text-center">Segunda à sexta</td>
                                <td class="text-center">Sábado</td>
                                <td class="text-center">Domingo</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="font-size: 20px">
                                <td class="text-center" >10:00 as 21:00</td>
                                <td class="text-center">10:00 as 20:00</td>
                                <td class="text-center">13:00 as 20:00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    @section('scripts')
	    @parent
	        
		<script type="text/javascript">

		</script>

	@stop

@stop