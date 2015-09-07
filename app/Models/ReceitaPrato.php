<?php

namespace serranatural;

use Illuminate\Database\Eloquent\Model;

class ReceitaPrato extends Model

{
	public $timestamps = true;

    protected $table = 'receitas_pratos';

    protected $fillable = array('id', 'prato_id', 'produto_id', 'quantidade', 'medida', 'modo_preparo');
}

