<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class Promocoes extends Model
{
	public $timestamps = true;

    protected $table = 'promocoes';

    protected $fillable = array('id', 'clienteId', 'nome_promocao', 'ativo', 'data_inicio', 'data_termino', 'clienteId', 'nomeCliente' );
}
