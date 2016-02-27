<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class Movimentacao extends Model
{
    protected $table = 'movimentacoes_produtos';

    protected $dates = ['created_at'];

    protected $fillable = [
    	'id',
    	'produto_id',
    	'user_id',
    	'type',
    	'quantity'
    ];

    public function produto()
    {
    	return $this->belongsTo('serranatural\Models\Produto');
    }

    public function usuario()
    {
    	return $this->belongsTo('serranatural\User', 'user_id');
    }
}
