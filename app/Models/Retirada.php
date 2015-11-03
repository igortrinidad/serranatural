<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Retirada extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'retiradas';

    protected $fillable = [
    						'id',
    						'user_id',
    						'caixa_id',
    						'descricao',
    						'motivo',
    						'valor',
    					];

    public function getCreatedAtAttribute($value)
    {
        return date('d/m/Y H:i:s', strtotime($value));
    }

    public function retiradas(){
        return $this->hasMany('serranatural\Models\Retirada');
    }
}
