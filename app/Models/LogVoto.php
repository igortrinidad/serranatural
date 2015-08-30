<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class LogVoto extends Model
{
    protected $table = 'log_votos';

    protected $fillable = array('id', 'clienteId', 'opcaoEscolhida', 'semanaCorrente');

}
