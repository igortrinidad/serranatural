<?php

namespace serranatural\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\SelfHandling;

use DB;
use serranatural\Models\Voto;
use serranatural\Models\LogVoto;

class log_votos extends Command implements SelfHandling
{
     
     protected $signature = 'log_votos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Faz o backup das votações da semana';


    public function handle()
    {
     
        

                function copiaVotos(){

                    $votos = Voto::all();

                    foreach($votos as $voto){

                        LogVoto::create([

                            'clienteId' => $voto->clienteId,
                            'opcaoEscolhida' => $voto->opcaoEscolhida,
                            'semanaCorrente' => $voto->semanaCorrente
                        ]);

                    }

                    return true;
                }

                if(copiaVotos() == true){
                    DB::table('votacaoPratosDoDia')->delete();
                    } else {
                    dd(copiaVotos());
                }

    }

}
        

