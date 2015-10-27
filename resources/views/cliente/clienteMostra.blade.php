@extends('layout/layoutVotacao')

@section('conteudo')


    <section id="cadastro" class="services-section">
        <div class="container">

                        <h1>Cadastro</h1>
                        <p>Olá <strong>{{ isset($cliente) ? $cliente->nome : ''}}</strong>, confira seus pontos e cadastro.</p>
                        

            <div class="row">
                <div class="col-lg-1"></div>
                    <div class="col-lg-6">

                        <div class="panel painel_cadastro paineis">
                            <div class="panel-body">
                                <h4 class="text-left">Dados</h4>

                                	@if(Session::has('msg_retorno'))
									<div class="alert alert-{{Session::get('tipo_retorno')}}">
									     {{Session::get('msg_retorno')}}
									 </div>
									@endif

                                    <img class="img-circle block text-center" src="{{get_gravatar($cliente->email, 150)}}" alt="Não tem avatar? Adicione um pelo serviço Gravatar" title="Não tem avatar? Adicione um pelo serviço Gravatar.com" />

                                    
                                    @yield('formEditaOuMostra')
                                        

                                    </div>
                                </div>
 
                        </div>

                        <div class="col-lg-4">

                            <div class="panel painel_cadastro paineis">
                                <div class="panel-body">
                                    <h4 class="text-left">Pontos</h4>
                                    
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6 text-center">
                                            <p>Açaí</p>
                                        </div>
                                        <div class="col-md-6 text-center">
                                            <p>Almoço</p>
                                        </div>
                                    </div>

                                        <div class="row">
                                            <div class="col-md-6 text-center">
                                                <p style="font-weight:700;font-size:50px">{{$qtdPontosAcai}}
                                            </div>
                                            <div class="col-md-6 text-center">
                                                <p style="font-weight:700;font-size:50px">{{$qtdPontosAlmoco}}
                                            </div>
                                        </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="70"
                                                    aria-valuemin="0" aria-valuemax="100" style="width:{{calculaPorcentagem(15, $qtdPontosAcai)}}%">
                                                    <span class="sr-only">70% Complete</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">                                            <div class="progress">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="70"
                                                    aria-valuemin="0" aria-valuemax="100" style="width:{{calculaPorcentagem(15, $qtdPontosAlmoco)}}%">
                                                    <span class="sr-only">70% Complete</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                            
                                      <div class="" data-toggle="collapse" data-target="#demo"> Seus pontos <i class="fa fa-chevron-down"></i></div>
                                      <div id="demo" class="collapse">
                                            
                                            <table class="table">
                                          <col width="50%">
                                            <col width="50%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Compra</th>
                                                <th class="text-center">Vencimento</th>
                                                <th class="text-center">Produto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($pontosAll as $ponto)
                                            <tr>
                                                <th class="text-center">{{$ponto->data_coleta}}</th>
                                                <th class="text-center">{{$ponto->vencimento}}</th>
                                                <th class="text-center">{{$ponto->produto}}</th>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>


                                        </div>
                        

                                    


                                </div>
                            </div>

                            <div class="panel painel_cadastro paineis">
                                <div class="panel-body">
                                    <h4 class="text-left">Vouchers</h4>


                                    <table class="table">
                                          <col width="10%">
                                            <col width="45%">
                                            <col width="50%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ID</th>
                                                <th class="text-center">Produto</th>
                                                <th class="text-center">Vencimento</th>
                                                <th class="text-center">Data utilizado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($vouchers as $voucher)
                                            <tr>
                                                <th class="text-center">{{$voucher->id}}</th>
                                                <th class="text-center">{{$voucher->produto}}</th>
                                                <th class="text-center">{{$voucher->vencimento}}</th>
                                                <th class="text-center">@if($voucher->data_utilizado <= '2015-01-01'){{$voucher->data_utilizado}} @endif</th>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>


                                </div>
                            </div>



                        </div>
             
            </div>
            
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                    <div class="panel painel_cadastro paineis">
                        <div class="panel-body">
                            <h4 class="text-left">Regulamento</h4>
                            <p>O cliente Serra Natural pode coletar pontos a cada compra.</p>

                        </div>
                    </div>
                </div>
            </div>



        </div>
</section>


@if (count($errors) > 0)
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div id="escurece" hidden="true"></div>
<div id="loading" hidden="true"><i id="spinner" class="fa fa-spinner fa-4x"></i></div>

<div class="fundoLogo">
  <img class="logo" src="/img/logo.png" alt="Serra Natural"/>
</div>

@stop