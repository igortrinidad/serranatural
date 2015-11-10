<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Igor Trindade">

    <title>Login - Serra Natural</title>

    <link href="{!! asset('css/vendor.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/login.css') !!}" rel="stylesheet">



</head>

<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
        </div>
        <div class="col-md-4">
            
            <div class="panel panel-default painel-sorteio" id="painel">
                    <div class="panel-heading text-right"><strong>Login</strong></div>
                    <div class="panel-body">
                            <img src="/img/logo_fundotransp.png" width="140px" class="img-responsive text-center logo"/>
                        <div class="formulario">
                            <span class="divisor"></span>

                            @if (count($errors) > 0)
                              <div class="alert alert-danger">
                                <ul>
                                  @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                  @endforeach
                                </ul>
                              </div>
                            @endif

                            <form method="POST" action="/auth/login">
                                {!! csrf_field() !!}

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control"/>
                                </div>

                                <label>Password</label>
                                <input type="password" name="password" id="password" class="form-control"/>
                                
                                <div class="form-group">
                                    <input type="checkbox" name="remember" class="form-control"/> Lembrar-me
                                </div>
                                
                                <div class="botao_login">
                                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                
        </div>
        <div class="col-md-4">
        </div>
    </div>


</div>



    @section('scripts')

    <script src="{!! asset('js/vendor.js') !!}"></script>


        @if (count($errors) > 0)



            <script type="text/javascript">

                $('#painel').jrumble({
                    x: 3,
                    y: 3,
                    rotation: 1
                });
                $('#painel').trigger('startRumble');
                setTimeout(function(){
                    $('#painel').trigger('stopRumble');
                }, 700);
            </script>

        @endif

    @show


</body>

</html>

