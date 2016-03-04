<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
	{
	public $timestamps = true;

    protected $table = 'produtos';

    protected $fillable = array('id', 'nome_produto', 'quantidadeEstoque', 'descricao', 'is_ativo', 'preco', 'tracked');

    public function pratododia()
    {
		return $this->belongsToMany('serranatural\Models\Pratos', 'pratos_produtos', 'prato_id', 'produto_id');
	}

	public function fornecedores()
    {
		return $this->belongsToMany('serranatural\Models\Fornecedor');
	}

	public function categoria()
	{
		return $this->belongsTo('serranatural\Models\Categoria');
	}

	public function movimentacoes(){
    	return $this->hasMany('serranatural\Models\Movimentacao');
    }

}
