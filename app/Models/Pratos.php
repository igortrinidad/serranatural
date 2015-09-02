<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class Pratos extends Model
{
    protected $table = 'pratosDoDia';

    public $timestamps = false;

    protected $fillable = array('id', 'prato', 'acompanhamentos');

	public function agendaPratos(){
		return $this->hasMany('serranatural\Models\AgendaPratos');

	}

}
