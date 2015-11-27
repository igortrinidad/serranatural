<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class Pratos extends Model
{
    protected $table = 'pratosDoDia';

    public $timestamps = false;

    protected $fillable = array('id', 'prato', 'acompanhamentos', 'modo_preparo', 'foto', 'titulo_foto');

	public function agendaPratos(){
		return $this->hasMany('serranatural\Models\AgendaPratos');

	}

}
