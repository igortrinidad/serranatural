<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Igor Trindade">

    <title>Login - Serra Natural</title>

    <!-- Bootstrap Core CSS -->
    <link href="/css/core/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/css/estilos/login.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <div class="row">

                <div class="panel panel-default painel-sorteio" id="painel">
                    <div class="panel-heading text-right"><strong>Login</strong></div>
                    <div class="panel-body">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <img src="img/logo_fundotransp.png" width="140px" class="img-responsive text-center logo"/>
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
                        <div class="col-md-1"></div>
                        </div>

                </div>

            </div>
        </div>
        <div class="col-md-3"></div>

    </div>

</div>



    <!-- jQuery -->
    <script src="/js/core/jquery-2.1.4.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/js/core/bootstrap.min.js"></script>


</body>

</html>
