<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class Balanco extends Model
{

    protected $dates = ['created_at'];

    protected $table = 'balancos';

    protected $fillable = [
                            'id',
                            'lista',
                            'user_id'
                            ];

    public function usuario()
    {
        return $this->belongsTo('serranatural\User', 'user_id', 'id');
    }

}

