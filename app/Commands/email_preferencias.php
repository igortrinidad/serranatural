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

class email_preferencias extends Command implements SelfHandling
{
     
        protected $signature = 'email_preferencias';

        protected $description = 'Envia e-mail para os clientes de acordo com a pref.';


    public function handle()
    {
        
        $pratoDoDia = AgendaPratos::where('dataStamp', '=', date('Y-m-d'))
                                    ->first();

        $clientes = Cliente::join('preferenciaClientes', 'clientes.id', '=', 'preferenciaClientes.clienteId')
                            ->where('preferenciaClientes.preferencias', '=', $pratoDoDia->pratos_id)
                            ->get();

        $prato = Pratos::where('id', '=', $pratoDoDia->pratos_id)->first();

        foreach($clientes as $cliente){

        $dados = [

        'prato' => $prato->prato,
        'nomeCliente' => $cliente->nome

        ];

            Mail::send('emails.marketing.pratoDoDia', $dados, function ($message) use ($cliente, $dados)
            {

                $message->to($cliente->email, $cliente->nome);
                $message->from('mkt@serranatural.com', 'Serra Natural');
                $message->subject('Cardápio do dia');
                $message->getSwiftMessage();

            });
        }

    }
}
