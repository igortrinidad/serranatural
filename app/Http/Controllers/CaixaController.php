<?php

namespace serranatural\Http\Controllers;

use Illuminate\Http\Request;

use serranatural\Http\Requests;
use serranatural\Http\Controllers\Controller;

use serranatural\Models\Caixa;
use serranatural\Models\Retirada;
use serranatural\User;
use serranatural\Models\Produto;

use Mail;
use Carbon\Carbon;

use serranatural\Http\Controllers\Square;

class CaixaController extends Controller
{
    use Square;

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['fetchVendasResume']]);
    }

    public function index()
    {
        return view('adm.financeiro.fluxocaixa');
    }

    public function consulta()
    {

        $caixa_aberto = Caixa::where('is_aberto', '=', '1')->first();

        if ($caixa_aberto) {

            $caixa_anterior = Caixa::where('is_aberto', '=', '0')->orderBy('created_at', 'desc')->first();

            $retiradas = Retirada::where('caixa_id', '=', $caixa_aberto->id)->get();

            $totalRetiradas = Retirada::where('caixa_id', '=', $caixa_aberto->id)->sum('valor');

            $caixa_aberto->total_retirada = $totalRetiradas;
            $caixa_aberto->save();
            return response()->json([
                    'caixa_aberto' => $caixa_aberto,
                    'caixa_anterior' => $caixa_anterior,
                    'retiradas' => $retiradas,
                    'caixa_is_aberto' => 'true'
                ], 200);
        } 

        $caixa_anterior = Caixa::where('is_aberto', '=', '0')->orderBy('created_at', 'desc')->first();
        
        return response()->json([
                'caixa_anterior' => $caixa_anterior,
                'caixa_is_aberto' => 'false',
            ], 200);

    }

    public function consultaVendas()
    {

        $caixa = Caixa::where('is_aberto', '=', '0')->orderBy('dt_fechamento', 'DESC')->first();

        $begin = Carbon::createFromFormat('Y-m-d H:i:s', $caixa['dt_fechamento']);
        $begin->addHours(3);
        $begin = 'begin_time='.$begin->format('Y-m-d\TH:i:s\Z');


        $end = new Carbon('now');
        $end->addHours(3);
        $end = 'end_time='.$end->format('Y-m-d\TH:i:s\Z');

        $response = $this->payments($begin, $end);

        //dd($response);

        $valor = 0;
        $tax = 0;
        $vendas = [];
        $index = 0;
        $vendaLiquida = 0;
        foreach($response->body as $body) {
            $valor = $valor + $body->net_total_money->amount;
            $tax = $tax + $body->tax_money->amount;
            $vendaLiquida = $valor - $tax;
            $vendas[$index]['id'] = $body->id;
            $vendas[$index]['valor'] = $body->total_collected_money->amount;
            $vendas[$index]['data'] = $body->created_at;
            $vendas[$index]['url'] = $body->receipt_url;
        $index++;
        }
        

        $return['vendaBruta'] = number_format(($valor/100),2);
        $return['taxa_dia'] = number_format(($tax/100),2);
        $return['venda_liquida'] = number_format(($vendaLiquida/100),2);
        $return['begin_time'] = $begin;
        $return['end_time'] = $end;
        $return['vendas_apartir'] = $caixa->dt_fechamento->format('d/m/Y H:i:s');
        $return['vendas_resumo'] = $vendas;

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
                    'dt_abertura' => date('Y-m-d H:i:s')
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
                    'is_aberto' => $request->is_aberto,
                    'obs' => $request->obs
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
                    'dt_fechamento' => date('Y-m-d H:i:s'),
                    'obs' => $request->obs,
                    'is_aberto' => 0
                ]);
        }

        //Array para view de email fechamentoCaixaNovo
        $dados = [
            'dt_abertura' => $caixa->dt_abertura->format('d/m/Y H:i:s'),
            'dt_fechamento' => $caixa->dt_fechamento->format('d/m/Y H:i:s'),
            'vendas' => $caixa->vendas,
            'total_retirada' => $caixa->total_retirada,
            'vendas_rede' => $caixa->vendas_rede,
            'vendas_cielo' => $caixa->vendas_cielo,
            'vr_emCaixa' => $caixa->vr_emCaixa,
            'vr_abertura' => $caixa->vr_abertura,
            'diferenca_final' => $caixa->diferenca_final,
            'user_abertura' => $caixa->usuarioAbertura->name,
            'user_fechamento' => $caixa->usuarioFechamento->name,
            'retiradas' => $caixa->retiradas,
            'turno' => $caixa->turno,
            'observacoes' => $caixa->obs
        ];

        $email = Mail::queue('emails.admin.fechamentoCaixaNovo', $dados, function ($message) use ($dados, $caixa) {

            $message->to('contato@maisbartenders.com.br', 'Igor Trindade');
            $message->from('mkt@serranatural.com', 'Serra Natural');
            $message->subject('Fechamento de caixa : ' . $caixa->dt_fechamento->format('d/m/Y H:i:s'));
            $message->getSwiftMessage();

        });

        $caixa_anterior = Caixa::where('is_aberto', '=', '0')->orderBy('created_at', 'desc')->first();

        $response = $this->payments($caixa_anterior->dt_fechamento, $caixa->dt_fechamento);

        foreach($response->body as $venda){
            foreach($venda->itemizations as $item){
                $prod = Produto::where('square_id', '=', $item->item_detail->item_id)->first();
                if($prod){
                    $prod['quantidadeEstoque'] = $prod['quantidadeEstoque'] - $item->quantity;
                    $prod->save();
                }
            }
        }

        return response()->json([
                'retorno' => [
                    'type' => 'success',
                    'message' => 'Caixa fechado com sucesso.',
                    'title' => 'Atenção!',
                    'status_code' => 200
                ],
            ], 200);


    }

    public function historico()
    {
        return view('adm.financeiro.historicoCaixa');
    }

    public function fetchAll()
    {
        $caixas = Caixa::with('usuarioAbertura', 'usuarioFechamento', 'retiradas', 'retiradas.usuario', 'retiradas.funcionario')->orderBy('created_at', 'DESC')->get();

                return response()->json([
                'retorno' => [
                    'type' => 'success',
                    'message' => 'Caixas encontrados.',
                    'title' => 'Ok!',
                    'status_code' => 200,
                ],
                'caixas' => $caixas,
            ], 200);

    }

    public function fetchVendasResume(Request $request)
    {
        //dd($request->all());

        $begin = Carbon::createFromFormat('Y-m-d H:i:s', $request->dt_abertura);
        $begin->addHours(3);
        $begin = 'begin_time='.$begin->format('Y-m-d\TH:i:s\Z');

        $end = Carbon::createFromFormat('Y-m-d H:i:s', $request->dt_fechamento);
        $end->addHours(3);
        $end = 'end_time='.$end->format('Y-m-d\TH:i:s\Z');

        return $this->paymentsResume($begin, $end);
    }

}
