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



class email_pratoDoDia extends Command implements SelfHandling
{
     
        protected $signature = 'email_pratoDoDia';

        protected $description = 'Envia e-mail para todos os clientes com o prato do dia';


    public function handle()
    {
        
        $pratoDoDia = AgendaPratos::where('dataStamp', '=', date('Y-m-d'))
                                    ->first();

        $clientes = Cliente::where('clientes.opt_email', '=', 1)
                            ->get();

        $prato = Pratos::where('id', '=', $pratoDoDia->pratos_id)->first();

        set_time_limit(900);

        foreach($clientes as $cliente){

        $dados = [

        'prato' => $prato,
        'nomeCliente' => $cliente->nome,
        'emailCliente' => $cliente->email,

        ];

        $mensagem = json_encode($dados);

            Mail::queue('emails.marketing.pratoNovo', $dados, function ($message) use ($cliente, $dados)
            {

                $message->to($cliente->email, $cliente->nome);
                $message->from('mkt@serranatural.com', 'Serra Natural');
                $message->subject('Cardápio do dia');
                $message->getSwiftMessage();

            });

            \serranatural\Models\LogEmail::create([

                'email' => $cliente->email,
                'assunto' => 'Cardapio do dia',
                'mensagem' => $mensagem

                ]);
            
        }

    }
}
