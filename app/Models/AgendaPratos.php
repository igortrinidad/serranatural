<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class AgendaPratos extends Model
{
    protected $table = 'agendaPratos';

    public $timestamps = true;

    protected $fillable = array('id', 'pratos_id', 'dataStr', 'dataStamp', 'ativo', 'quantidade_venda');

    public function pratos()
    {
		return $this->belongsTo('serranatural\Models\Pratos');
    }

}
