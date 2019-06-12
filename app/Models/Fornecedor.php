<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
	{
	public $timestamps = true;

    protected $table = 'fornecedores';

    protected $fillable = array('id', 'nome', 'telefone', 'email', 'observacoes');

    public function produtos()
    {
		return $this->belongsToMany('serranatural\Models\Produto');
	}

}
