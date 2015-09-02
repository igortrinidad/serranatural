<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class Voto extends Model
{
    protected $table = 'votacaoPratosDoDia';

    protected $fillable = array('id', 'clienteId', 'opcaoEscolhida', 'semanaCorrente', 'diaVoto', 'promocaoID', 'pratos_id');

    public function cliente()
    {
    	return $this->belongsTo('serranatural\Models\Cliente');
    }

        public function pratos()
    {
    	return $this->belongsTo('serranatural\Models\Pratos');
    }

}
