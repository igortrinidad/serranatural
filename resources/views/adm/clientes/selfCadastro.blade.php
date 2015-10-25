@extends('layout/layoutVotacao')

@section('conteudo')


    <section id="cadastro" class="services-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <h1>Cadastre-se</h1>
                        <p>Receba novidades e o cardápio do dia em seu email.</p>
                        

                        <div class="panel painel_cadastro paineis">
                            <div class="panel-body text-left">

                                <div id="cadastre" class="tab-pane fade in active">

                                	@if(Session::has('msg_retornos'))
									<div class="alert alert-{{Session::get('tipo_retornos')}}">
									     {{Session::get('msg_retornos')}}
									 </div>
									@endif

                                    <form id="votoForm" action="teste/testeApi" class="form-group" method="POST">
                                        <input form="votoForm" type="hidden" name=".." value="{{{ csrf_token() }}}" />
                                       
                                        <div class="form-group">
                                            <label class="label_form primeiro_label_form">Nome</label>
                                            <input form="votoForm" type="text" name="nome" value="{{ old('nome') }}" class="form-control"/>
                                        </div>

                                        <div class="form-group">
                                            <label class="label_form">Email</label>
                                            <input form="votoForm" type="email" name="email" value="{{ old('email') }}"class="form-control"/>
                                        </div>

                                        <div class="form-group">
                                            <label class="label_form">Telefone</label>
                                            <input form="votoForm" type="text" name="telefone" value="{{ old('telefone') }}"class="form-control phone_with_ddd"/>
                                        </div>
                                        <div class="form-group">
                                            <input form="votoForm" type="checkbox" name="opt_email" value="1" class="checkbox" checked/>
                                            <p class="texto_votacao">Aceito receber informações sobre promoções e novidades da Serra Natural.</p>
                                        </div>

                                        <div class="form-group">
                                            <button id="votoCadastro" form="votoForm" type="submit" class="btn btn-primary botao">Cadastrar e votar!</button>
           
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