<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Funcionario extends Model
{
    protected $table = 'funcionarios';

    public $timestamps = true;

    protected $dates = ['dt_inicio'];

    protected $fillable = array(
    							'id', 
    							'nome', 
    							'cpf',
    							'identidade',
    							'email',
    							'telefone',
    							'endereco',
    							'horario_trabalho',
    							'observacoes',
    							'transporte',
    							'vr_transporte',
    							'vr_salario',
    							'cargo',
    							'dt_inicio',
    							'foto',
                                'is_ativo'
    							);


    public function retirada()
    {
        return $this->hasMany('serranatural\Models\Retirada');
    }

    public function recibos()
    {
        return $this->hasMany('serranatural\Models\ReciboFuncionario', 'funcionario_id', 'id');
    }

    public function setDtInicioAttribute($value)
    {
        return $this->attributes['dt_inicio'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

}

