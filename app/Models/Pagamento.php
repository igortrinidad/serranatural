<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    protected $table = 'pagamentos';

    protected $dates = ['created_at'];

    protected $fillable = [
						'id', 
						'linha_digitavel', 
						'descricao', 
						'vencimento', 
						'valor',
						'pagamento', 
						'pagamento_mime', 
						'notaFiscal', 
						'notaFiscal_mime', 
						'is_liquidado',
						'fonte_pgto',
						'user_id_pagamento',
						'user_id_cadastro',
						'data_pgto',
						'observacoes',
                        'valor_pago'
							];

    /*
     * Adiciona o caminho hasheado para o arquivo no registro
     */
    protected $appends = ['arquivo_pagamento', 'arquivo_nota'];

    //url arquivo pagamento
    public function getArquivoPagamentoAttribute()
    {
        if($this->attributes['pagamento'])
        {
            return $this->getFileUrl($this->attributes['pagamento']);
        }

    }

    //url arquivo nota
    public function getArquivoNotaAttribute()
    {
        if($this->attributes['notaFiscal'])
        {
            return $this->getFileUrl($this->attributes['notaFiscal']);
        }

    }

    //get file url
    private function getFileUrl($key) {
        $s3 = \Storage::disk('s3');
        $client = $s3->getDriver()->getAdapter()->getClient();
        $bucket = \Config::get('filesystems.disks.s3.bucket');

        $command = $client->getCommand('GetObject', [
            'Bucket' => $bucket,
            'Key' => $key
        ]);

        $request = $client->createPresignedRequest($command, '+1440 minutes');

        return (string) $request->getUri();
    }


    public function usuario()
    {
    	return $this->belongsTo('serranatural\User', 'user_id', 'id');
    }


	public function setVencimentoAttribute($value) {
	    $date_parts = explode('/', $value);
	    $this->attributes['vencimento'] = $date_parts[2].'-'.$date_parts[1].'-'.$date_parts[0];
	  }

    public function getVencimentoAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    public function setDataPgtoAttribute($value)
    {
	    $date_parts = explode('/', $value);
	    $this->attributes['data_pgto'] = $date_parts[2].'-'.$date_parts[1].'-'.$date_parts[0];
	}

    public function getDataPgtoAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    public function usuarioCadastro(){
        return $this->belongsTo('serranatural\User', 'user_id_cadastro', 'id');
    }

    public function usuarioPagamento(){
        return $this->belongsTo('serranatural\User', 'user_id_pagamento', 'id');
    }

    public function produtos()
    {
    	return $this->hasMany('serranatural\Models\Movimentacao', 'pagamento_id', 'id');
    }


}
