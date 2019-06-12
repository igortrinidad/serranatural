<?php

namespace serranatural\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\SelfHandling;

use DB;
use Mail;

use serranatural\Models\PontoColetado;
use serranatural\Models\Cliente;

class check_pontos extends Command implements SelfHandling
{
     
        protected $signature = 'check_pontos';

        protected $description = 'Verifica os pontos atuais';


    public function handle()
    {

        $clientesNaoAtivosComPontos = Cliente::where('is_ativo', '=', 0)->has('pontos')->get();

        foreach($clientesNaoAtivosComPontos as $cliente){
            $cliente->is_ativo = 1;
            $cliente->save();
        }

        $pontosVencidos = PontoColetado::where('vencimento', '<', date('Y-m-d'))->where('is_valido', '=', 1)->get();

        foreach($pontosVencidos as $ponto){
            $ponto->is_valido = 0;
            $ponto->save();
        }

	   return 'Pontos verificados';

    }
}

