<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class ReceitaPrato extends Model

{
	public $timestamps = true;

    protected $table = 'receitas_pratos';

    protected $fillable = array('id', 'prato_id', 'produto_id', 'quantidade', 'medida');

	public function produtos()
	{
	return $this->belongsToMany('serranatural\Models\Produto');
	}

}

