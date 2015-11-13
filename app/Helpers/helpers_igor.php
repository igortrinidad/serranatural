<?php

// Funções para trabalho com datas

function calculaPorcentagem($total, $atual){

    $porcentagem = 100 / $total * $atual;

    return substr($porcentagem, 0, 2);
}


function corBarraProgresso($incremento){

    if ($incremento < 5){
        return "progress-bar-success";
    } else {
        return "";
    }
}

function retornaMesPorExtenso($stamp) {
                 $month = array(1=>"Janeiro",
                 2=>"Fevereiro",
                 3=>"Março",
                 4=>"Abril",
                 5=>"Maio",
                 6=>"Junho",
                 7=>"Julho",
                 8=>"Agosto",
                 9=>"Setembro",
                 10=>"Outubro",
                 11=>"Novembro",
                 12=>"Dezembro");
                 
                 $mes = date("n", $stamp);  

         $printme = $month[$mes];
         
         return $printme;
         }


function dataMysqlParaDateTime($data){

    $semana = [
        1=>"Segunda",
        2=>"Terça",
        3=>"Quarta",
        4=>"Quinta",
        5=>"Sexta",
        6=>"Sábado",
        7=>"Domingo",

    ];

    $dia = new DateTime($data);
    $print = $semana[$dia->format('N')];

    return $print;
}


function dataPtBrParaMysql($dataPtBr) {
    $partes = explode("/", $dataPtBr);
    return "{$partes[2]}-{$partes[1]}-{$partes[0]}";
}

function dataMysqlParaPtBr($dataMySql) {
    $partes = explode("-", $dataMySql);
    return "{$partes[2]}/{$partes[1]}/{$partes[0]}";
}

function dataPtBrParaArquivo($dataPtBr) {
    $partes = explode("/", $dataPtBr);
    $ano = substr($partes[2], -2);
    return "{$partes[0]}-{$partes[1]}-{$ano}";
}


function geraTimestamp($data) {
$partes = explode('/', $data);
return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
}

function get_gravatar($email, $s = 80 ) {

    $d = 'mm';
    $r = 'g';
    $img = false;
    $atts = array();

    $url = 'http://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

function primeiro_nome($nome)
{
    $primeiro = Explode(" ",$nome);
    $primeiro_nome = $primeiro[0];

    return $primeiro_nome;
}

