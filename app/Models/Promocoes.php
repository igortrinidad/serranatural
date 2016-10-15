<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Promocoes extends Model
{
	public $timestamps = true;

    protected $table = 'promocoes';

    protected $dates = ['inicio', 'fim'];

    protected $fillable = [
    	'titulo',
    	'inicio',
    	'fim',
    	'descricao',
        'regulamento',
    	'foto',
    	'is_ativo'
    ];

    public function setInicioAttribute($value)
    {
        return $this->attributes['inicio'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function setFimAttribute($value)
    {
        return $this->attributes['fim'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getInicioAttribute($value)
    {
        return $this->attributes['inicio'] = Carbon::createFromFormat('Y-m-d', $value)->format('d/m/Y');
    }

    public function getFimAttribute($value)
    {
        return $this->attributes['fim'] = Carbon::createFromFormat('Y-m-d', $value)->format('d/m/Y');
    }
}
