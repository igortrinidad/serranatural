<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{


    protected $table = 'categorias';

    protected $fillable = [
    						'id',
                            'nome',
    					];

    public function produtos()
    {
    	return $this->hasMany('serranatural\Models\Produto');
    }
}
