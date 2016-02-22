<?php

namespace serranatural\Http\Controllers;

use Illuminate\Http\Request;

use serranatural\Http\Requests;
use serranatural\Http\Controllers\Controller;

use serranatural\Models\Template;
use serranatural\Models\Cliente;

use Mail;
use Flash;

class MarketingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function criarModelo()
    {
        return view('adm.marketing.criarModelo');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function salvarModelo(Request $request)
    {
        Template::create($request->all());

        flash()->success('Modelo de email criado com sucesso.');

        return redirect(route('admin.marketing.lista'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function lista()
    {
        $modelos = Template::all();

        return view('adm.marketing.lista', compact('modelos'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function enviaEmail(Request $request, $id)
    {

        if (!($request->senha == '154986')) {

            flash()->error('Senha errada');

            return redirect()->back();
        }
        $modelo = Template::find($id);

        $variaveis = [
                    '${nomeCliente}',
                    '${emailCliente}',
                    ];

        $clientes = Cliente::all();

        foreach ($clientes as $cliente) {

            $variaveisReais = [
                    $cliente->nome,
                    $cliente->email,
            ];

            $templateAlterado = str_replace($variaveis, $variaveisReais, $modelo->code);

            $data = [
                'nomeCliente' => $cliente->nome,
                'emailCliente' => $cliente->email,
                'assunto' => $modelo->assunto,
                'msg' => $templateAlterado,
            ];

            Mail::queue('emails.marketing.blank', $data, function ($message) use ($data) {

                $message->to($data['emailCliente'], $data['nomeCliente']);
                $message->from('mkt@serranatural.com', 'Serra Natural');
                $message->subject($data['assunto']);
                $message->getSwiftMessage();

            });
        }

        flash()->success('Email enviado com sucesso');

        return redirect(route('admin.marketing.lista'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editaModelo($id)
    {
        $template = Template::find($id);

        return view('adm.marketing.edita', compact('template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateModelo(Request $request, $id)
    {
        $template = Template::find($id);

        $template->assunto = $request->assunto;
        $template->code = $request->code;
        $template->nome = $request->nome;
        $template->save();

        flash()->success('Modelo alterado com sucesso.');

        return redirect()->back();
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
