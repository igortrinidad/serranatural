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

                                      <span class="fa-stack fa-4x">
                                        <strong class="fa-stack-1x fa-stack-text">12</strong>
                                      </span>

                                      <div class="progress">
                                      <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="70"
                                      aria-valuemin="0" aria-valuemax="100" style="width:70%">
                                        <span class="sr-only">70% Complete</span>
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th class="text-center">20/10/2015</th>
                                                <th class="text-center">20/12/2015</th>
                                            </tr>
                                        </tbody>
                                    </table>


                                        </div>
                        

                                    


                                </div>
                            </div>

                            <div class="panel painel_cadastro paineis">
                                <div class="panel-body">
                                    <h4 class="text-left">Vouchers</h4>


                                    <table class="table">
                                          <col width="50%">
                                            <col width="50%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Vencimento</th>
                                                <th class="text-center">Data utilizado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th class="text-center">20/02/2016</th>
                                                <th class="text-center">--</th>
                                            </tr>
                                        </tbody>
                                    </table>


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