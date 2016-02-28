<?php

namespace serranatural\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\SelfHandling;

use DB;
use Mail;

use serranatural\Models\Pagamento;

class conta_a_pagar extends Command implements SelfHandling
{
     
        protected $signature = 'command_contas_a_pagar';

        protected $description = 'Envia e-mail quando há contas a pagar';


    public function handle()
    {
        $timestamp = strtotime("-1 day");
        $pagamentos = Pagamento::where('is_liquidado', '=', '0')
                                ->where('vencimento', '<=', date('Y-m-d', $timestamp))
                                ->get();

        if(!$pagamentos) {
            return 'Não há pagamentos';
        }

        $dados = [
        'pagamentos' => $pagamentos
        ];

        Mail::queue('emails.admin.contas', $dados, function ($message) use ($dados)
        {

            $message->to('contato@serranatural.com', 'Serra Natural');
            $message->cc('comercial@maisbartenders.com.br', 'Comercial Mais Bartenders');
            $message->from('mkt@serranatural.com', 'Serra Natural');
            $message->subject('Contas a pagar');
            $message->getSwiftMessage();

        });

            
    }
}