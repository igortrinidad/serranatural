<?php

namespace serranatural\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\Storage;
use serranatural\Models\Pagamento;

class AwsMigration extends Command implements SelfHandling
{

    protected $signature = 'aws-migration';

    protected $description = 'Move os arquivos enviados para a Amazon';

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {

        $this->info('Files migration started');

        //Lê todos os arquivos no disco local
        $files = Storage::disk('pagamentos')->listContents();

        //path no bucket
        $path = 'financeiro/pagamentos/';

        //progress bar
        $bar = $this->output->createProgressBar(count($files));

        //handle upload
        foreach ($files as $file) {

            $filename = $file['basename'];

            //verifica qual é o tipo do arquivo (pagamento / nota)
            $arquivoPagamento = Pagamento::wherePagamento($filename)->first();
            $arquivoNota = Pagamento::where('notaFiscal', $filename)->first();

            //pega o arquivo no disco
            $file = Storage::disk('pagamentos')->get($filename);

            //envia o arquivo para o bucket s3
            $upload = Storage::disk('s3')->put($path. $filename, $file);

            if($upload){

                //se for arquivo de pagamento, atualiza o caminho.
                if($arquivoPagamento){
                    $arquivoPagamento->pagamento = $path.$filename;
                    $arquivoPagamento->save();
                }

                //se for arquivo de nota, atualiza o caminho.
                if($arquivoNota){
                    $arquivoNota->notaFiscal = $path.$filename;
                    $arquivoNota->save();
                }

                $bar->advance();

            }else{

                $this->error($filename . ' sent failed');
            }
        }

        $bar->finish();
    }
}
