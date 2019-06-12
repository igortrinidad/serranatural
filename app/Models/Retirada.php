<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Retirada extends Model
{
    use SoftDeletes;

    protected $dates = ['init', 'end', 'deleted_at', 'created_at', 'autorizado_quando'];

    protected $table = 'retiradas';

    protected $fillable = [
    						'id',
                            'user_id',
    						'caixa_id',
    						'funcionario_id',
    						'descricao',
                            'valor',
                            'motivo',
    						'is_debito',
                            'fonte_pgto',
                            'init',
                            'end',
                            'tipo',
                            'autorizado_por',
                            'autorizado_quando',
    					];



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

    public function autorizado()
    {
        return $this->belongsTo('serranatural\User', 'autorizado_por', 'id');
    }
}

