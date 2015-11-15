<?php

namespace serranatural\Http\Controllers;

use Illuminate\Http\Request;

use serranatural\Http\Requests;
use serranatural\Http\Controllers\Controller;

use serranatural\Models\Cliente;
use serranatural\Models\PontoColetado;
use serranatural\Models\Pratos;
use serranatural\Models\AgendaPratos;

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

        $getGravatar = get_gravatar($request->email, 100);

        $dados = [

        'nomeCliente' => $cliente->nome,
        'emailCliente' => $cliente->email,
        'pontosAcai' => $pontosAcai,
        'pontosAlmoco' => $pontosAlmoco,
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
                'prato' => $prato->acompanhamentos,
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
    public function store(Request $request)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
