<?php

namespace serranatural\Providers;

use Illuminate\Support\ServiceProvider;

use serranatural\Models\Pagamento;
use serranatural\Models\AgendaPratos;
use serranatural\Models\Pratos;

class DashboardProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('adm.dashboard.index', function($view)
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
        });


        view()->composer('layout.admin', function($view) {

            $timestamp = strtotime("+1 day");
            $pgto_vencido = Pagamento::where('is_liquidado', '=', 0)
                ->where('vencimento', '<=', date('Y-m-d', $timestamp))
                ->count();

            $pgto_incompleto = Pagamento::where('is_liquidado', '=', 0)
                ->where('pagamento', '=', '')
                ->count();

            $dados['pgto_vencido'] = $pgto_vencido;
            $dados['pgto_incompleto'] = $pgto_incompleto;
            
            $view->with($dados);
        });

        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
