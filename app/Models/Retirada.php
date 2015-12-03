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
    						'funcionario_id',
    						'descricao',
                            'valor',
    						'motivo',
    					];

    public function getCreatedAtAttribute($value)
    {
        return date('d/m/Y H:i:s', strtotime($value));
    }

    public function funcionario()
    {
        return $this->belongsTo('serranatural\Models\Funcionario', 'funcionario_id', 'id');
    }

    public function usuario()
    {
        return $this->belongsTo('serranatural\User', 'user_id', 'id');
    }

    public function caixa()
    {
        return $this->belongsTo('serranatural\Models\Caixa', 'caixa_id', 'id');
    }
}

