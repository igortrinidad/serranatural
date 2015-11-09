<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $table = 'funcionarios';

    public $timestamps = true;

    protected $fillable = array('id', 'nome', 'cpf', 'email');
}
