@extends('layout/layoutVotacao')

@section('conteudo')

  <!-- Intro Section -->

    <!-- About Section -->
    <section id="pratos" class="about-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Escolha os pratos da próxima semana</h1>
@foreach($pratos as $prato)
                     <div class="col-md-3">
                        <div class="panel panel paineis">
                            <div class="panel-heading panel-info"><strong>{{$prato->prato}}</strong></div>
                            <div class="panel-body text-center" style="max-height:200px">
                                <input class="panel-body" type="checkbox" name="opcaoEscolhida[]" value="{{$prato->prato}}" data-toggle="toggle" data-on="Quero!" data-off="Escolha" data-onstyle="success"/>
                                <br /><br />
                                <p>Acompanhamentos:</p>
                                <p>{!!nl2br($prato->acompanhamentos)!!}</p>
                            </div>
                        </div>
                        <br />
                    </div>
@endforeach

                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="cadastro" class="services-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <h1>Cadastre-se</h1>
                        <p>Participe de promoções e fique por dentro de nossas novidades</p>
                        <br />

                        <div class="panel panel painel_cadastro paineis">
                                <div class="panel-body text-left">

                        <ul class="nav nav-tabs">
                          <li class="active"><a data-toggle="tab" href="#logar">Login</a></li>
                          <li><a data-toggle="tab" href="#cadastre">Cadastro</a></li>
                        </ul>


                    <div class="tab-content">
                          <div id="logar" class="tab-pane fade in active">

                            <form action="votacao/addVoto" class="form-group">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control"/>
                                </div>


                                <button type="submit" class="btn btn-primary">Votar !</button>


                            </form>

                          </div>

                          <div id="cadastre" class="tab-pane fade">

                            <form action="votacao/addVoto" class="form-group">
                                        <div class="form-group">
                                            <label>Nome</label>
                                            <input type="text" class="form-control"/>
                                        </div>

                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control"/>
                                        </div>

                                        <div class="form-group">
                                            <label>Telefone</label>
                                            <input type="text" class="form-control"/>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Cadastrar e votar!</button>

                            </form>

                          </div>

                      </div>
                          
                          

                            

                                    
                                </div>
                            </div>
        

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="status" class="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <h1>Status</h1>


<?php $i = 0;?>     
@foreach($votos as $voto)
<p class="text-left">{{$voto->opcaoEscolhida}}   {{calculaPorcentagem($totalVotos->total, $voto->qtdVoto)}}%</p>

                            <div class="progress">
                              <div class="progress-bar {{corBarraProgresso($i)}}" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:{{calculaPorcentagem($totalVotos->total, $voto->qtdVoto)}}%">
                                </div>
                            </div>

<?php $i++;?>
@endforeach



                </div>
            </div>
        </div>
    </section>
<a class="page-scroll titulo" href="#cadastro">
<img class="seta" src="/img/botao_seta.png" alt="Próximo"/></a>

@stop