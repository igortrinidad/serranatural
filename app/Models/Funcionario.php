<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $table = 'funcionarios';

    public $timestamps = true;

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
    							'foto'
    							);
}
