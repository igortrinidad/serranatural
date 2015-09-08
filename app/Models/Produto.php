<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
	{
	public $timestamps = true;

    protected $table = 'produtos';

    protected $fillable = array('id', 'nome_produto', 'fornecedorID', 'quantidadeEstoque', 'is_venda', 'is_materiaPrima', 'is_ativo');

    	public function receita(){
		return $this->belongsTo('serranatural\Models\ReceitaPrato');

	}

}
