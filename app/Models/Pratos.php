<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class Pratos extends Model
{
    protected $table = 'pratosDoDia';

    public $timestamps = false;

    protected $fillable = array('id', 'prato', 'acompanhamentos', 'modo_preparo', 'foto', 'titulo_foto');

	public function agendaPratos()
	{
		return $this->hasMany('serranatural\Models\AgendaPratos');
	}

	//Relacionamento N x N - Terceiro argumento deve ser o id do Model e o 
	//4 argumento deve ser o id da tabela a ser relacionada
	public function produtos()
	{
		return $this->belongsToMany('serranatural\Models\Produto', 'pratos_produtos', 'prato_id', 'produto_id')->withPivot('quantidade', 'unidade');
	}
}
