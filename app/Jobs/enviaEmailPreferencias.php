<?php

namespace serranatural\Jobs;

use serranatural\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

use DB;
use Mail;

use serranatural\Models\Pratos;
use serranatural\Models\AgendaPratos;
use serranatural\Models\Cliente;


class enviaEmailPreferencias extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
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
