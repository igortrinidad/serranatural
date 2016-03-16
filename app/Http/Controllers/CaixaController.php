<?php

namespace serranatural\Http\Controllers;

use Illuminate\Http\Request;

use serranatural\Http\Requests;
use serranatural\Http\Controllers\Controller;

use serranatural\Models\Caixa;
use serranatural\Models\Retirada;
use serranatural\User;

use Carbon\Carbon;

class CaixaController extends Controller
{


    public function index()
    {
        return view('adm.financeiro.fluxocaixa');
    }

    public function consulta()
    {

        $caixa_aberto = Caixa::where('is_aberto', '=', '1')->first();



        if (!is_null($caixa_aberto) or !empty($caixa_aberto)) {

            $retiradas = Retirada::where('caixa_id', '=', $caixa_aberto->id)->get();

            return response()->json([
                    'caixa_aberto' => $caixa_aberto,
                    'retiradas' => $retiradas,
                    'caixa_is_aberto' => 'true'
                ], 200);
        } 

        $init = new Carbon('today');
        $init = $init->format('Y-m-d H:i:s');
        $end = new Carbon('tomorrow');
        $end = $end->format('Y-m-d H:i:s');

        $caixa_anterior = Caixa::whereBetween('created_at', [$init, $end])->orderBy('created_at', 'desc')->first();

        if(!is_null($caixa_anterior) or !empty($caixa_anterior)) {
            return response()->json([
                    'caixa_anterior' => $caixa_anterior,
                    'caixa_is_aberto' => 'false',
                    'turno' => '2',
                ], 200);
        }

        $init = new Carbon('yesterday');
        $init = $init->format('Y-m-d H:i:s');
        $end = new Carbon('today');
        $end = $end->format('Y-m-d H:i:s');

        $caixa_anterior = Caixa::whereBetween('created_at', [$init, $end])->orderBy('created_at', 'desc')->first();
        
        return response()->json([
                'caixa_anterior' => $caixa_anterior,
                'caixa_is_aberto' => 'false',
                'turno' => '1',
            ], 200);

            

    }

    public function consultaVendas()
    {
        $token = '5bDwfv16l7I02iePbc2GcQ';

        $caixa = Caixa::where('is_aberto', '=', '1')->orderBy('created_at', 'DESC')->first();

        $begin = date_create_from_format('d/m/Y H:i:s', $caixa['created_at']);
        $begin = $begin->getTimestamp();
        $begin = 'begin_time='.date('Y-m-d\TH:i:s\Z', $begin);


        $end = new Carbon('now');
        $end = 'end_time'.$end->format('Y-m-d\TH:i:s\Z');

        \Unirest\Request::defaultHeader("Authorization", "Bearer ".$token);
        \Unirest\Request::defaultHeader("Content-Type", "application/json");

        $response = \Unirest\Request::get("https://connect.squareup.com/v1/me/payments?".$begin.'&'.$end);

        //dd($response);

        $valor = 0;
        foreach($response->body as $body) {
            $valor = $valor + $body->net_total_money->amount;
        }
        $tax = 0;
        foreach($response->body as $body) {
            $tax = $tax + $body->tax_money->amount;
        }
        $valor = $valor - $tax;

        $return['venda_dia'] = number_format(($valor/100),2);
        $return['taxa_dia'] = number_format(($tax/100),2);

        return $venda_total = $return;

    }

    public function abreCaixa(Request $request) 
    {

        //dd($request->all());

        $autoriza = User::where('id', '=', \Auth::user()->id)
                    ->where('senha_operacao', '=', $request->senha)
                    ->first();

        if (is_null($autoriza) or empty($autoriza)) {
            return response()->json([
                'retorno' => [
                'type' => 'error',
                'message' => 'Senha errada',
                'title' => 'Atenção'
                ],
            ], 404);
        }

            $caixa = Caixa::create([
                    'vr_abertura' => $request->valor,
                    'user_id_abertura' => \Auth::user()->id,
                    'turno' => $request->turno,
                    'is_aberto' => 1,
                    'dt_abertura' => date('Y-d-m H:i:s')
                ]);

            return response()->json([
                'retorno' => [
                    'type' => 'success',
                    'message' => 'Caixa aberto com sucesso.',
                    'title' => 'Atenção'
                ],
            ], 200);

    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $caixa = Caixa::where('id', '=', $request->id)->first();

        if(!is_null($caixa) or !empty($caixa)) {

            $caixa->update([
                    'user_id_abertura' => $request->user_id_abertura,
                    'user_id_fechamento' => $request->user_id_fechamento,
                    'vr_abertura' => $request->vr_abertura,
                    'vendas' => $request->vendas,
                    'vendas_cielo' => $request->vendas_cielo,
                    'vendas_rede' => $request->vendas_rede,
                    'total_retirada' => $request->total_retirada,
                    'esperado_caixa' => $request->esperado_caixa,
                    'vr_emCaixa' => $request->vr_emCaixa,
                    'turno' => $request->turno,
                    'diferenca_final' => $request->diferenca_final,
                    'is_aberto' => $request->is_aberto
                ]);
        }

        return response()->json([
                'retorno' => [
                    'type' => 'success',
                    'message' => 'Caixa salvo com sucesso.',
                    'title' => 'Atenção!'
                ],
            ], 200);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fecha(Request $request)
    {

        $autoriza = User::where('id', '=', \Auth::user()->id)
                    ->where('senha_operacao', '=', $request->senha)
                    ->first();

        if (is_null($autoriza) or empty($autoriza)) {
            return response()->json([
                'retorno' => [
                'type' => 'error',
                'message' => 'Senha errada!',
                'title' => 'Atenção!'
                ],
            ], 404);
        }

       $caixa = Caixa::where('id', '=', $request->id)->first();

        if(!is_null($caixa) or !empty($caixa)) {

            $caixa->update([
                    'user_id_fechamento' => \Auth::user()->id,
                    'vr_abertura' => $request->vr_abertura,
                    'vendas' => $request->vendas,
                    'vendas_cielo' => $request->vendas_cielo,
                    'vendas_rede' => $request->vendas_rede,
                    'total_retirada' => $request->total_retirada,
                    'esperado_caixa' => $request->esperado_caixa,
                    'vr_emCaixa' => $request->vr_emCaixa,
                    'diferenca_final' => $request->diferenca_final,
                    'dt_fechamento' => date('Y-d-m H:i:s'),
                    'is_aberto' => 0
                ]);
        }

        return response()->json([
                'retorno' => [
                    'type' => 'success',
                    'message' => 'Caixa fechado com sucesso.',
                    'title' => 'Atenção!'
                ],
            ], 200);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
