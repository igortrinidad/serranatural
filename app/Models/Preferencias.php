<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class Preferencias extends Model
{

	public $timestamps = true;

    protected $table = 'preferenciaClientes';

    protected $fillable = array('id', 'clienteId', 'preferencias');
}
