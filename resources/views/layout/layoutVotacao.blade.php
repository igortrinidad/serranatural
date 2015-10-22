<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Igor Trindade">

    <title>Serra Natural - Votação de prato do dia</title>

    <link href="{!! asset('css/vendor.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/votacao.css') !!}" rel="stylesheet">

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


    @section('scripts')

    <script src="{!! asset('js/vendor.js') !!}"></script>
    <script src="{!! elixir('js/votacao.js') !!}"></script>

    @show


</body>

</html>
