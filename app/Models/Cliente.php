<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = array('id', 'nome', 'email', 'telefone');

    public function preferencias(){
		return $this->hasMany('serranatural\Models\Voto');
	}

}
