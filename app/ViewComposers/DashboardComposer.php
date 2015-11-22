<?php namespace serranatural\ViewComposers;


use serranatural\Models\Pagamento;

class DashboardComposer
{

    public function compose($view)
    {
        $pgto_dashboard = Pagamento::where('is_liquidado', '=', 0)->count();

        $dados = [
        	'pgto_dashboard' => $pgto_dashboard,
        ];

        $view->with($dados);
    }
}