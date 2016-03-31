<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    protected $table = 'pagamentos';

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
						'observacoes'
							];

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


}
