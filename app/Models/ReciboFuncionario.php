<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class ReciboFuncionario extends Model
{
    protected $dates = ['deleted_at', 'created_at'];

    protected $table = 'recibos_funcionarios';

    protected $fillable = [
    						'id',
                            'retiradas',
                            'funcionario_id',
                            'total_debito',
                            'total_credito'
    					];



    public function funcionario()
    {
        return $this->belongsTo('serranatural\Models\Funcionario', 'funcionario_id', 'id');
    }
}
