@extends('landing/template/landing')

@section('conteudo')

    <div class="row">
        <div class="box">

            <hr>
            <h2 class="intro-text text-center">
                <strong>BEM VINDO</strong>
            </h2>
            <hr>

            <iframe src="https://www.google.com/maps/embed?pb=!1m0!3m2!1spt-BR!2sbr!4v1481292965789!6m8!1m7!1sF%3A-jOTxnqmEupc%2FWElm4Onx_zI%2FAAAAAAAAF64%2FarHdjMe58zI9AXdYC-nRnCGu_J7QhLhRgCLIB!2m2!1d-19.98122255332469!2d-43.93946528434753!3f79.6239518401576!4f-2.4485701505543176!5f0.7820865974627469" width="100%" height="500" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
        
    </div>

    <div class="row">
        <div class="box">
            <div class="col-lg-12 text-center">
                
                @include('flash::message')

            	<hr>
                <h2 class="intro-text text-center">
                    <strong>Fotos</strong>
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
                            <img class="img-responsive img-full" src="/landing/img/produtos/acai1.png" alt="Açaí cremoso">
                        </div>
                        <div class="item">
                            <img class="img-responsive img-full" src="/landing/img/produtos/popeye1.jpg" alt="Sucos Detox, Smoothies, Sucos refrescantes">
                        </div>
                        <div class="item">
                            <img class="img-responsive img-full" src="/landing/img/produtos/decor2.png" alt="Ambiente charmoso e descontraído para casais.">
                        </div>
                        <div class="item">
                            <img class="img-responsive img-full" src="/landing/img/produtos/sand_fillet.jpg" alt="Hamburgueria, burguers deliciosos">
                        </div>
                        <div class="item">
                            <img class="img-responsive img-full" src="/landing/img/produtos/decor1.jpg" alt="Linda decoração de restaurante">
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
                <img class="img-responsive img-border img-left" src="/landing/img/intro-pic.jpg" alt="Açaí cremoso da Serra Natural">
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
                <p>
                Criamos uma playlist exclusiva no Spotify para aqueles clientes que não param de balançar os pésinhos enquanto curtem os nossos quitutes. Ouça agora!
                </p>
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
                                <td class="text-center">Segunda à Sexta</td>
                                <td class="text-center">Sábado</td>
                                <td class="text-center">Domingo</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="font-size: 20px">
                                <td class="text-center" >10:00 às 21:00</td>
                                <td class="text-center">10:00 às 20:00</td>
                                <td class="text-center">13:00 às 20:00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <div class="col-lg-12">
                <hr>
                <h2 class="intro-text text-center">
                    <strong>Horário de entrega</strong>
                    <small>Somente no bairro Vila da Serra e Vale do Sereno</small>
                </h2>
                <hr>

                <div class="row">
                    <table class="table">
                        <thead>
                            <tr>
                                <td></td>
                                <td class="text-center">Segunda à Sexta</td>
                                <td class="text-center">Sábado</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="font-size: 20px">
                                <td></td>
                                <td class="text-center" >14:00 às 20:30</td>
                                <td class="text-center">14:00 às 19:30</td>
                                <td></td>
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