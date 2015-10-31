<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'vouchers';

    protected $fillable = [
    						'id',
    						'cliente_id',
    						'data_voucher',
    						'voucher_id',
    						'vencimento',
    						'data_utilizado',
                            'is_valido',
    						'produto',
    						
    					];

    public function getVencimentoAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    public function getDataUtilizadoAttribute($value)
    {
        if($value <= '2001-01-01')
        {
            return '--';
        }

        return date('d/m/Y', strtotime($value));
    }

    public function cliente(){
        return $this->belongsTo('serranatural\Models\Cliente', 'cliente_id', 'id');
    }
}
