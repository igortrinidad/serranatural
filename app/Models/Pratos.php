<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class Pratos extends Model
{
    protected $table = 'pratosDoDia';

    protected $fillable = array('pratos', 'acompanhamentos');

}
