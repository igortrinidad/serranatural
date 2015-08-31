<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Igor Trindade">

    <title>Serra Natural - Votação de prato do dia</title>

    <!-- Bootstrap Core CSS -->
    <link href="/css/core/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/css/estilos/scrolling-nav.css" rel="stylesheet">

    <!-- Proprios CSS -->
    <link href="/css/estilos/votacao.css" rel="stylesheet">
    <link href="/css/plugins/bootstrap-toggle.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

<?php
    //ugly workaround for fontawesome issue in Safari
    $ua = $_SERVER["HTTP_USER_AGENT"];
    $safariorchrome = strpos($ua, 'Safari') ? true : false;
    $chrome = strpos($ua, 'Chrome') ? true : false;
    if ($safariorchrome == true AND $chrome == false):
    ?>
    <style type="text/css">
         @font-face{font-family:'FontAwesome';src:url('/css/current-font-awesome/fonts/fontawesome-webfont.eot?v=4.3.0');src:url('/css/current-font-awesome/fonts/fontawesome-webfont.eot?#iefix&v=4.3.0') format('embedded-opentype'),url('/css/current-font-awesome/fonts/fontawesome-webfont.woff2?v=4.3.0') format('woff2'),url('/css/current-font-awesome/fonts/fontawesome-webfont.woff?v=4.3.0') format('woff'),url('/css/current-font-awesome/fonts/fontawesome-webfont.ttf?v=4.3.0') format('truetype'),url('/css/current-font-awesome/fonts/fontawesome-webfont.svg?v=4.3.0#fontawesomeregular') format('svg');font-weight:normal;font-style:normal}
    </style>
    <?php endif; ?> 

</head>

<!-- The #page-top ID is part of the scrolling feature - the data-spy and data-target are part of the built-in Bootstrap scrollspy function -->

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    <!-- Navigation -->


@yield('conteudo')

    <!-- jQuery -->
    <script src="/js/core/jquery-2.1.4.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/js/core/bootstrap.min.js"></script>

    <!-- Toogle Switch JavaScript -->
    <script src="/js/plugins/bootstrap-toggle.min.js"></script>

    <!-- Scrolling Nav JavaScript -->
    <script src="/js/core/jquery.easing.min.js"></script>
    <script src="/js/estilos/scrolling-nav.js"></script>

    <script src="/js/plugins/jquery.mask.min.js"></script>


<script>

$('.phone_with_ddd').mask('(00) 0000-0000');


$('#retorno').attr('onload',function(){
        $( ".painel_teste" ).fadeIn();
        $( "#escurece" ).fadeIn();
    });

    

    setTimeout(function(){
        $( ".painel_teste" ).fadeOut();
        $( "#escurece" ).fadeOut();

    }, 5000);

    $("#fecha").click(function(){
        $( ".painel_teste" ).fadeOut();
        $( "#escurece" ).fadeOut();
    });

$(".botao").click(function(){
        $( "#loading" ).fadeIn();
        $( "#escurece" ).fadeIn();

$(function() {
        var $elie = $(".fa-spinner"), degree = 0, timer;
        rotate();
        function rotate() {

            $elie.css({ WebkitTransform: 'rotate(' + degree + 'deg)'});  
            $elie.css({ '-moz-transform': 'rotate(' + degree + 'deg)'});                      
            timer = setTimeout(function() {
                ++degree; rotate();
            },5);
        }
        }); 
setTimeout(function(){
        $( "#loading" ).fadeOut();
        $( "#escurece" ).fadeOut();
    }, 5000);

    });

setTimeout(function(){
        location.reload();
    }, 500000);

</script>

</body>

</html>
