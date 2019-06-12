<?php
namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conferencia extends Model
{

    protected $dates = ['deleted_at', 'dt_abertura', 'dt_fechamento'];

    protected $table = 'conferencias';

    protected $fillable = [
                            'id',
                            'caixa_id',
                            'user_id',
                            'user_conf_id',
                            'vr_abertura',
                            'dt_abertura',
                            'vendas',
                            'vendas_rede',
                            'vendas_cielo',
                            'total_retirada',
                            'diferenca_final',
                            'vr_emCaixa',
                            'dt_abertura',
                            'turno',
                            'obs'
                            ];


    public function usuario()
    {
        return $this->belongsTo('serranatural\User', 'user_id', 'id');
    }

    public function usuarioConferencia()
    {
        return $this->belongsTo('serranatural\User', 'user_conf_id', 'id');
    }

    public function Caixa()
    {
        return $this->belongsTo('serranatural\Models\Caixa', 'caixa_id', 'id');
    }

}
