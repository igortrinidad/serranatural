<?php

// Funções para trabalho com datas

function calculaPorcentagem($total, $atual){

    $porcentagem = 300 / $total * $atual;

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

?>