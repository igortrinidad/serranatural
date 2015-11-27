<?php

namespace serranatural\Http\Controllers;

use Illuminate\Http\Request;
use serranatural\Http\Requests;
use serranatural\Http\Controllers\Controller;

use serranatural\Models\Cliente;
use serranatural\Models\Pratos;
use serranatural\Models\AgendaPratos;

use Mail;

class TesteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ['nada' => 'nada'];

           Mail::queue('teste.testeEmail', $data, function ($message) use ($data)
               {

                   $message->to('contato@maisbartenders.com.br', 'Igor Trindade');
                   $message->from('mkt@serranatural.com', 'Serra Natural');
                   $message->subject('Teste templates');
                   $message->getSwiftMessage();

               });

        return view('emails.marketing.voucherColetado');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    public function summernote(Request $request)
    {

        $insert = Cliente::create($request->all());

        if($insert)
        {
            $dados = [
            'msg_retorno' => 'Usuário ' . $insert->nome . ' cadastrado com sucesso.',
            'tipo_retorno' => 'success'
            ];

            return $dados;
        } 
            
            $dados = [
            'msg_retorno' => 'Usuário não foi cadastrado com sucesso.',
            'tipo_retorno' => 'error'
            ];

            return $dados;
    }

    public function testeEmail()
    {

        $pratoDoDia = AgendaPratos::where('dataStamp', '=', date('Y-m-d'))
                                    ->first();

        $prato = Pratos::where('id', '=', $pratoDoDia->pratos_id)->first();

        $dados = [

        'prato' => $prato,

            ];

        return view('emails.marketing.pratoNovo')->with($dados);

    }
}
