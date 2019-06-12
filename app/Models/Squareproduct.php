<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class Squareproduct extends Model
	{
	public $timestamps = true;

    protected $table = 'squareproducts';

    protected $fillable = array(
		'id', 
        'square_name', 
        'square_id', 
		'produto_id', 
		'quantidade_por_venda', 
		);

}
