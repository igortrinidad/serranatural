<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Igor Trindade">

    <title>Serra Natural - Administração</title>

    <!-- Bootstrap Core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Proprios CSS -->
    <link href="/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link href="/css/estilosADM.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="/css/font-awesome.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
  <div class="container">

  <nav class="navbar navbar-default">
    <div class="container-fluid">

    <div class="navbar-header">      
      <a class="navbar-brand" href="/adm">Adm Serra Natural</a>
    </div>



 

        @if (Auth::guest())
        <ul class="nav navbar-nav navbar-right">
          <li><a href="/auth/login">Login</a></li>
        </ul>
          @else

      <ul class="nav navbar-nav navbar-left">
          <li><a href="">{{date('H:i:s')}}</a></li>
        </ul>

      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Produtos<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="/adm/produtos/pratos">Pratos</a></li>
            <li><a href="#">Sorteio</a></li>
            <li><a href="#">Matéria prima</a></li>
          </ul>
        </li>

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Promoções<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="/adm/promocoes">Dashboard</a></li>
            <li><a href="#">Configurações</a></li>
            <li><a href="#">Matéria prima</a></li>
          </ul>
        </li>


        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="/adm/usuario">Configurações</a></li>
            <li><a href="/auth/logout">Logout</a></li>
          </ul>
        </li>
        @endif
      </ul>

    </div>
  </nav>

    @yield('conteudo')

<div class="jumbotron rodape">
  <footer class="footer">
      <p>© Administração Serra Natural.</p>
  </footer>
  </div>

  </div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/js/jquery-2.1.4.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="/js/bootstrap.min.js"></script>

<script src="/js/bootstrap-toggle.min.js"></script>


</body>
</html>