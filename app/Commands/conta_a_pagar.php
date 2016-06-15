<?php

namespace serranatural\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\SelfHandling;

use DB;
use Mail;

use serranatural\Models\Pagamento;
use serranatural\Models\LogEmail;

class conta_a_pagar extends Command implements SelfHandling
{
     
        protected $signature = 'conta_a_pagar';

        protected $description = 'Envia e-mail quando há contas a pagar';


    public function handle()
    {
        if(date('d') == '6'){
            $pagamento = Pagamento::create([
                'user_id_cadastro' => 1,
                'descricao' => 'Aluguel do mês: ' . date('m'),
                'vencimento' => date('14/m/Y'),
                'valor' => 0,
                'is_liquidado' => 0
                ]);
        }

        $timestamp = strtotime("+2 days");
        $pagamentos = Pagamento::where('is_liquidado', '=', '0')
                                ->where('vencimento', '<=', date('Y-m-d', $timestamp))
                                ->get();

        if(count($pagamentos) >= 1) {

            $dados = [
                'pagamentos' => $pagamentos
            ];

            Mail::queue('emails.admin.contas', $dados, function ($message) use ($dados)
            {

                $message->to(env('EMAIL_TO'), env('EMAIL_TONAME'));
                $message->cc(env('EMAIL_CC'), env('EMAIL_CCNAME'));
                $message->from(env('EMAIL_FROM'), env('EMAIL_FROMNAME'));
                $message->subject('Contas a pagar');
                $message->getSwiftMessage();

            });

            LogEmail::create([
                'email' => env('EMAIL_TO'),
                'assunto' => 'Contas a pagar',
                'mensagem' => json_encode($dados)
            ]);

    	    return 'Comando rodado com sucesso - email enviado';


        }

	return 'Nenhum pagamento à vencer';

    }
}

