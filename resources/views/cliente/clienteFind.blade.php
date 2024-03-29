@extends('layout/layoutVotacao')

@section('conteudo')

<style>
.services-section {
    padding-top: 40px;
    text-align: center;
    padding-bottom: 20px;
    background-image: linear-gradient(160deg, rgba(245, 237, 51, 0.3) 0%, rgba(237, 200, 75, 0.9) 60%);
    height: 100%!important;
}
</style>

    <section id="cadastro" class="services-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <h4>Localize seu cadastro</h4>
                        <div class="form-group">
                            <br><br>
                            <label class="text-left">Email</label>
                            <input type="text" id="email" class="form-control" placeholder="Insira seu email" />
                        </div>

                        <button id="botaoIr" class="btn btn-lg btn-block btn-primary">Localizar</button>
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

        @section('scripts')
            @parent
            
            <script type="text/javascript">
                $('#botaoIr').on('click', function(){
                    window.location.href = 'https://admin.serranatural.com/me/' + $('#email').val();
                })
            </script>

        @stop

@stop