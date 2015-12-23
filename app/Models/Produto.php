<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
	{
	public $timestamps = true;

    protected $table = 'produtos';

    protected $fillable = array('id', 'nome_produto', 'quantidadeEstoque', 'descricao', 'is_ativo', 'preco');

    public function pratododia()
    {
		return $this->belongsToMany('serranatural\Models\Pratos', 'pratos_produtos', 'prato_id', 'produto_id');
	}

	public function fornecedores()
    {
		return $this->belongsToMany('serranatural\Models\Fornecedor');
	}

}
