<?php

namespace serranatural\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\SelfHandling;

use DB;
use Mail;

use serranatural\Models\Pratos;
use serranatural\Models\AgendaPratos;
use serranatural\Models\Promocoes;
use serranatural\Models\Voto;
use serranatural\Models\Cliente;
use serranatural\Models\Funcionario;



class email_Microcity extends Command implements SelfHandling
{
     
        protected $signature = 'email_Microcity';

        protected $description = 'Envia e-mail para os clientes com email Microcity com o prato do dia';


    public function handle()
    {
        
        Funcionario::create([
                'nome' => 't1';
            ]);

    }
}
