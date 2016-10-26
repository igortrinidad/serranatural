<?php
namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Caixa extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at', 'dt_abertura', 'dt_fechamento'];

    protected $table = 'caixas';

    protected $fillable = [
                            'id',
                            'user_id_abertura',
                            'user_id_fechamento',
                            'vr_abertura',
                            'vendas',
                            'vendas_cash',
                            'vendas_card',
                            'vendas_rede',
                            'vendas_cielo',
                            'vendas_online',
                            'total_retirada',
                            'esperado_caixa',
                            'diferenca_caixa',
                            'diferenca_cartoes',
                            'diferenca_final',
                            'fundo_caixa',
                            'dt_abertura',
                            'dt_fechamento',
                            'is_aberto',
                            'turno',
                            'vr_emCaixa',
                            'obs'
                            ];


    public function retiradas()
    {
        return $this->hasMany('serranatural\Models\Retirada');
    }

    public function usuarioAbertura()
    {
        return $this->belongsTo('serranatural\User', 'user_id_abertura', 'id');
    }

    public function usuarioFechamento()
    {
        return $this->belongsTo('serranatural\User', 'user_id_fechamento', 'id');
    }

}
