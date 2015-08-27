@extends('layout/layoutVotacao')

@section('conteudo')



  <!-- Logo -->



    <!-- About Section -->
    <section id="pratos" class="about-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">


                    <h1>Você quem manda!</h1>
                    <p>Escolha até 5 pratos que você gostaria para a próxima semana.</p>
@foreach($pratos as $prato)
                     <div class="col-md-3">
                        <div class="panel paineis">
                            <div class="panel-heading panel-info"><strong>{{$prato->prato}}</strong></div>
                            <div class="panel-body text-center" style="max-height:200px">
                                <input form="votoForm" class="panel-body" type="checkbox" name="opcaoEscolhida[]" value="{{$prato->prato}}" data-toggle="toggle" data-on="Quero!" data-off="Escolha" data-onstyle="success"/>
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
                        <p>Participe de nossas promoções e fique por dentro de todas as novidades.</p>
                        <br />

                        <div class="panel painel_cadastro paineis">
                            <div class="panel-body text-left">

                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#cadastre">Quero cadastrar!</a></li>
                                    <li><a data-toggle="tab" href="#logar">Já sou cadastrado</a></li>
                                  
                                </ul>


                            <div class="tab-content">


                                <div id="cadastre" class="tab-pane fade in active">
                                    <form id="votoForm" action="votacao/addVotoCliente" class="form-group" method="POST">
                                        <input form="votoForm" type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                        
                                        <div class="form-group">
                                        
                                            <label class="label_form primeiro_label_form">Nome</label>
                                            <input form="votoForm" type="text" name="nome" class="form-control"/>
                                        </div>

                                        <div class="form-group">
                                            <label class="label_form">Email</label>
                                            <input form="votoForm" type="email" name="emailCadastro" class="form-control"/>
                                        </div>

                                        <div class="form-group">
                                            <label class="label_form">Telefone</label>
                                            <input form="votoForm" type="text" name="telefone" class="form-control"/>
                                        </div>

                                        <div class="form-group">
                                            <button id="votoCadastro" form="votoForm" type="submit" class="btn btn-primary botao" onclick="this.form.action='/votacao/addVotoCadastro'">Cadastrar e votar!</button>
                                    
                                        

                                        </div>
                                </div>

                                <div id="logar" class="tab-pane fade in">
                                    <div class="form-group">
                                            <label class="label_form primeiro_label_form">Email</label>
                                            <input form="votoForm" type="email" name="emailCliente" class="form-control"/>
                                        </div>
                                        <button form="votoForm" type="submit" class="btn btn-primary botao" onclick="this.form.action='/votacao/addVotoCliente'">Votar !</button>
                                </div>

                                
                            </form>
                                    
                                    
                                
                        
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
                    <h1>Os mais votados</h1>
                    <p>Confira os 5 pratos mais votados até o momento.

                    <div class="panel panel painel_cadastro paineis">
                        <div class="panel-body text-left">


<?php $i = 0;?>     
@foreach($votos as $voto)
                        <p class="text-left">{{$voto->opcaoEscolhida}}   {{calculaPorcentagem($totalVotos->total, $voto->qtdVoto)}}%</p>
                            <div class="progress">
                              <div class="progress-bar {{corBarraProgresso($i)}}" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:{{calculaPorcentagem($totalVotos->total, $voto->qtdVoto)}}%">
                                </div>
                            </div>
<?php $i++;?>
@endforeach

                        <p>Exemplo de sorteio:</p>

                            <?php 
                            $sorteio = $votos[mt_rand(0, count($votos) - 1)];
                            echo $sorteio->opcaoEscolhida; 
                            ?>
                         
                        </div>
                    </div>
                
                </div>
            </div>
        </div>
    </section>

    <a class="page-scroll" id="seta" href="#cadastro">
    <img class="seta" src="/img/botao_seta.png" alt="Próximo"/></a>


@if(Session::has('msg_retorno'))
    <div id="retorno">

        <div id="escurece"></div>
        <div class="painel_teste alert alert-{{Session::get('tipo_retorno')}}">

            <a id="fecha"><i class="fa fa-times fa-2x"></i></a>
            
            <div class="alert alert-{{Session::get('tipo_retorno')}} msg_retorno text-center">
                <p>{{Session::get('msg_retorno')}}</p>
            </div>
@endif
        </div>
    </div>

<div id="escurece" hidden="true"></div>
<div id="loading" hidden="true"><i id="spinner" class="fa fa-spinner fa-4x"></i></div>

<div class="fundoLogo">
  <img class="logo" src="/img/logo.png" alt="Serra Natural"/>
</div>

@stop