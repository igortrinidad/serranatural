<?php

namespace serranatural\Http\Controllers;

use Illuminate\Http\Request;

use serranatural\Http\Requests;
use serranatural\Http\Controllers\Controller;

use serranatural\Models\Cliente;
use serranatural\Models\PontoColetado;
use serranatural\Models\Pratos;
use serranatural\Models\AgendaPratos;
use serranatural\Models\Voucher;

use Carbon\Carbon;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function consultaPontos(Request $request)
    {
        $cliente = Cliente::where('email', '=', $request->email)->first();

        if($cliente)
        {
        $pontosAcai = PontoColetado::where('cliente_id', '=', $cliente->id)
                                ->where('is_valido', '=', 1)
                                ->where('produto', '=', 'Açaí')
                                ->count();

        $pontosAlmoco = PontoColetado::where('cliente_id', '=', $cliente->id)
                                ->where('is_valido', '=', 1)
                                ->where('produto', '=', 'Almoço')
                                ->count();


        $voucherAcai = Voucher::where('cliente_id', '=', $cliente->id)
                                ->where('is_valido', '=', 1)
                                ->where('produto', '=', 'Açaí')
                                ->count();

        $voucherAlmoco = Voucher::where('cliente_id', '=', $cliente->id)
                                ->where('is_valido', '=', 1)
                                ->where('produto', '=', 'Almoço')
                                ->count();

        $getGravatar = get_gravatar($request->email, 100);

        $dados = [

        'nomeCliente' => $cliente->nome,
        'emailCliente' => $cliente->email,
        'pontosAcai' => $pontosAcai,
        'pontosAlmoco' => $pontosAlmoco,
        'voucherAcai' => $voucherAcai,
        'voucherAlmoco' => $voucherAlmoco,
        'tipo_retorno' => 'success',
        'getGravatar' => $getGravatar
        ];

        $return = json_encode($dados);

        $data = $return; // json string

        if(array_key_exists('callback', $_GET)){

            header('Content-Type: application/json; charset=UTF8');
            $callback = $_GET['callback'];
            return $callback.'('.$data.');';

        } else {
            // normal JSON string
            header('Content-Type: application/json; charset=UTF8');

        return $data;

        } 

        } else {
        
            $dados = [
            'msg_retorno' => 'Cadastro não localizado',
            'tipo_retorno' => 'danger'
            ];

            $return = json_encode($dados);

            $data = $return; // json string

            if(array_key_exists('callback', $_GET)){

                header('Content-Type: application/json; charset=UTF-8');
                $callback = $_GET['callback'];
                return $callback.'('.$data.');';

            }else{
                // normal JSON string
                header('Content-Type: application/json; charset=UTF-8');

            return $data;
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function consultaPratoHoje()
    {
        $pratoDoDia = AgendaPratos::where('dataStamp', '=', date('Y-m-d'))
                                    ->first();

        if(!is_null($pratoDoDia))
        {
            $prato = Pratos::where('id', '=', $pratoDoDia->pratos_id)->first();

            $dados = [
                'prato' => $prato->prato,
                'acompanhamentos' => $prato->acompanhamentos,
                'data' => date('d/m/Y')
            ];
            $return = json_encode($dados);

            $data = $return; // json string

            if(array_key_exists('callback', $_GET)){

                    header('Content-Type: application/json; charset=UTF-8');
                    $callback = $_GET['callback'];
                    return $callback.'('.$data.');';

                }else{
                    // normal JSON string
                    header('Content-Type: application/json; charset=UTF-8');

                return $data;
            }

        } else {

            $dados = [
                'prato' => 'surpresa',
                'acompanhamentos' => 'surpresa',
                'data' => date('d/m/Y')
        ];
            $return = json_encode($dados);

            $data = $return; // json string

            if(array_key_exists('callback', $_GET)){

                header('Content-Type: application/json; charset=UTF-8');
                $callback = $_GET['callback'];
                return $callback.'('.$data.');';

            }else{
                // normal JSON string
                header('Content-Type: application/json; charset=UTF-8');

            return $data;

            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function squareTeste(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getToken()
    {
        //
    }

    public function teste()
    {
        $token = '5bDwfv16l7I02iePbc2GcQ';

        $begin = Carbon::createFromFormat('d/m/Y H:i:s', '9/03/2016 06:00:00');
        $begin->addHours(3);
        $begin = $begin->getTimestamp();
        $begin = 'begin_time='.date('Y-m-d\TH:i:s\Z', $begin);

        $end = Carbon::createFromFormat('d/m/Y H:i:s', '9/03/2016 23:59:00');
        $end->addHours(3);
        $end = $end->getTimestamp();
        $end = 'end_time='.date('Y-m-d\TH:i:s\Z', $end);

        \Unirest\Request::defaultHeader("Authorization", "Bearer ".$token);
        \Unirest\Request::defaultHeader("Content-Type", "application/json");

        $response = \Unirest\Request::get("https://connect.squareup.com/v1/me/payments?begin_time=2016-03-16T10:19:08Z&end_time=2016-03-16T19:45:06Z");

        //dd($response);

        $valor = 0;
        $tax = 0;
        $vendas = [];
        $index = 0;
        foreach($response->body as $body) {
            $valor = $valor + $body->net_total_money->amount;
            $tax = $tax + $body->tax_money->amount;
            $vendas[$index]['id'] = $body->id;
            $vendas[$index]['valor'] = $body->total_collected_money->amount;
            $vendas[$index]['data'] = $body->created_at;
            $vendas[$index]['url'] = $body->receipt_url;
        $index++;
        }

        dd($vendas);

        $return['venda_dia'] = $valor - $tax;
        $return['taxa_dia'] = $tax;

        dd($return);

    }
}
