<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Serra Natural - O melhor açaí de Minas Gerais</title>

    
    <!-- VENDOR STYLES -->
    <link href="{!! asset('landing/css/vendor.css') !!}" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->



</head>

<body>

<style>
        .active, .active:hover{
            font-weight: 600 !important;
            color: #222222 !important;
        }

    </style>

    <div class="brand">Serra Natural</div>
    <div class="address-bar">Alameda do Ingá, 754 - Vila da Serra - Nova Lima - Brasil</div>

    <!-- Navigation -->
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- navbar-brand is hidden on larger screens, but visible when the menu is collapsed -->
                <a class="navbar-brand" href="index.html">Serra Natural</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">

                    <li>
                        <a {!! Request::is('/') ? ' class="active"' : null !!} href="/">Home</a>
                    </li>
                    <li>
                        <a {!! Request::is('cardapio') ? ' class="active"' : null !!} href="/cardapio">Cardápio</a>
                    </li>
                    <li>
                        <a {!! Request::is('promocoes') ? ' class="active"' : null !!} href="/promocoes">Promoções</a>
                    </li>
                    <li>
                        <a {!! Request::is('fidelidade') ? ' class="active"' : null !!} href="/fidelidade">Fidelidade</a>
                    </li>
                    <li>
                        <a {!! Request::is('contato') ? ' class="active"' : null !!} href="/contato">Contato</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <div class="container">
                    
        @yield('conteudo')

    <div class="row">
        <div class="box">
            <div id="map" style="width:100%;height:500px"></div>
        </div>
        
    </div>

    </div>
    <!-- /.container -->

    

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p>Copyright &copy; Serra Natural 2016.
                        <br>
                        Alameda do Ingá, 754, Vila da Serra - Nova Lima.
                        <br>
                        31 3658-8052 | <i class="fa fa-whatsapp"></i> 98282-8052
                        <br>
                    </p>
                </div>
            </div>
        </div>
    </footer>


    <!-- SCRIPTS -->
    @section('scripts')

        <script src="{!! asset('landing/js/vendor.js') !!}"></script>

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBJ5ANKHZZw8pasBTic7V62VI7HVGdZaX4&callback=initMap"
    async defer></script>


    @show

    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })



      function initMap() {
          var myLatLng = {lat: -19.980827, lng: -43.939483};

          var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: myLatLng,
            scrollwheel: false,
            draggable: false,
            mapTypeControl: false,
          });

          var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: 'Hello World!'
          });

          var contentString = 
          '<div>'+
            '<h4>Serra Natural</h4>'+
            '<p>Alameda do Ingá, 754<p>'+
            '<p>Vila da Serra - Nova Lima<p>'+
            '<p>31 3658-8052 | 98282-8052<p>'+
          '</div>'

          var infowindow = new google.maps.InfoWindow({
            content: contentString,
            maxWidth: 200
          });

          setTimeout( function(){
            infowindow.open(map, marker);
        }, 3000)
        }



      

      

    </script>

</body>

</html>
