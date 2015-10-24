@extends('layout/layoutVotacao')

@section('conteudo')


    <section id="cadastro" class="services-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <h1>Cadastro</h1>
                        <p>Olá {{ isset($cliente) ? $cliente->nome : ''}}, altere suas preferências de email.</p>
                        

                        <div class="panel painel_cadastro paineis">
                            <div class="panel-body">

                                <div id="cadastre" class="tab-pane fade in active">

                                	@if(Session::has('msg_retornos'))
									<div class="alert alert-{{Session::get('tipo_retornos')}}">
									     {{Session::get('msg_retornos')}}
									 </div>
									@endif

                                    <img alt="image" class="img-circle block text-center" src="{{get_gravatar($cliente->email, 150)}}"/>

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
                                            <br>Ao desmarcar essa opção você não mais receberá nossos e-mails.</p>
                                        </div>
                                        
                
                                        <div class="form-group">
                                            <button id="votoCadastro" form="votoForm" type="submit" class="btn btn-primary btn-block">Salvar</button>
                                        </div>
                                          

                                    </div>
                                </div>

                                
                            </form>
                                    
                                    
                                
                        
                            </div>
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