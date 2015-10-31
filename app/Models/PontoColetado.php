<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes as SoftDeletes;

class PontoColetado extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'pontos_coletados';

    protected $fillable = [
    						'id',
    						'cliente_id',
    						'data_coleta',
    						'voucher_id',
    						'vencimento',
                            'is_valido',
    						'produto',
    					];

    public function cliente(){
        return $this->belongsTo('serranatural\Models\Cliente', 'cliente_id', 'id');
    }


    public function getDataColetaAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    public function getVencimentoAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d/m/Y H:i:s', strtotime($value));
    }

}
