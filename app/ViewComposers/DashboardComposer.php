<?php namespace serranatural\ViewComposers;


use serranatural\Models\Pagamento;
use serranatural\Models\AgendaPratos;
use serranatural\Models\Pratos;

class DashboardComposer
{

    public function compose($view)
    {
        $pgto_dashboard = Pagamento::where('is_liquidado', '=', 0)->count();

        $pratoDoDia = AgendaPratos::where('dataStamp', '=', date('Y-m-d'))
                                    ->first();     

        $timestampAmanha = strtotime("+1 days");
        $pratoAmanha = AgendaPratos::where('dataStamp', '=', date('Y-m-d', $timestampAmanha))
                                    ->first();

        if(!is_null($pratoDoDia) OR !empty($pratoDoDia))
        {

	        $pratoHoje = Pratos::where('id', '=', $pratoDoDia->pratos_id)->first();

	        $dados['pratoHoje'] = $pratoHoje;

        }

        if(!is_null($pratoAmanha) OR !empty($pratoAmanha))
        {

	        $pratoAmanha = Pratos::where('id', '=', $pratoAmanha->pratos_id)->first();

	        $dados['pratoAmanha'] = $pratoAmanha;

        }

        $dados['pgto_dashboard'] = $pgto_dashboard;

	        $view->with($dados);
    }
}