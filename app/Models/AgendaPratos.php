<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class AgendaPratos extends Model
{
    protected $table = 'agendaPratos';

    public $timestamps = true;

    protected $fillable = array('pratos_id', 'dataStr', 'dataStamp', 'ativo');

    public function pratos()
    {
		return $this->belongsTo('serranatural\Models\Pratos');
    }

}
