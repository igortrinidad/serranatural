<?php

namespace serranatural\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\SelfHandling;

use DB;
use serranatural\Models\Promocoes;

class fechamento_promocao extends Command implements SelfHandling
{
     
     	protected $signature = 'fechamento_promocao';

    	protected $description = 'Fecha e inicia nova promo de votação';


    public function handle()
    {
     



                    $ultima = Promocoes::where('nome_promocao', '=', 'Votação')
                    ->orderBy('id', 'desc')
                    ->first();

                    Promocoes::where('nome_promocao', '=', 'Votação')
                    ->where('id', '=', $ultima->id)
                    ->update(['ativo' => 0]);

                    $inicioPromo = date('Y-m-d');
        			$fimPromo = date('Y-m-d', strtotime("+6 days"));

                    $votos = Promocoes::create([
                    	'nome_promocao' => 'Votação',
                    	'data_inicio' => $inicioPromo,
                    	'data_termino' => $fimPromo,
                    	'ativo' => '1'
                    	]);

    }


 }
        

