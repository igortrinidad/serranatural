<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class Voto extends Model
{
    protected $table = 'votacaoPratosDoDia';

    protected $fillable = array('id', 'clienteId', 'opcaoEscolhida', 'semanaCorrente', 'diaVoto');

    public function cliente(){
    	return $this->belongsTo('serranatural\Models\Cliente');
    }

}
